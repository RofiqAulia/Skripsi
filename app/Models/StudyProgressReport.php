<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyProgressReport extends Model
{
    protected $fillable = [
        'user_id',
        'psp_application_id',
        'semester',
        'gpa',
        'max_gpa',
        'status',
        'completed_courses',
        'ongoing_courses',
        'upcoming_courses',
        'thesis_title',
        'thesis_title_status',
        'thesis_proposal',
        'thesis_proposal_status',
        'proposal_exam_status',
        'proposal_exam_date',
        'proposal_exam_score',
        'proposal_revision_status',
        'research_implementation_status',
        'data_collection_status',
        'data_analysis_status',
        'thesis_writing_status',
        'thesis_exam_status',
        'thesis_exam_date',
        'thesis_exam_score',
        'thesis_revision_status',
        'journal_article_status',
        'journal_publication_status',
        'other_academic_activities',
        'certificates',
        'signature_pad',
        'signature_image',
    ];

    protected $casts = [
        'completed_courses' => 'array',
        'ongoing_courses' => 'array',
        'upcoming_courses' => 'array',
        'other_academic_activities' => 'array',
        'certificates' => 'array',
        'proposal_exam_date' => 'date',
        'thesis_exam_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pspApplication()
    {
        return $this->belongsTo(PspApplication::class);
    }
}
