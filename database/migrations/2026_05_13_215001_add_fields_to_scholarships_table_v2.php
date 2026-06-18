<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            // Kolom yang belum ada
            $table->integer('study_count')->nullable()->after('program_study_id');    // Jumlah Pilihan Program Studi
            $table->string('study_duration')->nullable()->after('study_count');       // Lama Waktu Studi
            $table->text('eligibility')->nullable()->after('study_duration');         // Eligibility
            $table->boolean('req_standardized_test')->nullable()->after('standardized_test');
            $table->date('screening_date')->nullable()->after('deadline');
            $table->date('written_test_date')->nullable()->after('screening_date');
            $table->date('interview_date')->nullable()->after('written_test_date');
            $table->date('shortlist_date')->nullable()->after('interview_date');
            $table->text('registration_process')->nullable()->after('shortlist_date'); // Cara Pendaftaran & Proses Seleksi
            $table->text('commitment')->nullable()->after('registration_process');     // Komitmen
            $table->string('website')->nullable()->after('commitment');               // Link Website
            $table->string('intake')->nullable()->after('website');
        });
    }

    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn([
                'study_count', 'study_duration', 'eligibility', 'req_standardized_test',
                'screening_date', 'written_test_date', 'interview_date', 'shortlist_date',
                'registration_process', 'commitment', 'website', 'intake',
            ]);
        });
    }
};
