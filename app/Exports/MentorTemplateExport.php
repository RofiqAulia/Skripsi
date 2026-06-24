<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MentorTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'John Doe',
                'Senior Manager',
                'PT Example Indonesia',
                '3',
                'S1 Computer Science UI; S2 Business Administration ITB',
                'Software Engineer at Gojek; Tech Lead at Tokopedia',
                'Best Employee 2022; Speaker at TechConf',
            ],
            [
                'Jane Smith',
                'Data Scientist',
                'Unicorn Startup',
                '5',
                'S1 Statistics ITS',
                'Data Analyst at Shopee; Data Scientist at Traveloka',
                'Kaggle Grandmaster',
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'current_position',
            'company',
            'quota',
            'education',
            'career_journey',
            'achievements',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
