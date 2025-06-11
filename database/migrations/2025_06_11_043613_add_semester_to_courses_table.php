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
        // Tambahkan semester ke tabel al_quran_learning_subcategories
        Schema::table('al_quran_learning_subcategories', function (Blueprint $table) {
            $table->string('semester')->nullable()->after('sub_nama');
        });

        // Tambahkan semester ke tabel extrakurikuler_categories
        Schema::table('extrakurikuler_categories', function (Blueprint $table) {
            $table->string('semester')->nullable()->after('nama');
        });

        // Tambahkan semester ke tabel worship_character_categories
        Schema::table('worship_character_categories', function (Blueprint $table) {
            $table->string('semester')->nullable()->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom semester dari tabel al_quran_learning_subcategories
        Schema::table('al_quran_learning_subcategories', function (Blueprint $table) {
            $table->dropColumn('semester');
        });

        // Hapus kolom semester dari tabel extrakurikuler_categories
        Schema::table('extrakurikuler_categories', function (Blueprint $table) {
            $table->dropColumn('semester');
        });

        // Hapus kolom semester dari tabel worship_character_categories
        Schema::table('worship_character_categories', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};
