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
        Schema::create('financial_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scholarship_application_id')->constrained('scholarship_applications')->cascadeOnDelete();
            
            $table->string('country_destination')->nullable();
            $table->string('university_name')->nullable();
            $table->integer('study_duration_month')->nullable();
            $table->string('currency')->default('IDR');
            
            $table->decimal('scholarship_amount', 15, 2)->default(0);
            $table->decimal('personal_funding', 15, 2)->default(0);
            $table->decimal('company_support', 15, 2)->default(0);
            $table->decimal('emergency_fund', 15, 2)->default(0);
            
            $table->decimal('total_estimated_cost', 15, 2)->default(0);
            $table->decimal('total_funding', 15, 2)->default(0);
            $table->decimal('funding_gap', 15, 2)->default(0);
            
            $table->integer('readiness_percentage')->default(0);
            
            $table->enum('risk_level', ['low', 'medium', 'high'])->nullable();
            $table->enum('status', ['draft', 'submitted', 'under_review', 'revision_needed', 'approved'])->default('draft');
            
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_plans');
    }
};
