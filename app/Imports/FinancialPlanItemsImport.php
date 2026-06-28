<?php

namespace App\Imports;

use App\Models\FinancialPlanItem;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinancialPlanItemsImport implements WithMultipleSheets
{
    protected $planId;

    // Maps sheet title → category key (case-insensitive)
    protected $categoryMap = [
        'arrival cost'   => 'arrival',
        'education cost' => 'education',
        'living cost'    => 'living',
        'family support' => 'family',
        // fallback by index (sheet 0–3)
        0 => 'arrival',
        1 => 'education',
        2 => 'living',
        3 => 'family',
    ];

    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    public function sheets(): array
    {
        $categories = ['arrival', 'education', 'living', 'family'];
        $sheets     = [];

        foreach ($categories as $index => $cat) {
            $sheets[$index] = new FinancialPlanCategoryImport($this->planId, $cat);
        }

        return $sheets;
    }
}
