<?php

namespace App\Imports;

use App\Models\FinancialPlanItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class FinancialPlanItemsImport implements ToModel, WithHeadingRow
{
    protected $planId;

    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    public function model(array $row)
    {
        // The header row uses keys derived from the headings (e.g. 'id', 'estimated_cost', 'scholarship_coverage')
        // We only update if 'id' exists and it belongs to the correct plan.
        if (!isset($row['id'])) {
            return null;
        }

        $item = FinancialPlanItem::where('id', $row['id'])
            ->where('financial_plan_id', $this->planId)
            ->first();

        if ($item) {
            $item->update([
                'estimated_cost' => isset($row['estimated_cost']) ? floatval($row['estimated_cost']) : 0,
                'scholarship_coverage' => isset($row['scholarship_coverage']) ? floatval($row['scholarship_coverage']) : 0,
            ]);
            
            // Trigger recalculations
            $item->financialPlan->recalculateTotals();
        }

        return null; // Return null because we are just updating, not creating new via the importer natively.
    }
}

