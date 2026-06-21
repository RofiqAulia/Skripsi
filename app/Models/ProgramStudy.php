<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudy extends Model
{
    protected $fillable = [
        // Data Dasar
        'name', 'scholarship', 'competency', 'degree', 'university', 'qs_rank', 'country', 'website',
        // Akademik
        'description', 'study_type', 'study_duration', 'gpa',
        // Bahasa & Tes
        'english_test', 'other_language', 'standardized_test', 'req_standardized_test', 'other',
        // Timeline Pendaftaran
        'open_date', 'deadline', 'screening_date', 'written_test_date', 'interview_date', 'shortlist_date',
        // Proses & Persyaratan
        'registration_process', 'requirements', 'intake',
        // Status Approval
        'status', 'admin_notes', 'submitted_by',
    ];

    protected $casts = [
        'english_test'          => 'array',
        'req_standardized_test' => 'boolean',
        'open_date'             => 'date',
        'deadline'              => 'date',
        'screening_date'        => 'date',
        'written_test_date'     => 'date',
        'interview_date'        => 'date',
        'shortlist_date'        => 'date',
    ];

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
