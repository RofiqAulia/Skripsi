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
        Schema::table('program_studies', function (Blueprint $table) {
            $table->boolean('is_approved')->default(true)->after('id');
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete()->after('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->dropForeign(['submitted_by']);
            $table->dropColumn(['is_approved', 'submitted_by']);
        });
    }
};
