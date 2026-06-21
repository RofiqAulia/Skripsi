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
            $table->string('status')->default('approved')->after('is_approved');
            $table->text('admin_notes')->nullable()->after('status');
        });

        // Set pending for any that were not approved
        \Illuminate\Support\Facades\DB::table('program_studies')
            ->where('is_approved', false)
            ->update(['status' => 'pending']);

        Schema::table('program_studies', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });
    }

    public function down(): void
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->boolean('is_approved')->default(true);
        });

        \Illuminate\Support\Facades\DB::table('program_studies')
            ->where('status', '!=', 'approved')
            ->update(['is_approved' => false]);

        Schema::table('program_studies', function (Blueprint $table) {
            $table->dropColumn(['status', 'admin_notes']);
        });
    }
};
