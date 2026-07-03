<?php

namespace App\Exports;

use App\Models\Direktorat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrganizationExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $rows = collect();
        
        // Eager load everything to optimize queries
        $direktorats = Direktorat::with(['head', 'groups.head', 'groups.departments.head'])->get();

        foreach ($direktorats as $dir) {
            if ($dir->groups->isEmpty()) {
                $rows->push([
                    'direktorat_name' => $dir->name,
                    'direktur_email' => $dir->head?->email,
                    'group_name' => null,
                    'svp_email' => null,
                    'department_name' => null,
                    'gm_email' => null,
                ]);
            } else {
                foreach ($dir->groups as $group) {
                    if ($group->departments->isEmpty()) {
                        $rows->push([
                            'direktorat_name' => $dir->name,
                            'direktur_email' => $dir->head?->email,
                            'group_name' => $group->name,
                            'svp_email' => $group->head?->email,
                            'department_name' => null,
                            'gm_email' => null,
                        ]);
                    } else {
                        foreach ($group->departments as $dept) {
                            $rows->push([
                                'direktorat_name' => $dir->name,
                                'direktur_email' => $dir->head?->email,
                                'group_name' => $group->name,
                                'svp_email' => $group->head?->email,
                                'department_name' => $dept->name,
                                'gm_email' => $dept->head?->email,
                            ]);
                        }
                    }
                }
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'direktorat_name',
            'direktur_email',
            'group_name',
            'svp_email',
            'department_name',
            'gm_email',
        ];
    }

    public function map($row): array
    {
        return [
            $row['direktorat_name'],
            $row['direktur_email'],
            $row['group_name'],
            $row['svp_email'],
            $row['department_name'],
            $row['gm_email'],
        ];
    }
}
