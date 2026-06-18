<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('psp_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('study_plan_id')->nullable()->constrained()->nullOnDelete();

            $table->text('study_plan_text');

            $table->enum('status', ['submission','review','approved','rejected'])
                ->default('submission');

            $table->foreignId('approved_by')->nullable()->constrained('users');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psp_applications');
    }
};
