<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialPlan extends Model
{
    protected $guarded = [];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scholarshipApplication()
    {
        return $this->belongsTo(ScholarshipApplication::class);
    }

    public function items()
    {
        return $this->hasMany(FinancialPlanItem::class);
    }

    public function documents()
    {
        return $this->hasMany(FinancialDocument::class);
    }

    public function reviews()
    {
        return $this->hasMany(FinancialReview::class);
    }

    public function riskAssessments()
    {
        return $this->hasMany(FinancialRiskAssessment::class);
    }
}
