<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\MentorSchedule;
use Illuminate\Support\Facades\DB;

class MentorController extends Controller
{

    public function index()
    {
        $userId = auth()->id();

        // Cari apakah ada sesi kosong (hanya select mentor)
        $emptySession = \App\Models\MentoringSession::where('user_id', $userId)
                            ->whereNull('schedule_id')
                            ->first();

        // Mentor yang dikunci bisa didapat dari emptySession atau existing sessions
        $existingSession = \App\Models\MentoringSession::where('user_id', $userId)->first();
        $lockedMentorId = $emptySession ? $emptySession->mentor_id :
                          ($existingSession ? $existingSession->mentor_id : null);

        // Ambil mentor dengan count UNIQUE users (bukan total sessions)
        $mentors = Mentor::with('user')
            ->withCount(['sessions as unique_mentees_count' => function ($q) {
                $q->select(DB::raw('count(distinct user_id)'));
            }])
            ->get();

        // Ambil jadwal dari mentor (filter jika locked)
        $schedulesQuery = MentorSchedule::with(['mentor.user', 'session'])
            ->orderBy('date');

        if ($lockedMentorId) {
            $schedulesQuery->where('mentor_id', $lockedMentorId);
        }

        $schedules = $schedulesQuery->get()->groupBy('mentor_id');

        return view('landing.mentoring', compact(
            'mentors',
            'schedules',
            'lockedMentorId',
        ));
    }

    public function selectMentor(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:mentors,id',
        ]);

        $userId = auth()->id();

        // Cek apakah user sudah punya mentor (locked)
        $activeSession = \App\Models\MentoringSession::where('user_id', $userId)->latest()->first();
        if ($activeSession) {
            return back()->with('error', 'You have already selected a mentor. Please complete or cancel your previous session first.');
        }

        // Count unique users yang sudah memilih mentor ini
        $uniqueMentees = \App\Models\MentoringSession::where('mentor_id', $request->mentor_id)
            ->distinct('user_id')
            ->count('user_id');

        $mentor = Mentor::findOrFail($request->mentor_id);
        if ($uniqueMentees >= $mentor->quota) {
            return back()->with('error', 'This mentor\'s quota is full.');
        }

        \App\Models\MentoringSession::create([
            'user_id' => $userId,
            'mentor_id' => $mentor->id,
            'schedule_id' => null,
        ]);

        return redirect()->route('mentoring')->with('success', 'Mentor successfully selected! Please choose a mentoring schedule.');
    }

    public function bookSchedule(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:mentor_schedules,id',
            'link_meet' => [
                'required',
                'url',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/(meet\.google\.com|zoom\.us|teams\.microsoft\.com)/i', $value)) {
                        $fail('The meeting link must be from Google Meet, Zoom, or MS Teams.');
                    }
                },
            ],
        ]);

        $schedule = MentorSchedule::findOrFail($request->schedule_id);
        $userId = auth()->id();

        // Cek apakah ada sesi kosong (hanya pilih mentor) untuk mentor ini
        $emptySession = \App\Models\MentoringSession::where('user_id', $userId)
            ->where('mentor_id', $schedule->mentor_id)
            ->whereNull('schedule_id')
            ->first();

        if ($emptySession) {
            // Update sesi yang masih kosong
            $emptySession->update([
                'schedule_id' => $schedule->id,
                'link_meet' => $request->link_meet,
                'status' => 'pending',
            ]);
            $activeSession = $emptySession;
        } else {
            // Cek apakah user punya histori dengan mentor ini
            $hasHistory = \App\Models\MentoringSession::where('user_id', $userId)
                ->where('mentor_id', $schedule->mentor_id)
                ->exists();

            if (!$hasHistory) {
                return back()->with('error', 'Session not found or mentor mismatch. Please select a mentor first.');
            }

            // Buat sesi baru
            $activeSession = \App\Models\MentoringSession::create([
                'user_id' => $userId,
                'mentor_id' => $schedule->mentor_id,
                'schedule_id' => $schedule->id,
                'link_meet' => $request->link_meet,
                'status' => 'pending',
            ]);
        }

        // Kirim Email
        \Illuminate\Support\Facades\Mail::to($activeSession->user->email)
            ->cc($activeSession->mentor->user->email)
            ->send(new \App\Mail\MentoringScheduledMail($activeSession));

        return redirect()->route('mentoring')->with('success', 'Mentoring schedule successfully selected! Check your history page.');
    }

    /**
     * History page — menampilkan semua booked sessions user
     */
    public function history()
    {
        $userId = auth()->id();

        $mySessions = \App\Models\MentoringSession::with(['mentor.user', 'schedule', 'report'])
            ->where('user_id', $userId)
            ->whereNotNull('schedule_id')
            ->latest()
            ->get();

        return view('landing.mentoring-history', compact('mySessions'));
    }

    public function updateStatus(\Illuminate\Http\Request $request, \App\Models\MentoringSession $session)
    {
        abort_if($session->user_id !== auth()->id(), 403);

        $request->validate([
            'status' => 'required|in:pending,done,cancelled',
        ]);

        $session->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Mentoring session status successfully updated!');
    }
}