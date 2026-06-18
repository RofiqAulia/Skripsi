<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudy;
use Carbon\Carbon;

class ProgramStudySeeder extends Seeder
{
    public function run()
    {
        // Sample program study entries
        $programs = [
            [
                'name' => 'Master of Data Science',
                'degree' => 'Master',
                'university' => 'University of Oxford',
                'country' => 'UK',
                'website' => 'https://www.ox.ac.uk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bachelor of Computer Engineering',
                'degree' => 'Bachelor',
                'university' => 'National University of Singapore',
                'country' => 'Singapore',
                'website' => 'https://www.nus.edu.sg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($programs as $data) {
            ProgramStudy::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
?>
