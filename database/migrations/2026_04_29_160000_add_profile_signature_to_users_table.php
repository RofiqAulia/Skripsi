<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('company');
            $table->unsignedInteger('age')->nullable()->after('photo');
            $table->string('signature_image')->nullable()->after('age');
            $table->text('signature_pad')->nullable()->after('signature_image'); // base64 from signature pad
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo', 'age', 'signature_image', 'signature_pad']);
        });
    }
};
