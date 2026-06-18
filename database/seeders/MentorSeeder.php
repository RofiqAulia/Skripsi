<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mentor;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Mentor::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'current_position' => 'Mentor ' . $user->name,
                'company' => 'Company X',
                'quota' => 3,
            ]);
        }
    }
}
