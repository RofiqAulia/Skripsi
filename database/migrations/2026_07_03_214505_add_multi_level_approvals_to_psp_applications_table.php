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
        Schema::table('psp_applications', function (Blueprint $table) {
            $table->integer('approval_stage')->default(0)->comment('0=Submission, 1=Dept, 2=Group, 3=Direktorat/Approved');
            $table->foreignId('department_approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('group_approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('direktorat_approver_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamp('department_approved_at')->nullable();
            $table->timestamp('group_approved_at')->nullable();
            $table->timestamp('direktorat_approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psp_applications', function (Blueprint $table) {
            $table->dropForeign(['department_approver_id']);
            $table->dropForeign(['group_approver_id']);
            $table->dropForeign(['direktorat_approver_id']);
            
            $table->dropColumn([
                'approval_stage',
                'department_approver_id',
                'group_approver_id',
                'direktorat_approver_id',
                'department_approved_at',
                'group_approved_at',
                'direktorat_approved_at',
            ]);
        });
    }
};
