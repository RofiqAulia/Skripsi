<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\ProgramStudy;
use App\Models\PspApplication;
use App\Models\StudyPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PspController extends Controller
{
    public function index()
    {
        $programStudies = ProgramStudy::with('scholarships')->get();
        $user = Auth::user();

        $pspApplication = PspApplication::where('user_id', $user->id)
            ->with(['scholarship.programStudy', 'studyPlan.programStudy', 'approver'])
            ->latest()
            ->first();

        return view('landing.psp', compact('programStudies', 'pspApplication'));
    }

    public function showProgram($id)
    {
        $program = ProgramStudy::with('scholarships')->findOrFail($id);
        return view('landing.program-detail', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'study_plan_text'    => 'nullable|string|max:2000',
            'program_study_id'   => 'required|exists:program_studies,id',
            'study_plan_files'   => 'nullable|array|max:10',
            'study_plan_files.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:20480',
        ]);

        // At least text or files must be provided
        if (empty($request->study_plan_text) && !$request->hasFile('study_plan_files')) {
            return back()->withErrors(['study_plan_text' => 'Please provide a study plan text or upload at least one file.'])->withInput();
        }

        $user         = Auth::user();
        $programStudy = ProgramStudy::with('scholarships')->findOrFail($request->program_study_id);

        // Resolve scholarship — use first linked scholarship if available (nullable)
        $scholarship = $programStudy->scholarships->first();

        // Handle file uploads
        $uploadedFiles = [];
        if ($request->hasFile('study_plan_files')) {
            foreach ($request->file('study_plan_files') as $file) {
                $path = $file->store('study-plans/' . $user->id, 'public');
                $uploadedFiles[] = [
                    'path'          => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'size'          => $file->getSize(),
                ];
            }
        }

        // Create/update StudyPlan — keyed by user + program_study
        $studyPlan = StudyPlan::updateOrCreate(
            ['user_id' => $user->id, 'program_study_id' => $programStudy->id],
            [
                'scholarship_id'    => $scholarship?->id,
                'future_competence' => $request->study_plan_text,
                'files'             => count($uploadedFiles) > 0 ? $uploadedFiles : null,
            ]
        );

        // Create/update PspApplication
        PspApplication::updateOrCreate(
            ['user_id' => $user->id],
            [
                'study_plan_id'   => $studyPlan->id,
                'scholarship_id'  => $scholarship?->id,
                'study_plan_text' => $request->study_plan_text,
                'status'          => 'submission',
            ]
        );

        return redirect()->route('psp')->with('success', 'Study plan submitted successfully!');
    }

    /**
     * Generate and download the approval/rejection letter as PDF.
     */
    public function letter(PspApplication $application)
    {
        // Ensure the current user owns this application or is admin
        abort_if(Auth::id() !== $application->user_id, 403);

        $application->load([
            'user',
            'scholarship.programStudy',
            'studyPlan.programStudy',
            'approver',
        ]);

        $pdf = Pdf::loadView('pdf.psp-letter', compact('application'))
            ->setPaper('a4', 'portrait');

        $filename = 'PSP-Letter-' . $application->user->name . '-' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Send the approval/rejection letter via email to the user.
     */
    public function sendLetter(PspApplication $application)
    {
        // Ensure the current user owns this application or is admin
        abort_if(Auth::id() !== $application->user_id, 403);

        $application->load([
            'user',
            'scholarship.programStudy',
            'studyPlan.programStudy',
            'approver',
        ]);

        $pdf = Pdf::loadView('pdf.psp-letter', compact('application'))
            ->setPaper('a4', 'portrait');

        $pdfContent = $pdf->output();
        $filename = 'PSP-Letter-' . $application->user->name . '-' . now()->format('Ymd') . '.pdf';

        \Illuminate\Support\Facades\Mail::to($application->user->email)
            ->send(new \App\Mail\PspLetterMail($application, $pdfContent, $filename));

        return back()->with('success', 'PSP decision letter has been successfully sent to your email (' . $application->user->email . ').');
    }
}
