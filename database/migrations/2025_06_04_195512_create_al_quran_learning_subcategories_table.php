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
            $table->string('sub_nama');
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
