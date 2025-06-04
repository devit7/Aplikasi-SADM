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
        Schema::create('al_quran_learning_subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('al_quran_learning_categories')->cascadeOnDelete();
            $table->string('nama');
            $table->json('predicates')->nullable()->comment('JSON array of available predicates (A-E)');
            $table->json('explanations')->nullable()->comment('JSON array of explanations (Excellent, Good, etc.)');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('al_quran_learning_subcategories');
    }
};
