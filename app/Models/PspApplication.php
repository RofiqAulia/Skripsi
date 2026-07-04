<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PspApplication extends Model
{
    protected $fillable = [
        'user_id', 'study_plan_id', 'scholarship_id', 'study_plan_text', 'status', 'approved_by', 'notes',
        'signature_image', 'signature_pad',
        'approval_stage', 'department_approver_id', 'group_approver_id', 'direktorat_approver_id',
        'department_approved_at', 'group_approved_at', 'direktorat_approved_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function departmentApprover()
    {
        return $this->belongsTo(User::class, 'department_approver_id');
    }

    public function groupApprover()
    {
        return $this->belongsTo(User::class, 'group_approver_id');
    }

    public function direktoratApprover()
    {
        return $this->belongsTo(User::class, 'direktorat_approver_id');
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

    public function studyProgressReports()
    {
        return $this->hasMany(StudyProgressReport::class);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            // Jika statusnya approved, pastikan stage nya 3 (Done)
            if ($model->status === 'approved' && $model->approval_stage < 3) {
                $model->approval_stage = 3;
            }
            // Jika status diturunkan dari approved, pastikan stagenya turun ke 2
            elseif ($model->status !== 'approved' && $model->approval_stage == 3) {
                $model->approval_stage = 2;
            }

            // Set approver ids automatically based on stage
            if ($model->approval_stage >= 1 && empty($model->department_approver_id)) {
                $model->department_approver_id = auth()->id();
            }
            if ($model->approval_stage >= 2 && empty($model->group_approver_id)) {
                $model->group_approver_id = auth()->id();
            }
            if ($model->approval_stage >= 3 && empty($model->direktorat_approver_id)) {
                $model->direktorat_approver_id = auth()->id();
            }
        });
    }
}