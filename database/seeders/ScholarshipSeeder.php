<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scholarship;
use App\Models\ProgramStudy;
use Carbon\Carbon;

class ScholarshipSeeder extends Seeder
{
    public function run()
    {
        // Ensure program studies exist
        $dataScience = ProgramStudy::firstOrCreate(['name' => 'Master of Data Science'], [
            'degree' => 'Master',
            'university' => 'University of Oxford',
            'country' => 'UK',
            'website' => 'https://www.ox.ac.uk',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $engineer = ProgramStudy::firstOrCreate(['name' => 'Bachelor of Computer Engineering'], [
            'degree' => 'Bachelor',
            'university' => 'National University of Singapore',
            'country' => 'Singapore',
            'website' => 'https://www.nus.edu.sg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $scholarships = [
            [
                'title' => 'Oxford Data Science Excellence Scholarship',
                'description' => 'Full tuition for the Master of Data Science program at Oxford.',
                'open_date' => Carbon::now()->subDays(10),
                'deadline' => Carbon::now()->addDays(20),
                'funding_type' => 'Full',
                'competency' => trim(str_replace(['Master of ', 'Bachelor of ', 'Doctor of '], '', $dataScience->name)),
                'country' => 'UK',
                'age' => '30',
                'gpa' => '3.5',
                'english_test' => [
                    ['test_name' => 'IELTS', 'minimum_score' => 7],
                    ['test_name' => 'TOEFL', 'minimum_score' => 100],
                ],
                'nationality' => 'International',
                'other_language' => 'None',
                'standardized_test' => 'GRE',
                'document' => [
                    ['document_name' => 'Transcript'],
                    ['document_name' => 'Recommendation Letter'],
                ],
                'other' => 'Applicants must have 2 years of work experience.',
                'benefit' => [
                    ['benefit_detail' => 'Full tuition coverage'],
                    ['benefit_detail' => 'Living stipend'],
                ],
                'program_study_id' => $dataScience->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'NUS Engineering Scholarship',
                'description' => 'Partial scholarship for the Bachelor of Computer Engineering.',
                'open_date' => Carbon::now()->subDays(5),
                'deadline' => Carbon::now()->addDays(30),
                'funding_type' => 'Partial',
                'competency' => trim(str_replace(['Master of ', 'Bachelor of ', 'Doctor of '], '', $engineer->name)),
                'country' => 'Singapore',
                'age' => '25',
                'gpa' => '3.2',
                'english_test' => [
                    ['test_name' => 'IELTS', 'minimum_score' => 6.5],
                ],
                'nationality' => 'Singaporean',
                'other_language' => 'Mandarin',
                'standardized_test' => 'SAT',
                'document' => [
                    ['document_name' => 'Passport Copy'],
                ],
                'other' => null,
                'benefit' => [
                    ['benefit_detail' => '50% tuition waiver'],
                ],
                'program_study_id' => $engineer->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($scholarships as $data) {
            Scholarship::updateOrCreate(['title' => $data['title']], $data);
        }
    }
}
?>
