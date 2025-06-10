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
        // Pivot untuk Al-Quran Subcategory
        if (!Schema::hasTable('al_quran_subcategory_staff_access')) {
            Schema::create('al_quran_subcategory_staff_access', function (Blueprint $table) {
                $table->id();
                $table->foreignId('staff_access_id')->constrained('staff_access')->onDelete('cascade');
                $table->foreignId('subcategory_id')->constrained('al_quran_learning_subcategories')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Pivot untuk Ekstrakurikuler Category
        if (!Schema::hasTable('extrakurikuler_category_staff_access')) {
            Schema::create('extrakurikuler_category_staff_access', function (Blueprint $table) {
                $table->id();
                $table->foreignId('staff_access_id')->constrained('staff_access')->onDelete('cascade');
                $table->foreignId('category_id')->constrained('extrakurikuler_categories')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Pivot untuk Worship Character Category
        if (!Schema::hasTable('worship_category_staff_access')) {
            Schema::create('worship_category_staff_access', function (Blueprint $table) {
                $table->id();
                $table->foreignId('staff_access_id')->constrained('staff_access')->onDelete('cascade');
                $table->foreignId('category_id')->constrained('worship_character_categories')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('al_quran_subcategory_staff_access');
        Schema::dropIfExists('extrakurikuler_category_staff_access');
        Schema::dropIfExists('worship_category_staff_access');
    }
};
