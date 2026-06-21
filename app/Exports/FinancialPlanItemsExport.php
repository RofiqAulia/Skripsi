<?php

namespace App\Exports;

use App\Models\FinancialPlanItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinancialPlanItemsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $planId;

    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    public function collection()
    {
        return FinancialPlanItem::where('financial_plan_id', $this->planId)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Category',
            'Item Name',
            'Estimated Cost',
            'Scholarship Coverage'
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            ucfirst($item->category),
            $item->item_name,
            $item->estimated_cost + 0, // ensure format
            $item->scholarship_coverage + 0
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}

