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
        // Validate required fields
        if (empty($row['name']) || empty($row['email'])) {
            $this->rowsSkipped++;
            $this->errors[] = "Row skipped: Name or email is empty.";
            return null;
        }

        // Check if user already exists
        $user = User::where('email', $row['email'])->first();

        // Validate department (placement) is not empty for NEW users
        if (empty($row['department']) && empty($row['department_id'])) {
            if (!$user || (!$user->department_id && !$user->group_id && !$user->direktorat_id)) {
                $this->rowsSkipped++;
                $this->errors[] = "Row skipped: Placement (department) cannot be empty for user {$row['email']}.";
                return null;
            }
        }

        if (!filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
            $this->rowsSkipped++;
            $this->errors[] = "Row skipped: Invalid email format ({$row['email']}).";
            return null;
        }

        $departmentId = $user ? $user->department_id : null;
        $groupId = $user ? $user->group_id : null;
        $direktoratId = $user ? $user->direktorat_id : null;

        if (!empty($row['department'])) {
            $placementName = $row['department'];
            
            // Reset IDs since a new placement is provided
            $departmentId = null;
            $groupId = null;
            $direktoratId = null;
            
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

            // Reject if placement name is provided but not found
            if (!$departmentId && !$groupId && !$direktoratId) {
                $this->rowsSkipped++;
                $this->errors[] = "Row skipped: Placement '{$placementName}' not found for user {$row['email']}.";
                return null;
            }
        } elseif (!empty($row['department_id'])) {
            $departmentId = $row['department_id']; // Fallback
        }

        $data = [
            'name' => $row['name'],
            'nik' => $row['nik'] ?? null,
            'email' => $row['email'],
            'age' => empty($row['age']) ? null : (int) $row['age'],
            'position' => $row['position'] ?? null,
            'company' => $row['company'] ?? null,
            'department_id' => $departmentId,
            'group_id' => $groupId,
            'direktorat_id' => $direktoratId,
        ];

        $role = !empty($row['roles']) ? trim($row['roles']) : 'mentee';

        if ($role === 'pimpinan') {
            $existingPimpinan = null;
            if ($departmentId) {
                $existingPimpinan = User::role('pimpinan')->where('department_id', $departmentId)->where('id', '!=', $user?->id)->first();
            } elseif ($groupId) {
                $existingPimpinan = User::role('pimpinan')->where('group_id', $groupId)->where('id', '!=', $user?->id)->first();
            } elseif ($direktoratId) {
                $existingPimpinan = User::role('pimpinan')->where('direktorat_id', $direktoratId)->where('id', '!=', $user?->id)->first();
            }

            if ($existingPimpinan) {
                $this->rowsSkipped++;
                $placementName = $row['department'] ?? 'the selected placement';
                $this->errors[] = "Row skipped: A 'pimpinan' already exists for {$placementName}.";
                return null;
            }
        }

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
