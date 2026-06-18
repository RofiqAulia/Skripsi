<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->string('university')->nullable()->change();
            $table->string('country')->nullable()->change();
        });

        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->string('university')->nullable(false)->change();
            $table->string('country')->nullable(false)->change();
        });

        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
        });
    }
};
