<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialDocument extends Model
{
    protected $guarded = [];

    public function financialPlan()
    {
        return $this->belongsTo(FinancialPlan::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
