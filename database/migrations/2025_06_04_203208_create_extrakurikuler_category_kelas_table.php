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
        if (!Schema::hasTable('extrakurikuler_category_kelas')) {
            Schema::create('extrakurikuler_category_kelas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('extrakurikuler_categories')->cascadeOnDelete();
                $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['category_id', 'kelas_id'], 'ekskul_cat_kelas_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extrakurikuler_category_kelas');
    }
};
