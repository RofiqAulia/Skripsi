<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add revisi to enum
        DB::statement("ALTER TABLE documents MODIFY COLUMN status ENUM('uploaded', 'approved', 'rejected', 'revisi') DEFAULT 'uploaded'");
        // 2. Update existing 'rejected' to 'revisi'
        DB::table('documents')->where('status', 'rejected')->update(['status' => 'revisi']);
        // 3. Remove 'rejected' from enum
        DB::statement("ALTER TABLE documents MODIFY COLUMN status ENUM('uploaded', 'approved', 'revisi') DEFAULT 'uploaded'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Add rejected to enum
        DB::statement("ALTER TABLE documents MODIFY COLUMN status ENUM('uploaded', 'approved', 'revisi', 'rejected') DEFAULT 'uploaded'");
        // 2. Update existing 'revisi' to 'rejected'
        DB::table('documents')->where('status', 'revisi')->update(['status' => 'rejected']);
        // 3. Remove 'revisi' from enum
        DB::statement("ALTER TABLE documents MODIFY COLUMN status ENUM('uploaded', 'approved', 'rejected') DEFAULT 'uploaded'");
    }
};
