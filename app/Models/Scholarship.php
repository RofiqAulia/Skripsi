<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        // Data Dasar
        'title', 'description', 'funding_type', 'competency', 'country',
        'website', 'intake', 'commitment',
        // Pilihan Program Studi
        'program_study_id', 'study_count', 'study_duration',
        // Persyaratan Akademik
        'age', 'gpa', 'nationality', 'english_test', 'other_language',
        'standardized_test', 'req_standardized_test', 'eligibility',
        'document', 'other', 'benefit',
        // Timeline
        'open_date', 'deadline', 'screening_date', 'written_test_date',
        'interview_date', 'shortlist_date',
        // Proses Seleksi
        'registration_process',
    ];

    protected $casts = [
        'english_test'          => 'array',
        'document'              => 'array',
        'benefit'               => 'array',
        'req_standardized_test' => 'boolean',
        'open_date'             => 'date',
        'deadline'              => 'date',
        'screening_date'        => 'date',
        'written_test_date'     => 'date',
        'interview_date'        => 'date',
        'shortlist_date'        => 'date',
    ];

    public function programStudy()
    {
        return $this->belongsTo(ProgramStudy::class);
    }
}
