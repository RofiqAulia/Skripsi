<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyProgressReport;
use App\Models\PspApplication;

class StudyProgressReportController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        
        $pspApplication = PspApplication::where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest()
            ->first();

        $departments = \App\Models\Department::all();
        $groups = \App\Models\Group::all();
        $direktorats = \App\Models\Direktorat::all();

        return view('study-progress-report.create', compact('pspApplication', 'departments', 'groups', 'direktorats'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi dasar
        $request->validate([
            'nik' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'group_id' => 'nullable|exists:groups,id',
            'direktorat_id' => 'nullable|exists:direktorats,id',
            'semester' => 'required|numeric|min:1',
            'gpa' => 'required|numeric|min:0|max:4',
            'max_gpa' => 'required|numeric|min:0|max:4',
        ]);

        $user->update([
            'nik' => $request->input('nik') ?? $user->nik,
            'company' => $request->input('company') ?? $user->company,
            'position' => $request->input('position') ?? $user->position,
            'department_id' => $request->input('department_id') ?? $user->department_id,
            'group_id' => $request->input('group_id') ?? $user->group_id,
            'direktorat_id' => $request->input('direktorat_id') ?? $user->direktorat_id,
        ]);

        $pspApplication = PspApplication::where('user_id', $user->id)->latest()->first();

        // Format data arrays
        $completedCourses = $this->formatCourseArray($request->input('completed_courses_name'), $request->input('completed_courses_credits'), $request->input('completed_courses_grade'));
        $ongoingCourses = $this->formatCourseArray($request->input('ongoing_courses_name'), $request->input('ongoing_courses_credits'), null);
        $upcomingCourses = $this->formatCourseArray($request->input('upcoming_courses_name'), $request->input('upcoming_courses_credits'), null);
        $otherActivities = $this->formatActivityArray($request->input('activity_name'), $request->input('activity_date'), $request->input('activity_description'));

        StudyProgressReport::create([
            'user_id' => $user->id,
            'psp_application_id' => $pspApplication ? $pspApplication->id : null,
            'semester' => $request->input('semester'),
            'gpa' => $request->input('gpa'),
            'max_gpa' => $request->input('max_gpa'),
            'status' => 'submission',
            
            // JSON Arrays
            'completed_courses' => $completedCourses,
            'ongoing_courses' => $ongoingCourses,
            'upcoming_courses' => $upcomingCourses,
            
            // Thesis Data
            'thesis_title' => $request->input('thesis_title'),
            'thesis_title_status' => $request->input('thesis_title_status'),
            'thesis_proposal' => $request->input('thesis_proposal'),
            'thesis_proposal_status' => $request->input('thesis_proposal_status'),
            
            'proposal_exam_status' => $request->input('proposal_exam_status'),
            'proposal_exam_date' => $request->input('proposal_exam_date'),
            'proposal_exam_score' => $request->input('proposal_exam_score'),
            'proposal_revision_status' => $request->input('proposal_revision_status'),
            
            'research_implementation_status' => $request->input('research_implementation_status'),
            'data_collection_status' => $request->input('data_collection_status'),
            'data_analysis_status' => $request->input('data_analysis_status'),
            'thesis_writing_status' => $request->input('thesis_writing_status'),
            
            'thesis_exam_status' => $request->input('thesis_exam_status'),
            'thesis_exam_date' => $request->input('thesis_exam_date'),
            'thesis_exam_score' => $request->input('thesis_exam_score'),
            'thesis_revision_status' => $request->input('thesis_revision_status'),
            
            'journal_article_status' => $request->input('journal_article_status'),
            'journal_publication_status' => $request->input('journal_publication_status'),
            
            // JSON Activity
            'other_academic_activities' => $otherActivities,
        ]);

        return redirect()->route('dashboard')->with('success', 'Study Progress Report submitted successfully.');
    }

    private function formatCourseArray($names, $credits, $grades = null)
    {
        if (empty($names)) return null;
        
        $result = [];
        foreach ($names as $key => $name) {
            if (!empty($name)) {
                $item = [
                    'course_name' => $name,
                    'credits' => $credits[$key] ?? null,
                ];
                if ($grades !== null) {
                    $item['grade'] = $grades[$key] ?? null;
                }
                $result[] = $item;
            }
        }
        return empty($result) ? null : $result;
    }

    private function formatActivityArray($names, $dates, $descriptions)
    {
        if (empty($names)) return null;
        
        $result = [];
        foreach ($names as $key => $name) {
            if (!empty($name)) {
                $result[] = [
                    'activity_name' => $name,
                    'activity_date' => $dates[$key] ?? null,
                    'description' => $descriptions[$key] ?? null,
                ];
            }
        }
        return empty($result) ? null : $result;
    }
}
