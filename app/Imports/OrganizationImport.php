<?php

namespace App\Imports;

use App\Models\Direktorat;
use App\Models\Group;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrganizationImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Direktorat
            $dirName = $row['direktorat_name'] ?? null;
            $dirEmail = $row['direktur_email'] ?? null;
            
            // Group
            $groupName = $row['group_name'] ?? null;
            $svpEmail = $row['svp_email'] ?? null;
            
            // Department
            $deptName = $row['department_name'] ?? null;
            $gmEmail = $row['gm_email'] ?? null;

            // Skip empty rows
            if (!$dirName) {
                continue;
            }

            // Find direktur
            $direkturId = null;
            if ($dirEmail) {
                $direktur = User::where('email', $dirEmail)->first();
                $direkturId = $direktur?->id;
            }

            $direktorat = Direktorat::updateOrCreate(
                ['name' => $dirName],
                ['head_id' => $direkturId]
            );

            if ($groupName) {
                // Find SVP
                $svpId = null;
                if ($svpEmail) {
                    $svp = User::where('email', $svpEmail)->first();
                    $svpId = $svp?->id;
                }

                $group = Group::updateOrCreate(
                    [
                        'name' => $groupName,
                        'direktorat_id' => $direktorat->id
                    ],
                    [
                        'head_id' => $svpId
                    ]
                );

                if ($deptName) {
                    // Find GM
                    $gmId = null;
                    if ($gmEmail) {
                        $gm = User::where('email', $gmEmail)->first();
                        $gmId = $gm?->id;
                    }

                    Department::updateOrCreate(
                        [
                            'name' => $deptName,
                            'group_id' => $group->id
                        ],
                        [
                            'head_id' => $gmId
                        ]
                    );
                }
            }
        }
    }
}
