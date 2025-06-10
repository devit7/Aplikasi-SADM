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
        // Tambahkan tahun_ajaran ke tabel al_quran_learning_subcategories
        Schema::table('al_quran_learning_subcategories', function (Blueprint $table) {
            $table->string('tahun_ajaran')->nullable()->after('sub_nama');
        });

        // Tambahkan tahun_ajaran ke tabel extrakurikuler_categories
        Schema::table('extrakurikuler_categories', function (Blueprint $table) {
            $table->string('tahun_ajaran')->nullable()->after('nama');
        });

        // Tambahkan tahun_ajaran ke tabel worship_character_categories
        Schema::table('worship_character_categories', function (Blueprint $table) {
            $table->string('tahun_ajaran')->nullable()->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom tahun_ajaran dari tabel al_quran_learning_subcategories
        Schema::table('al_quran_learning_subcategories', function (Blueprint $table) {
            $table->dropColumn('tahun_ajaran');
        });

        // Hapus kolom tahun_ajaran dari tabel extrakurikuler_categories
        Schema::table('extrakurikuler_categories', function (Blueprint $table) {
            $table->dropColumn('tahun_ajaran');
        });

        // Hapus kolom tahun_ajaran dari tabel worship_character_categories
        Schema::table('worship_character_categories', function (Blueprint $table) {
            $table->dropColumn('tahun_ajaran');
        });
    }
};
