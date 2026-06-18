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
        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('competency')->nullable();
            $table->string('country')->nullable();
            
            $table->integer('age')->nullable();
            $table->string('gpa')->nullable();
            $table->json('english_test')->nullable();
            $table->string('nationality')->nullable();
            $table->string('other_language')->nullable();
            $table->string('standardized_test')->nullable();
            $table->json('document')->nullable();
            $table->text('other')->nullable();
            
            $table->json('benefit')->nullable();
            
            $table->foreignId('program_study_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropForeign(['program_study_id']);
            $table->dropColumn([
                'competency', 'country', 'age', 'gpa', 'english_test', 
                'nationality', 'other_language', 'standardized_test', 
                'document', 'other', 'benefit', 'program_study_id'
            ]);
        });
    }
};
