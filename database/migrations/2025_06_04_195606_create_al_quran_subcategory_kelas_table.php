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
        if (!Schema::hasTable('al_quran_subcategory_kelas')) {
            Schema::create('al_quran_subcategory_kelas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subcategory_id')->constrained('al_quran_learning_subcategories')->cascadeOnDelete();
                $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['subcategory_id', 'kelas_id'], 'al_quran_kelas_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('al_quran_subcategory_kelas');
    }
};
