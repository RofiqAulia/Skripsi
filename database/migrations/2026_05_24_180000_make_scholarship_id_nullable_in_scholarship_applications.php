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
        Schema::table('scholarship_applications', function (Blueprint $table) {
            // Attempt to drop the foreign key constraint if it exists
            try {
                $table->dropForeign(['scholarship_id']);
            } catch (\Exception $e) {
                // Foreign key constraint might have already been dropped
            }

            // Make the column nullable
            $table->unsignedBigInteger('scholarship_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarship_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('scholarship_id')->nullable(false)->change();
        });
    }
};
