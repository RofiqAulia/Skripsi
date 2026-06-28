<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mentor;
use App\Models\MentorSchedule;
use App\Models\MentoringSession;
use App\Models\MentoringReport;

class MentoringReportController extends Controller
{
    public function index()
    {
        // Cek apakah user punya mentor (dari session terakhir)
        $activeSession = MentoringSession::where('user_id', Auth::id())->latest()->first();
        
        if (!$activeSession) {
            return redirect()->route('mentoring')->with('error', 'Please select a mentor and schedule first before creating a report.');
        }

        $mentors = Mentor::with('user:id,name')->where('id', $activeSession->mentor_id)->get();

        // 🔥 ambil hanya field yang dibutuhkan untuk mentor yang dipilih
        $schedules = MentorSchedule::select(
                'id',
                'mentor_id',
                'date',
                'start_time',
                'end_time'
            )
            ->where('mentor_id', $activeSession->mentor_id)
            ->get();

        $reports = MentoringReport::with('session.mentor.user')
            ->whereHas('session', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        $nextMeetingNumber = $reports->count() + 1;

        return view('landing.report-mentoring', compact(
            'mentors',
            'schedules',
            'reports',
            'nextMeetingNumber'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:mentors,id',
            'schedule_id' => 'required|exists:mentor_schedules,id',
            'meeting_number' => 'required|integer|min:1',
            'summary' => 'required|string',
            'output' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // 🔥 AUTO CREATE / GET SESSION
        $session = MentoringSession::firstOrCreate([
            'user_id' => Auth::id(),
            'mentor_id' => $request->mentor_id,
            'schedule_id' => $request->schedule_id,
        ]);

        // upload file
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('reports', 'public');
        }

        // simpan report
        $report = MentoringReport::create([
            'mentoring_session_id' => $session->id,
            'meeting_number' => $request->meeting_number,
            'summary' => $request->summary,
            'output' => $request->output,
            'file' => $filePath,
            'status' => MentoringReport::STATUS_SUBMITTED,
            'mentor_notes' => null,
        ]);

        $report->load('session.user', 'session.mentor.user');
        
        if ($report->session->user && $report->session->user->email) {
            $mail = \Illuminate\Support\Facades\Mail::to($report->session->user->email);
            if ($report->session->mentor && $report->session->mentor->user && $report->session->mentor->user->email) {
                $mail->cc($report->session->mentor->user->email);
            }
            $mail->send(new \App\Mail\MentoringReportMail($report));
        }

        return redirect()
            ->route('mentoring')
            ->with('success', 'Report submitted successfully');
    }
}