<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $mentorRole = Role::firstOrCreate(['name' => 'mentor']);
        $pimpinanRole = Role::firstOrCreate(['name' => 'pimpinan']);
        $approverRole = Role::firstOrCreate(['name' => 'approver']);
        $menteeRole = Role::firstOrCreate(['name' => 'mentee']);

        // Default password for all test users
        $password = Hash::make('password123');

        // 1. Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@test.com'],
            [
                'name' => 'Super Admin',
                'password' => $password,
                'position' => 'Super Administrator',
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // 2. Create Mentor
        $mentorUser = User::firstOrCreate(
            ['email' => 'mentor@test.com'],
            [
                'name' => 'Budi Mentor',
                'password' => $password,
                'position' => 'Senior Mentor',
                'company' => 'Tech Corp',
            ]
        );
        $mentorUser->assignRole($mentorRole);

        // Create Mentor Profile
        Mentor::firstOrCreate(
            ['user_id' => $mentorUser->id],
            [
                'current_position' => 'Senior Mentor',
                'company' => 'Tech Corp',
                'quota' => 10,
                'education' => ['S1 Informatika UI'],
                'career_journey' => ['Software Engineer at X', 'Senior Dev at Y'],
                'achievements' => ['Best Mentor 2023'],
            ]
        );

        // 3. Create Pimpinan
        $pimpinan = User::firstOrCreate(
            ['email' => 'pimpinan@test.com'],
            [
                'name' => 'Pak Pimpinan',
                'password' => $password,
                'position' => 'Direktur Utama',
            ]
        );
        $pimpinan->assignRole($pimpinanRole);

        // 4. Create Mentee / Regular User
        $mentee = User::firstOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'Siswa Mentee',
                'password' => $password,
                'position' => 'Student',
            ]
        );
        $mentee->assignRole($menteeRole);
    }
}
