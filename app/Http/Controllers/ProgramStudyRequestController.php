<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramStudyRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            // General
            'name'                   => 'required|string|max:255',
            'scholarship'            => 'nullable|string|max:255',
            'competency'             => 'required|string|max:255',
            'degree'                 => 'nullable|string|max:255',
            'university'             => 'required|string|max:255',
            'qs_rank'                => 'nullable|integer|min:1',
            'country'                => 'required|string|max:255',
            'website'                => 'nullable|url|max:500',
            'description'            => 'nullable|string',
            // Study Details
            'study_type'             => 'nullable|string|max:255',
            'study_duration'         => 'nullable|string|max:50',
            'gpa'                    => 'nullable|string|max:50',
            'intake'                 => 'nullable|string|max:100',
            // Language & Tests
            'english_test'           => 'nullable|array',
            'english_test.*'         => 'nullable|string|max:50',
            'other_language'         => 'nullable|string|max:255',
            'standardized_test'      => 'nullable|string|max:255',
            'req_standardized_test'  => 'nullable',
            'other'                  => 'nullable|string',
            // Timeline
            'open_date'              => 'nullable|date',
            'deadline'               => 'nullable|date',
            'screening_date'         => 'nullable|date',
            'written_test_date'      => 'nullable|date',
            'interview_date'         => 'nullable|date',
            'shortlist_date'         => 'nullable|date',
            // Process
            'registration_process'   => 'nullable|string',
            'requirements'           => 'nullable|string',
        ]);

        ProgramStudy::create([
            'name'                   => $request->name,
            'scholarship'            => $request->scholarship,
            'competency'             => $request->competency,
            'degree'                 => $request->degree,
            'university'             => $request->university,
            'qs_rank'                => $request->qs_rank,
            'country'                => $request->country,
            'website'                => $request->website,
            'description'            => $request->description,
            'study_type'             => $request->study_type,
            'study_duration'         => $request->study_duration,
            'gpa'                    => $request->gpa,
            'intake'                 => $request->intake,
            'english_test'           => $request->english_test ?? [],
            'other_language'         => $request->other_language,
            'standardized_test'      => $request->standardized_test,
            'req_standardized_test'  => $request->has('req_standardized_test'),
            'other'                  => $request->other,
            'open_date'              => $request->open_date,
            'deadline'               => $request->deadline,
            'screening_date'         => $request->screening_date,
            'written_test_date'      => $request->written_test_date,
            'interview_date'         => $request->interview_date,
            'shortlist_date'         => $request->shortlist_date,
            'registration_process'   => $request->registration_process,
            'requirements'           => $request->requirements,
            'status'                 => 'pending',
            'submitted_by'           => Auth::id(),
        ]);

        return back()->with('success', 'Program Study submitted successfully! It is pending admin approval before it will appear in the system.');
    }

    public function update(Request $request, $id)
    {
        $program = ProgramStudy::findOrFail($id);

        // Ensure user can only update their own suggestions and only if pending or revision
        if ($program->submitted_by !== Auth::id() || !in_array($program->status, ['pending', 'revision'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            // General
            'name'                   => 'required|string|max:255',
            'scholarship'            => 'nullable|string|max:255',
            'competency'             => 'required|string|max:255',
            'degree'                 => 'nullable|string|max:255',
            'university'             => 'required|string|max:255',
            'qs_rank'                => 'nullable|integer|min:1',
            'country'                => 'required|string|max:255',
            'website'                => 'nullable|url|max:500',
            'description'            => 'nullable|string',
            // Study Details
            'study_type'             => 'nullable|string|max:255',
            'study_duration'         => 'nullable|string|max:50',
            'gpa'                    => 'nullable|string|max:50',
            'intake'                 => 'nullable|string|max:100',
            // Language & Tests
            'english_test'           => 'nullable|array',
            'english_test.*'         => 'nullable|string|max:50',
            'other_language'         => 'nullable|string|max:255',
            'standardized_test'      => 'nullable|string|max:255',
            'req_standardized_test'  => 'nullable',
            'other'                  => 'nullable|string',
            // Timeline
            'open_date'              => 'nullable|date',
            'deadline'               => 'nullable|date',
            'screening_date'         => 'nullable|date',
            'written_test_date'      => 'nullable|date',
            'interview_date'         => 'nullable|date',
            'shortlist_date'         => 'nullable|date',
            // Process
            'registration_process'   => 'nullable|string',
            'requirements'           => 'nullable|string',
        ]);

        $program->update([
            'name'                   => $request->name,
            'scholarship'            => $request->scholarship,
            'competency'             => $request->competency,
            'degree'                 => $request->degree,
            'university'             => $request->university,
            'qs_rank'                => $request->qs_rank,
            'country'                => $request->country,
            'website'                => $request->website,
            'description'            => $request->description,
            'study_type'             => $request->study_type,
            'study_duration'         => $request->study_duration,
            'gpa'                    => $request->gpa,
            'intake'                 => $request->intake,
            'english_test'           => $request->english_test ?? [],
            'other_language'         => $request->other_language,
            'standardized_test'      => $request->standardized_test,
            'req_standardized_test'  => $request->has('req_standardized_test'),
            'other'                  => $request->other,
            'open_date'              => $request->open_date,
            'deadline'               => $request->deadline,
            'screening_date'         => $request->screening_date,
            'written_test_date'      => $request->written_test_date,
            'interview_date'         => $request->interview_date,
            'shortlist_date'         => $request->shortlist_date,
            'registration_process'   => $request->registration_process,
            'requirements'           => $request->requirements,
            'status'                 => 'pending', // Revert to pending on update
        ]);

        return back()->with('success', 'Program Study updated successfully! It is now pending admin approval.');
    }
}
