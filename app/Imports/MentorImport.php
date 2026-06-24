<?php

namespace App\Imports;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class MentorImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private $rowsImported = 0;
    private $rowsSkipped = 0;
    private $errors = [];

    public function model(array $row)
    {
        // Skip if required fields are missing
        if (empty($row['name']) || empty($row['current_position']) || empty($row['company'])) {
            $this->rowsSkipped++;
            return null;
        }

        // Check if user exists by name
        $user = User::where('name', $row['name'])->first();

        if (!$user) {
            $this->errors[] = "User '{$row['name']}' not found in the database. Users must be registered before being added as a Mentor.";
            $this->rowsSkipped++;
            return null;
        }

        // Check if already a mentor
        if (Mentor::where('user_id', $user->id)->exists()) {
            $this->errors[] = "User '{$row['name']}' is already registered as a mentor.";
            $this->rowsSkipped++;
            return null;
        }

        // Update user's position and company if provided
        $user->update([
            'position' => $row['current_position'] ?? $user->position,
            'company' => $row['company'] ?? $user->company,
        ]);

        // Assign mentor role (assuming spatie/laravel-permission is used)
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('mentor');
        }

        // Parse array fields (flat arrays for Repeater->simple())
        $education = empty($row['education']) ? [] : array_map('trim', explode(';', $row['education']));
        $career = empty($row['career_journey']) ? [] : array_map('trim', explode(';', $row['career_journey']));
        $achievements = empty($row['achievements']) ? [] : array_map('trim', explode(';', $row['achievements']));

        $this->rowsImported++;

        return new Mentor([
            'user_id' => $user->id,
            'current_position' => $row['current_position'],
            'company' => $row['company'],
            'quota' => empty($row['quota']) ? 3 : (int) $row['quota'],
            'education' => $education,
            'career_journey' => $career,
            'achievements' => $achievements,
            // Provide a default photo or empty string depending on DB schema
            // If nullable, leave null. If not nullable, use a placeholder.
            // In MentorForm it's required, let's see if DB allows null or not. Let's use a dummy path.
            'photo' => 'images/mentorship.webp', 
        ]);
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
