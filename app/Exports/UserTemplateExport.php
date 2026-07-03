<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'John Doe',
                'john.doe@example.com',
                'password123',
                '25',
                'Software Engineer',
                'PT Example Technology',
                '1', // department_id (Placement)
                'mentee',
            ],
            [
                'Jane Smith',
                'jane.smith@example.com',
                '',
                '23',
                'Data Analyst',
                'Data Corp',
                '2', // department_id (Placement)
                'mentee',
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'password',
            'age',
            'position',
            'company',
            'department_id', // placement
            'roles',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
