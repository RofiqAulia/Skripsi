<?php

namespace App\Imports;

use App\Models\FinancialPlan;
use App\Models\FinancialPlanItem;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FinancialPlanCategoryImport implements ToCollection, WithHeadingRow
{
    protected $planId;
    protected $category;

    public function __construct($planId, $category)
    {
        $this->planId   = $planId;
        $this->category = $category;
    }

    public function collection(Collection $rows)
    {
        $totalCost  = 0;
        $totalSchol = 0;

        foreach ($rows as $row) {
            // Skip instruction/note rows (no Item Name)
            $itemName = trim((string)($row['item_name'] ?? ''));
            if (empty($itemName)) {
                continue;
            }

            // Skip rows that start with 📝 (note rows)
            if (Str::startsWith($itemName, ['📝', 'HOW TO', '1.', '2.', '3.', '4.', '5.'])) {
                continue;
            }

            $estimatedCost       = floatval($row['estimated_cost']        ?? 0);
            $scholarshipCoverage = floatval($row['scholarship_coverage']  ?? 0);

            // Match item by name + category (case-insensitive, trim)
            $item = FinancialPlanItem::where('financial_plan_id', $this->planId)
                ->where('category', $this->category)
                ->whereRaw('LOWER(TRIM(item_name)) = ?', [strtolower(trim($itemName))])
                ->first();

            if ($item) {
                $item->update([
                    'estimated_cost'       => $estimatedCost,
                    'scholarship_coverage' => $scholarshipCoverage,
                    'personal_coverage'    => 0,
                    'gap_amount'           => $scholarshipCoverage - $estimatedCost,
                ]);

                $totalCost  += $estimatedCost;
                $totalSchol += $scholarshipCoverage;
            }
        }

        // After processing each sheet's category, recalculate plan totals
        $this->recalculatePlan();
    }

    protected function recalculatePlan(): void
    {
        $plan = FinancialPlan::find($this->planId);
        if (!$plan) return;

        $items = FinancialPlanItem::where('financial_plan_id', $this->planId)->get();

        $totalCost  = $items->sum('estimated_cost');
        $totalSchol = $items->sum('scholarship_coverage');
        $gap        = $totalSchol - $totalCost;

        $plan->update([
            'total_estimated_cost' => $totalCost,
            'total_funding'        => $totalSchol,
            'funding_gap'          => $gap,
            'scholarship_amount'   => $totalSchol,
        ]);
    }
}
