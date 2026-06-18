<?php

namespace Tests\Feature;

use App\Models\ProgramStudy;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PspWhiteBoxTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $programStudy;

    protected function setUp(): void
    {
        parent::setUp();

        // Persiapan data yang dibutuhkan untuk setiap path
        $this->user = User::factory()->create();
        $this->programStudy = ProgramStudy::create([
            'name' => 'Teknik Informatika',
            'code' => 'TI',
            'faculty' => 'Fasilkom'
        ]);
        
        Scholarship::create([
            'name' => 'Beasiswa Prestasi',
            'provider' => 'Kampus',
            'description' => 'Deskripsi beasiswa',
            'program_study_id' => $this->programStudy->id,
            'quota' => 10
        ]);
    }

    /**
     * PATH 1: Tidak ada teks dan tidak ada file (Validasi gagal)
     */
    public function test_path_1_empty_text_and_no_file()
    {
        $response = $this->actingAs($this->user)
            ->post(route('psp.store'), [
                'program_study_id' => $this->programStudy->id,
                'study_plan_text' => '',
                // Tidak mengirimkan study_plan_files
            ]);

        // Ekspektasi: Kembali ke halaman sebelumnya dengan error pada field study_plan_text
        $response->assertSessionHasErrors(['study_plan_text' => 'Please provide a study plan text or upload at least one file.']);
    }

    /**
     * PATH 2: Ada teks tetapi tidak ada file
     */
    public function test_path_2_with_text_and_no_file()
    {
        $response = $this->actingAs($this->user)
            ->post(route('psp.store'), [
                'program_study_id' => $this->programStudy->id,
                'study_plan_text' => 'Ini adalah teks rencana studi.',
            ]);

        // Ekspektasi: Berhasil dan data masuk ke database tanpa upload file
        $response->assertRedirect(route('psp'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('study_plans', [
            'user_id' => $this->user->id,
            'future_competence' => 'Ini adalah teks rencana studi.',
            'files' => null,
        ]);

        $this->assertDatabaseHas('psp_applications', [
            'user_id' => $this->user->id,
            'study_plan_text' => 'Ini adalah teks rencana studi.',
            'status' => 'submission',
        ]);
    }

    /**
     * PATH 3: Tidak ada teks tetapi ada file (1 file)
     */
    public function test_path_3_no_text_but_has_file()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf');

        $response = $this->actingAs($this->user)
            ->post(route('psp.store'), [
                'program_study_id' => $this->programStudy->id,
                'study_plan_text' => '',
                'study_plan_files' => [$file],
            ]);

        // Ekspektasi: Berhasil upload dan simpan
        $response->assertRedirect(route('psp'));
        $response->assertSessionHas('success');

        // Pastikan file tersimpan di storage public (Folder: study-plans/{user_id}/...)
        $files = Storage::disk('public')->allFiles("study-plans/{$this->user->id}");
        $this->assertCount(1, $files);

        $this->assertDatabaseHas('study_plans', [
            'user_id' => $this->user->id,
            'future_competence' => null,
        ]);
        
        $this->assertDatabaseHas('psp_applications', [
            'user_id' => $this->user->id,
            'study_plan_text' => null,
            'status' => 'submission',
        ]);
    }

    /**
     * PATH 4: Ada teks dan ada banyak file (Lebih dari 1 file untuk memastikan looping berjalan optimal)
     */
    public function test_path_4_with_text_and_multiple_files()
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->create('document1.pdf', 1000, 'application/pdf');
        $file2 = UploadedFile::fake()->create('document2.docx', 500, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $response = $this->actingAs($this->user)
            ->post(route('psp.store'), [
                'program_study_id' => $this->programStudy->id,
                'study_plan_text' => 'Rencana studi lengkap dengan dokumen.',
                'study_plan_files' => [$file1, $file2],
            ]);

        // Ekspektasi: Berhasil
        $response->assertRedirect(route('psp'));
        
        // Memastikan dua file masuk ke public storage
        $files = Storage::disk('public')->allFiles("study-plans/{$this->user->id}");
        $this->assertCount(2, $files);

        // Memastikan database terisi sempurna
        $this->assertDatabaseHas('study_plans', [
            'user_id' => $this->user->id,
            'future_competence' => 'Rencana studi lengkap dengan dokumen.',
        ]);
    }
}
