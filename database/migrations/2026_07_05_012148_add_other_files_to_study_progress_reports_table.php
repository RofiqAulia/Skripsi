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
        Schema::table('study_progress_reports', function (Blueprint $table) {
            $table->json('other_files')->nullable()->after('certificates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_progress_reports', function (Blueprint $table) {
            $table->dropColumn('other_files');
        });
    }
};
