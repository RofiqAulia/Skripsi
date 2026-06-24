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
        if (User::where('email', $row['email'])->exists()) {
            $this->errors[] = "Email {$row['email']} is already registered.";
            $this->rowsSkipped++;
            return null;
        }

        $this->rowsImported++;

        $user = User::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make(empty($row['password']) ? 'password123' : $row['password']),
            'age' => empty($row['age']) ? null : (int) $row['age'],
            'position' => $row['position'] ?? null,
            'company' => $row['company'] ?? null,
        ]);

        // Assign role if supported
        if (method_exists($user, 'assignRole')) {
            $role = !empty($row['roles']) ? trim($row['roles']) : 'mentee';
            $user->assignRole($role);
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
