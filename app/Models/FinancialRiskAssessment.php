<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialRiskAssessment extends Model
{
    protected $guarded = [];

    public function financialPlan()
    {
        return $this->belongsTo(FinancialPlan::class);
    }
}
