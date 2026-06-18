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
        Schema::table('financial_plan_items', function (Blueprint $table) {
            $table->string('reference_file_path')->nullable()->after('description');
            $table->string('reference_file_name')->nullable()->after('reference_file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_plan_items', function (Blueprint $table) {
            $table->dropColumn(['reference_file_path', 'reference_file_name']);
        });
    }
};
