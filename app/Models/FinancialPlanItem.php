<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialPlanItem extends Model
{
    protected $guarded = [];

    public function financialPlan()
    {
        return $this->belongsTo(FinancialPlan::class);
    }
}
