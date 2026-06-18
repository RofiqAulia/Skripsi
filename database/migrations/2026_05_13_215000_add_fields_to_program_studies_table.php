<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->string('competency')->nullable()->after('name');
            $table->integer('qs_rank')->nullable()->after('website');
            $table->text('description')->nullable()->after('qs_rank');
            $table->string('study_type')->nullable()->after('description');       // Jenis Study
            $table->string('study_duration')->nullable()->after('study_type');    // Lama Studi (tahun)
            $table->string('gpa')->nullable()->after('study_duration');           // Syarat IPK
            $table->json('english_test')->nullable()->after('gpa');               // Test Bahasa Inggris
            $table->string('other_language')->nullable()->after('english_test');  // Test Bahasa Lainnya
            $table->string('standardized_test')->nullable()->after('other_language');
            $table->boolean('req_standardized_test')->nullable()->after('standardized_test');
            $table->text('other')->nullable()->after('req_standardized_test');    // Lain-lain
            $table->date('open_date')->nullable()->after('other');
            $table->date('deadline')->nullable()->after('open_date');
            $table->date('screening_date')->nullable()->after('deadline');
            $table->date('written_test_date')->nullable()->after('screening_date');
            $table->date('interview_date')->nullable()->after('written_test_date');
            $table->date('shortlist_date')->nullable()->after('interview_date');
            $table->text('registration_process')->nullable()->after('shortlist_date'); // Cara Pendaftaran & Proses Seleksi
            $table->text('requirements')->nullable()->after('registration_process');   // Persyaratan
            $table->string('intake')->nullable()->after('requirements');
        });
    }

    public function down(): void
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->dropColumn([
                'competency', 'qs_rank', 'description', 'study_type', 'study_duration',
                'gpa', 'english_test', 'other_language', 'standardized_test', 'req_standardized_test',
                'other', 'open_date', 'deadline', 'screening_date', 'written_test_date',
                'interview_date', 'shortlist_date', 'registration_process', 'requirements', 'intake',
            ]);
        });
    }
};
