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

    public function recalculateTotals()
    {
        $totalCost = $this->items()->sum('estimated_cost');
        $totalScholarshipCoverage = $this->items()->sum('scholarship_coverage');
        
        $totalFunding = $totalScholarshipCoverage;
        $fundingGap = $totalFunding - $totalCost;

        // Also update gap for each item just in case
        foreach ($this->items as $item) {
            $item->updateQuietly([
                'gap_amount' => $item->scholarship_coverage - $item->estimated_cost
            ]);
        }

        $this->update([
            'scholarship_amount'   => $totalScholarshipCoverage,
            'total_estimated_cost' => $totalCost,
            'total_funding'        => $totalFunding,
            'funding_gap'          => $fundingGap
        ]);
    }

    protected static function booted()
    {
        static::updated(function ($plan) {
            if ($plan->isDirty('status')) {
                if (in_array($plan->status, ['approved', 'revision_needed'])) {
                    if ($plan->user && $plan->user->email) {
                        \Illuminate\Support\Facades\Mail::to($plan->user->email)->send(
                            new \App\Mail\FinancialPlanStatusMail($plan, $plan->status, $plan->admin_notes)
                        );
                    }
                }
            }
        });
    }
}
