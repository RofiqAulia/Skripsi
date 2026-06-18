<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PspApplication extends Model
{
    protected $fillable = [
        'user_id', 'study_plan_id', 'scholarship_id', 'study_plan_text', 'status', 'approved_by', 'notes',
        'signature_image', 'signature_pad'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    /**
     * Scholarship Applications yang terhubung ke PSP ini.
     * (auto-linked saat mentee input scholarship yg sama dengan PSP)
     */
    public function scholarshipApplications()
    {
        return $this->hasMany(ScholarshipApplication::class, 'psp_application_id');
    }
}