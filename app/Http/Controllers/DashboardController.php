<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Event;
use App\Models\ScholarshipApplication;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ── Documents ──
        $documents = $user->documents()->get();
        $requiredTypes = Document::REQUIRED_TYPES;
        
        $docsUploaded = $documents->count();
        $docsApproved = $documents->where('status', 'approved')->count();
        $otherDocsCount = $documents->where('category', 'other')->count();
        
        $docsTotal = count($requiredTypes) + $otherDocsCount;

        // ── Mentoring Sessions ──
        $sessions = $user->sessions()
            ->with(['mentor.user', 'schedule', 'report'])
            ->orderByDesc('created_at')
            ->get();

        $sessionsDone  = $sessions->where('status', 'done')->count();
        $sessionsTotal = $sessions->count();
        $myMentor      = $sessions->first()?->mentor;

        // ── PSP Application ──
        $pspApplication = $user->pspApplication;
        if ($pspApplication) {
            $pspApplication->load('scholarship', 'studyPlan.program');
        }

        // ── Events (current month + next 2 months) ──
        $eventsStart = today()->startOfMonth();
        $eventsEnd   = today()->addMonths(2)->endOfMonth();
        $events = Event::whereBetween('date', [$eventsStart, $eventsEnd])
            ->orderBy('date')
            ->get();

        // Upcoming events (for the list below calendar)
        $upcomingEvents = Event::upcoming()->limit(5)->get();

        // ── Overall Progress ──
        $docProgress  = $docsTotal > 0 ? ($docsApproved / $docsTotal) * 100 : 0;
        $pspProgress  = $pspApplication ? ($pspApplication->status === 'approved' ? 100 : 50) : 0;
        $mentProgress = $sessionsTotal > 0 ? ($sessionsDone / $sessionsTotal) * 100 : 0;
        $overallProgress = round(($docProgress + $pspProgress + $mentProgress) / 3);

        // ── Scholarship Applications (preview) ──
        $scholarshipApps = $user->scholarshipApplications()
            ->with('scholarship', 'programStudy')
            ->latest('updated_date')
            ->limit(3)
            ->get();
        $scholarshipLolos = $user->scholarshipApplications()->where('status', 'lolos')->count();
        $scholarshipTotal = $user->scholarshipApplications()->count();

        // ── English Qualification ──
        $isEnglishQualified = ($user->toefl_score >= 500 || $user->ielts_score >= 6.5);

        return view('landing.dashboard', compact(
            'user',
            'documents', 'requiredTypes', 'docsUploaded', 'docsApproved', 'docsTotal',
            'sessions', 'sessionsDone', 'sessionsTotal', 'myMentor',
            'pspApplication',
            'events', 'upcomingEvents',
            'overallProgress',
            'scholarshipApps', 'scholarshipLolos', 'scholarshipTotal',
            'isEnglishQualified',
        ));
    }

    public function updateEnglishScore(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'toefl_score' => 'nullable|numeric|min:0',
            'ielts_score' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();
        $user->update([
            'toefl_score' => $request->toefl_score,
            'ielts_score' => $request->ielts_score,
        ]);

        return redirect()->route('dashboard')->with('success', 'English score updated successfully!');
    }
}
