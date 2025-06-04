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
        if (!Schema::hasTable('worship_category_kelas')) {
            Schema::create('worship_category_kelas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('worship_character_categories')->cascadeOnDelete();
                $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['category_id', 'kelas_id'], 'worship_cat_kelas_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worship_category_kelas');
    }
};
