<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UserImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private $rowsImported = 0;
    private $rowsSkipped = 0;
    private $errors = [];

    public function model(array $row)
    {
        // Skip if required fields are missing
        if (empty($row['name']) || empty($row['email'])) {
            $this->rowsSkipped++;
            return null;
        }

        // Check if user already exists
        $user = User::where('email', $row['email'])->first();

        $departmentId = null;
        $groupId = null;
        $direktoratId = null;

        if (!empty($row['department'])) {
            $placementName = $row['department'];
            
            // Try to find as Department
            $department = \App\Models\Department::where('name', $placementName)->first();
            if ($department) {
                $departmentId = $department->id;
            } else {
                // Try to find as Group
                $group = \App\Models\Group::where('name', $placementName)->first();
                if ($group) {
                    $groupId = $group->id;
                } else {
                    // Try to find as Direktorat
                    $direktorat = \App\Models\Direktorat::where('name', $placementName)->first();
                    if ($direktorat) {
                        $direktoratId = $direktorat->id;
                    }
                }
            }
        } elseif (!empty($row['department_id'])) {
            $departmentId = $row['department_id']; // Fallback
        }

        $data = [
            'name' => $row['name'],
            'email' => $row['email'],
            'age' => empty($row['age']) ? null : (int) $row['age'],
            'position' => $row['position'] ?? null,
            'company' => $row['company'] ?? null,
            'department_id' => $departmentId,
            'group_id' => $groupId,
            'direktorat_id' => $direktoratId,
        ];

        // Only update password if provided or if creating new
        if (!$user) {
            $data['password'] = Hash::make(empty($row['password']) ? 'password123' : $row['password']);
        } elseif (!empty($row['password'])) {
            $data['password'] = Hash::make($row['password']);
        }

        if ($user) {
            $user->update($data);
        } else {
            $user = User::create($data);
        }

        $this->rowsImported++;

        // Assign role if supported
        if (method_exists($user, 'assignRole')) {
            $role = !empty($row['roles']) ? trim($row['roles']) : 'mentee';
            $user->syncRoles([$role]);
        }

        return $user;
    }

    public function getRowsImported()
    {
        return $this->rowsImported;
    }

    public function getRowsSkipped()
    {
        return $this->rowsSkipped;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
