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
        Schema::create('financial_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_plan_id')->constrained()->cascadeOnDelete();
            $table->enum('category', ['arrival', 'education', 'living', 'family']);
            $table->string('item_name');
            $table->decimal('estimated_cost', 15, 2)->default(0);
            $table->decimal('scholarship_coverage', 15, 2)->default(0);
            $table->decimal('personal_coverage', 15, 2)->default(0);
            $table->decimal('gap_amount', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_plan_items');
    }
};
