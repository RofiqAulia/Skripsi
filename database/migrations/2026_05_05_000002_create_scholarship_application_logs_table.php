<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarship_application_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('scholarship_application_id')
                  ->constrained('scholarship_applications')
                  ->cascadeOnDelete();

            $table->string('stage');   // tahapan seleksi saat log ini dibuat
            $table->string('status');  // status di tahapan ini: pending | tidak_lolos | lolos
            $table->date('log_date');  // tanggal tahapan ini terjadi
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_application_logs');
    }
};
