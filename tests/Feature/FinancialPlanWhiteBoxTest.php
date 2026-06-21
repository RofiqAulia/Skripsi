<?php

namespace Tests\Feature;

use App\Models\FinancialPlan;
use App\Models\FinancialPlanItem;
use App\Models\ProgramStudy;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinancialPlanWhiteBoxTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $programStudy;
    protected $scholarshipApp;
    protected $financialPlan;
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        
        // Setup data master
        $this->programStudy = ProgramStudy::create([
            'name' => 'Teknik Informatika',
            'code' => 'TI',
            'faculty' => 'Fasilkom',
            'study_duration' => '4' // Durasi default dalam bentuk angka (Tahun)
        ]);
        
        $scholarship = Scholarship::create([
            'name' => 'Beasiswa Luar Negeri',
            'provider' => 'Pemerintah',
            'description' => 'Full cover',
            'program_study_id' => $this->programStudy->id,
            'quota' => 10
        ]);

        $this->scholarshipApp = ScholarshipApplication::create([
            'user_id' => $this->user->id,
            'scholarship_id' => $scholarship->id,
            'program_study_id' => $this->programStudy->id,
            'status' => 'submitted'
        ]);

        $this->financialPlan = FinancialPlan::create([
            'user_id' => $this->user->id,
            'scholarship_application_id' => $this->scholarshipApp->id,
            'status' => 'draft'
        ]);

        $this->item = FinancialPlanItem::create([
            'financial_plan_id' => $this->financialPlan->id,
            'category' => 'education',
            'item_name' => 'Tuition Fee'
        ]);
    }

    /**
     * PATH 1: Mencegah akses User ID lain (Unauthorized)
     */
    public function test_path_1_unauthorized_user_cannot_save_plan()
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->postJson('/financial-plan/save', [
            'plan_id' => $this->financialPlan->id,
            'items' => [
                $this->item->id => [
                    'estimated_cost' => 1000000,
                    'scholarship_coverage' => 500000
                ]
            ]
        ]);

        $response->assertStatus(403);
    }

    /**
     * PATH 2: Durasi 'Bulan' & kalkulasi finansial
     */
    public function test_path_2_month_duration_and_financial_calculation()
    {
        // Kondisikan duration menggunakan kata "month"
        $this->programStudy->update(['study_duration' => '6 Months']);

        $response = $this->actingAs($this->user)->postJson('/financial-plan/save', [
            'plan_id' => $this->financialPlan->id,
            'items' => [
                $this->item->id => [
                    'estimated_cost' => 10000000,     // Butuh 10 juta
                    'scholarship_coverage' => 4000000 // Hanya tercover 4 juta (40%)
                ]
            ]
        ]);

        $response->assertStatus(200);

        // Verifikasi perhitungan sistem
        $this->assertDatabaseHas('financial_plans', [
            'id' => $this->financialPlan->id,
            'study_duration_month' => 6, // Sistem mengenali "6 Months" tanpa dikali 12
            'total_estimated_cost' => 10000000,
            'total_funding' => 4000000,
            'funding_gap' => -6000000,
        ]);
    }

    /**
     * PATH 3: Durasi 'Tahun' (<=6) & kalkulasi durasi
     */
    public function test_path_3_year_duration_and_calculation()
    {
        // Kondisikan duration angka murni (Sistem menganggap Tahun dan akan dikali 12)
        $this->programStudy->update(['study_duration' => '2']); 

        $response = $this->actingAs($this->user)->postJson('/financial-plan/save', [
            'plan_id' => $this->financialPlan->id,
            'items' => [
                $this->item->id => [
                    'estimated_cost' => 10000000,     // Butuh 10 juta
                    'scholarship_coverage' => 6000000 // Tercover 6 juta (60%)
                ]
            ]
        ]);

        $response->assertStatus(200);

        // Verifikasi perhitungan sistem
        $this->assertDatabaseHas('financial_plans', [
            'id' => $this->financialPlan->id,
            'study_duration_month' => 24, // Sistem otomatis mengalikan 2 * 12 = 24 Bulan
        ]);
    }

    /**
     * PATH 4: Durasi Lama (>6) & kalkulasi durasi
     */
    public function test_path_4_long_duration_and_calculation()
    {
        // Angka tahun lebih dari 6 tidak akan dikalikan 12 oleh sistem (bypassed protection)
        $this->programStudy->update(['study_duration' => '10']); 

        $response = $this->actingAs($this->user)->postJson('/financial-plan/save', [
            'plan_id' => $this->financialPlan->id,
            'items' => [
                $this->item->id => [
                    'estimated_cost' => 10000000,
                    'scholarship_coverage' => 9000000 // Tercover 90%
                ]
            ]
        ]);

        $response->assertStatus(200);

        // Verifikasi perhitungan sistem
        $this->assertDatabaseHas('financial_plans', [
            'id' => $this->financialPlan->id,
            'study_duration_month' => 10, // Sistem membiarkannya tetap 10 karena > 6
        ]);
    }

    /**
     * PATH 5: Penanganan Kasus Biaya Nol (Mencegah Zero Division Error)
     */
    public function test_path_5_zero_cost_avoidance()
    {
        $response = $this->actingAs($this->user)->postJson('/financial-plan/save', [
            'plan_id' => $this->financialPlan->id,
            'items' => [
                $this->item->id => [
                    'estimated_cost' => 0, // Sengaja diset 0 untuk memancing error pembagian matematika
                    'scholarship_coverage' => 0 
                ]
            ]
        ]);

        $response->assertStatus(200);

        // Sistem berhasil mengatasi error "Division By Zero"
        $this->assertDatabaseHas('financial_plans', [
            'id' => $this->financialPlan->id,
            'total_estimated_cost' => 0,
        ]);
    }
}
