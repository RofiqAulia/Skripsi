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
                '123456789',
                'john.doe@example.com',
                'password123',
                '25',
                'Software Engineer',
                'PT Example Technology',
                'Department Digital Platfrom, Ecosystem & Innovation', // department (Placement)
                'mentee',
            ],
            [
                'Jane Smith',
                '987654321',
                'jane.smith@example.com',
                '',
                '23',
                'Data Analyst',
                'Data Corp',
                'Department of Data Management & Analytics', // department (Placement)
                'mentee',
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'nik',
            'email',
            'password',
            'age',
            'position',
            'company',
            'department', // placement
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
