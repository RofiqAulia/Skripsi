<?php

namespace App\Exports;

use App\Models\FinancialPlanItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class FinancialPlanCategorySheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $planId;
    protected $category;
    protected $label;

    protected $categoryIcons = [
        'arrival'   => '✈️',
        'education' => '📚',
        'living'    => '🏠',
        'family'    => '👨‍👩‍👧',
    ];

    public function __construct($planId, $category, $label)
    {
        $this->planId   = $planId;
        $this->category = $category;
        $this->label    = $label;
    }

    public function title(): string
    {
        return $this->label;
    }

    public function collection()
    {
        return FinancialPlanItem::where('financial_plan_id', $this->planId)
            ->where('category', $this->category)
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No.',
            'Item Name',
            'Estimated Cost',
            'Scholarship Coverage',
            'Gap (Auto)',
        ];
    }

    public function map($item): array
    {
        static $rowNum = 0;
        $rowNum++;

        $cost  = $item->estimated_cost + 0;
        $schol = $item->scholarship_coverage + 0;
        $gap   = $schol - $cost;

        return [
            $rowNum,
            $item->item_name,
            $cost  > 0 ? $cost  : '',
            $schol > 0 ? $schol : '',
            $gap !== 0 ? ($gap >= 0 ? '+' . number_format($gap, 2) : number_format($gap, 2)) : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $icon    = $this->categoryIcons[$this->category] ?? '📋';

        // ── Header row styling ──
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFC0392B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FFE2E8F0'],
                ],
            ],
        ]);

        // ── Data rows alternating color ──
        for ($row = 2; $row <= $lastRow; $row++) {
            $bgColor = ($row % 2 === 0) ? 'FFF8FAFC' : 'FFFFFFFF';
            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $bgColor],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFE2E8F0'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Item name column — left align
            $sheet->getStyle("B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            // Number columns — right align
            $sheet->getStyle("C{$row}:E{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Gap column — color green/red based on value
            $gapVal = $sheet->getCell("E{$row}")->getValue();
            if ($gapVal !== '' && $gapVal !== null) {
                $color = str_starts_with((string)$gapVal, '+') ? 'FF065F46' : 'FF991B1B';
                $sheet->getStyle("E{$row}")->getFont()->getColor()->setARGB($color);
                $sheet->getStyle("E{$row}")->getFont()->setBold(true);
            }
        }

        // ── Instructions note below data ──
        $noteRow = $lastRow + 2;
        $sheet->setCellValue("A{$noteRow}", "📝 HOW TO USE THIS TEMPLATE:");
        $sheet->getStyle("A{$noteRow}")->getFont()->setBold(true)->setSize(10);

        $sheet->setCellValue("A" . ($noteRow + 1), "1. Fill in 'Estimated Cost' and 'Scholarship Coverage' columns only.");
        $sheet->setCellValue("A" . ($noteRow + 2), "2. Do NOT change Item Name or No. columns.");
        $sheet->setCellValue("A" . ($noteRow + 3), "3. Do NOT add or delete rows.");
        $sheet->setCellValue("A" . ($noteRow + 4), "4. Repeat for each sheet (Arrival, Education, Living, Family).");
        $sheet->setCellValue("A" . ($noteRow + 5), "5. Save file and import back to the system.");

        for ($i = 0; $i <= 5; $i++) {
            $sheet->getStyle("A" . ($noteRow + $i))->getFont()->setColor(
                (new \PhpOffice\PhpSpreadsheet\Style\Color())->setARGB('FF64748B')
            );
            $sheet->mergeCells("A" . ($noteRow + $i) . ":E" . ($noteRow + $i));
        }

        // ── Column widths ──
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(32);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(18);

        // ── Row height for header ──
        $sheet->getRowDimension(1)->setRowHeight(24);
    }
}
