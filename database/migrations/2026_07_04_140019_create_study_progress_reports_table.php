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
        Schema::create('study_progress_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('psp_application_id')->nullable()->constrained('psp_applications')->nullOnDelete();
            
            $table->integer('semester');
            $table->string('gpa')->nullable();
            $table->string('max_gpa')->nullable();
            $table->string('status')->default('submission'); // submission, approved, rejected, review

            // JSON Columns for Repeaters
            $table->json('completed_courses')->nullable();
            $table->json('ongoing_courses')->nullable();
            $table->json('upcoming_courses')->nullable();
            
            // Thesis/Research Data
            $table->string('thesis_title')->nullable();
            $table->string('thesis_title_status')->nullable();
            
            $table->string('thesis_proposal')->nullable();
            $table->string('thesis_proposal_status')->nullable();
            
            $table->string('proposal_exam_status')->nullable();
            $table->date('proposal_exam_date')->nullable();
            $table->string('proposal_exam_score')->nullable();
            
            $table->string('proposal_revision_status')->nullable();
            
            $table->string('research_implementation_status')->nullable();
            $table->string('data_collection_status')->nullable();
            $table->string('data_analysis_status')->nullable();
            $table->string('thesis_writing_status')->nullable();
            
            $table->string('thesis_exam_status')->nullable();
            $table->date('thesis_exam_date')->nullable();
            $table->string('thesis_exam_score')->nullable();
            
            $table->string('thesis_revision_status')->nullable();
            $table->string('journal_article_status')->nullable();
            $table->string('journal_publication_status')->nullable();

            // JSON Column for Other Activities
            $table->json('other_academic_activities')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_progress_reports');
    }
};
