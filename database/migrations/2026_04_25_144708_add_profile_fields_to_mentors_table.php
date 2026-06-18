<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentors', function (Blueprint $table) {
            $table->json('education')->nullable();
            $table->json('career_journey')->nullable();
            $table->json('achievements')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('mentors', function (Blueprint $table) {
            $table->dropColumn([
                'education',
                'career_journey',
                'achievements'
            ]);
        });
    }
};
