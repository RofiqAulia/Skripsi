<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarship_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scholarship_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_study_id')->constrained()->cascadeOnDelete();

            // Korelasi dengan PSP Application (nullable, auto-linked jika scholarship sama)
            $table->foreignId('psp_application_id')
                  ->nullable()
                  ->constrained('psp_applications')
                  ->nullOnDelete();

            $table->string('university')->nullable();

            // Tahapan & status TERKINI (snapshot dari log terbaru)
            $table->string('current_stage')->default('pendaftaran');
            $table->string('status')->default('pending'); // pending | tidak_lolos | lolos

            $table->date('updated_date');
            $table->text('notes')->nullable();

            // Anti-duplikasi: satu mentee tidak bisa mendaftarkan beasiswa+prodi yang sama 2x
            $table->unique(['user_id', 'scholarship_id', 'program_study_id'], 'sa_unique_application');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_applications');
    }
};
