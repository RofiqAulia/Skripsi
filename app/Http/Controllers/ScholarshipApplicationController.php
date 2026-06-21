<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudy;
use App\Models\PspApplication;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipApplicationController extends Controller
{
    // ──────────────────────────────────────────────
    // LIST — halaman utama Scholarship Application
    // ──────────────────────────────────────────────

    public function index()
    {
        $user = Auth::user();

        $applications = $user->scholarshipApplications()
            ->with([
                'programStudy',
                'pspApplication',
                'logs' => fn ($q) => $q->orderBy('log_date')->orderBy('id'),
            ])
            ->latest('updated_date')
            ->get();

        // Data untuk form dropdown
        $programStudies = ProgramStudy::approved()->orderBy('name')->get();

        // Stats
        $statsTotal     = $applications->count();
        $statsLolos     = $applications->filter(fn($app) => $app->display_status === 'lolos')->count();
        $statsPending   = $applications->filter(fn($app) => $app->display_status === 'pending')->count();
        $statsTidakLolos = $applications->filter(fn($app) => $app->display_status === 'tidak_lolos')->count();
        // Current PSP Application program study
        $pspApp = $user->pspApplication;
        $pspProgram = $pspApp?->studyPlan?->program;

        $mySuggestions = ProgramStudy::where('submitted_by', $user->id)->orderBy('created_at', 'desc')->get();

        return view('landing.scholarship-application', compact(
            'applications',
            'programStudies',
            'statsTotal',
            'statsLolos',
            'statsPending',
            'statsTidakLolos',
            'pspApp',
            'pspProgram',
            'mySuggestions'
        ));
    }

    // ──────────────────────────────────────────────
    // STORE — buat aplikasi baru + log entry pertama
    // ──────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'program_study_id' => 'required|exists:program_studies,id',
            'university'       => 'nullable|string|max:255',
            'stage'            => 'required|in:' . implode(',', array_keys(ScholarshipApplication::STAGES)),
            'status'           => 'required|in:' . implode(',', array_keys(ScholarshipApplication::STATUSES)),
            'updated_date'     => 'required|date',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $userPsp = Auth::user()->pspApplication;
        if (!$userPsp || $userPsp->status !== 'approved') {
            return back()->withErrors(['error' => 'Your PSP Application must be approved before you can add a scholarship application.'])->withInput();
        }

        // Cek duplikasi
        $exists = ScholarshipApplication::where([
            'user_id'          => Auth::id(),
            'program_study_id' => $request->program_study_id,
        ])->exists();

        if ($exists) {
            return back()
                ->withErrors(['duplicate' => 'You have already applied for this study program. Use the "Add Stage" button to update your progress.'])
                ->withInput();
        }

        $programStudy = ProgramStudy::findOrFail($request->program_study_id);

        // Auto-link ke PSP jika program studi sama
        $pspApp = PspApplication::where('user_id', Auth::id())
            ->whereHas('studyPlan', fn ($q) => $q->where('program_study_id', $request->program_study_id))
            ->first();

        $application = ScholarshipApplication::create([
            'user_id'            => Auth::id(),
            'scholarship_id'     => null, // Set to null since scholarships table is deleted
            'program_study_id'   => $request->program_study_id,
            'psp_application_id' => $pspApp?->id,
            'university'         => $request->university ?? $programStudy->university,
            'current_stage'      => $request->stage,
            'status'             => $request->status,
            'updated_date'       => $request->updated_date,
            'notes'              => $request->notes,
        ]);

        // Simpan log entry pertama
        $application->logs()->create([
            'stage'    => $request->stage,
            'status'   => $request->status,
            'log_date' => $request->updated_date,
            'notes'    => $request->notes,
        ]);

        return back()->with('success', 'Scholarship application successfully recorded!');
    }

    // ──────────────────────────────────────────────
    // ADD LOG — tambah tahapan baru ke aplikasi
    // ──────────────────────────────────────────────

    public function addLog(Request $request, ScholarshipApplication $app)
    {
        // Pastikan mentee hanya bisa update miliknya sendiri
        abort_if($app->user_id !== Auth::id(), 403);

        $request->validate([
            'stage'    => 'required|in:' . implode(',', array_keys(ScholarshipApplication::STAGES)),
            'status'   => 'required|in:' . implode(',', array_keys(ScholarshipApplication::STATUSES)),
            'log_date' => 'required|date',
            'notes'    => 'nullable|string|max:1000',
        ]);

        // Cek duplikasi tahapan
        $exists = $app->logs()->where('stage', $request->stage)->exists();
        if ($exists) {
            return back()->withErrors(['stage' => 'This stage is already recorded in the history. Please edit it directly from the stage history if you wish to change it.']);
        }

        // Tambah log
        $app->logs()->create([
            'stage'    => $request->stage,
            'status'   => $request->status,
            'log_date' => $request->log_date,
            'notes'    => $request->notes,
        ]);

        // Update snapshot terkini di tabel utama
        $app->update([
            'current_stage' => $request->stage,
            'status'        => $request->status,
            'updated_date'  => $request->log_date,
            'notes'         => $request->notes,
        ]);

        return back()->with('success', 'Stage successfully updated!');
    }

    // ──────────────────────────────────────────────
    // UPDATE LOG — edit status & catatan di riwayat
    // ──────────────────────────────────────────────

    public function updateLog(Request $request, \App\Models\ScholarshipApplicationLog $log)
    {
        // Pastikan mentee hanya bisa update miliknya sendiri
        abort_if($log->application->user_id !== Auth::id(), 403);

        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(ScholarshipApplication::STATUSES)),
            'notes'  => 'nullable|string|max:1000',
        ]);

        $log->update([
            'status' => $request->status,
            'notes'  => $request->notes,
        ]);

        // Cari log paling akhir untuk disinkronkan ke tabel utama
        $latestLog = $log->application->logs()->orderBy('log_date', 'desc')->orderBy('id', 'desc')->first();
        if ($latestLog && $latestLog->id === $log->id) {
            $log->application->update([
                'status' => $request->status,
                'notes'  => $request->notes,
            ]);
        }

        return back()->with('success', 'Stage history successfully updated!');
    }

    // ──────────────────────────────────────────────
    // DESTROY — hapus aplikasi milik sendiri
    // ──────────────────────────────────────────────

    public function destroy(ScholarshipApplication $app)
    {
        abort_if($app->user_id !== Auth::id(), 403);

        // logs ikut terhapus via cascadeOnDelete di migration
        $app->delete();

        return back()->with('success', 'Scholarship application data deleted.');
    }
}
