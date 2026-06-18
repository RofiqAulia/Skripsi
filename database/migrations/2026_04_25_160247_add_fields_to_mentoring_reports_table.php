<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentoring_reports', function (Blueprint $table) {

            // ✅ Pertemuan ke berapa
            $table->unsignedInteger('meeting_number')->after('mentoring_session_id');

            // ✅ Status workflow
            $table->enum('status', [
                'draft',
                'submitted',
                'revision',
                'rejected',
                'approved'
            ])->default('draft')->after('file');

            // ✅ Catatan mentor
            $table->text('mentor_notes')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('mentoring_reports', function (Blueprint $table) {
            $table->dropColumn([
                'meeting_number',
                'status',
                'mentor_notes'
            ]);
        });
    }
};