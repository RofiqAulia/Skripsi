<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_progress_reports', function (Blueprint $table) {
            $table->json('certificates')->nullable()->after('manual_file_path');
            $table->longText('signature_pad')->nullable()->after('certificates');
            $table->string('signature_image')->nullable()->after('signature_pad');
        });
    }

    public function down(): void
    {
        Schema::table('study_progress_reports', function (Blueprint $table) {
            $table->dropColumn(['certificates', 'signature_pad', 'signature_image']);
        });
    }
};
