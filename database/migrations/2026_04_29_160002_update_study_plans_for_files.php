<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_plans', function (Blueprint $table) {
            // Make text nullable (user may upload files instead)
            $table->text('future_competence')->nullable()->change();
            // JSON array of uploaded file paths
            $table->json('files')->nullable()->after('future_competence');
        });
    }

    public function down(): void
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->text('future_competence')->nullable(false)->change();
            $table->dropColumn('files');
        });
    }
};
