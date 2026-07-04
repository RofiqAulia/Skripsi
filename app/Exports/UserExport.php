<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return User::all();
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->nik,
            $user->email,
            $user->age,
            $user->position,
            $user->company,
            $user->department?->name ?? $user->group?->name ?? $user->direktorat?->name, // Placement (Department/Group/Direktorat Name)
            $user->roles->pluck('name')->join(', '), // optionally include roles
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'NIK',
            'Email',
            'Age',
            'Position',
            'Company',
            'Department', // Placement
            'Roles',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
