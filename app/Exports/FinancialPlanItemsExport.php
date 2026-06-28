<?php

namespace App\Exports;

use App\Models\FinancialPlanItem;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinancialPlanItemsExport implements WithMultipleSheets
{
    protected $planId;

    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    public function sheets(): array
    {
        $categories = [
            'arrival'   => 'Arrival Cost',
            'education' => 'Education Cost',
            'living'    => 'Living Cost',
            'family'    => 'Family Support',
        ];

        $sheets = [];
        foreach ($categories as $key => $label) {
            $sheets[] = new FinancialPlanCategorySheet($this->planId, $key, $label);
        }

        return $sheets;
    }
}
