<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialReview extends Model
{
    protected $guarded = [];

    public function financialPlan()
    {
        return $this->belongsTo(FinancialPlan::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
