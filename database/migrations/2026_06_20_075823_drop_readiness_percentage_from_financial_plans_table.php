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
        Schema::table('financial_plans', function (Blueprint $table) {
            $table->dropColumn('readiness_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_plans', function (Blueprint $table) {
            $table->integer('readiness_percentage')->default(0);
        });
    }
};
