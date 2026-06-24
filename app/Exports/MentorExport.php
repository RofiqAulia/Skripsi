<?php

namespace App\Exports;

use App\Models\Mentor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MentorExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Mentor::with('user')->get();
    }

    public function map($mentor): array
    {
        $flatten = function ($arr) {
            if (!is_array($arr)) return '';
            return collect($arr)->map(function ($item) {
                return is_array($item) ? ($item['value'] ?? '') : $item;
            })->filter()->join('; ');
        };

        return [
            $mentor->user->name ?? '-',
            $mentor->user->email ?? '-',
            $mentor->current_position,
            $mentor->company,
            $mentor->quota,
            $flatten($mentor->education),
            $flatten($mentor->career_journey),
            $flatten($mentor->achievements),
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Current Position',
            'Company',
            'Quota',
            'Education',
            'Career Journey',
            'Achievements',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
