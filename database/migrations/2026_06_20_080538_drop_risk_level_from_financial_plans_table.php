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
            $table->dropColumn('risk_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_plans', function (Blueprint $table) {
            $table->enum('risk_level', ['low', 'medium', 'high'])->nullable();
        });
    }
};
