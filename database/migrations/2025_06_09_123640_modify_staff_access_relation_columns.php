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
        // Cek apakah tabel staff_access memiliki kolom al_quran_learning_subcategories_id
        if (Schema::hasColumn('staff_access', 'al_quran_learning_subcategories_id')) {
            Schema::table('staff_access', function (Blueprint $table) {
                // Ubah kolom menjadi nullable jika sudah ada
                $table->foreignId('al_quran_learning_subcategories_id')->nullable()->change();
            });
        }
        
        // Cek apakah tabel staff_access memiliki kolom extrakurikuler_categories_id
        if (Schema::hasColumn('staff_access', 'extrakurikuler_categories_id')) {
            Schema::table('staff_access', function (Blueprint $table) {
                // Ubah kolom menjadi nullable jika sudah ada
                $table->foreignId('extrakurikuler_categories_id')->nullable()->change();
            });
        }
        
        // Cek apakah tabel staff_access memiliki kolom worship_character_categories_id
        if (Schema::hasColumn('staff_access', 'worship_character_categories_id')) {
            Schema::table('staff_access', function (Blueprint $table) {
                // Ubah kolom menjadi nullable jika sudah ada
                $table->foreignId('worship_character_categories_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom-kolom menjadi tidak nullable jika diperlukan
        if (Schema::hasColumn('staff_access', 'al_quran_learning_subcategories_id')) {
            Schema::table('staff_access', function (Blueprint $table) {
                $table->foreignId('al_quran_learning_subcategories_id')->nullable(false)->change();
            });
        }
        
        if (Schema::hasColumn('staff_access', 'extrakurikuler_categories_id')) {
            Schema::table('staff_access', function (Blueprint $table) {
                $table->foreignId('extrakurikuler_categories_id')->nullable(false)->change();
            });
        }
        
        if (Schema::hasColumn('staff_access', 'worship_character_categories_id')) {
            Schema::table('staff_access', function (Blueprint $table) {
                $table->foreignId('worship_character_categories_id')->nullable(false)->change();
            });
        }
    }
};
