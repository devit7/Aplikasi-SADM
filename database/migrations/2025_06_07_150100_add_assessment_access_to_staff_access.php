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
        Schema::table('staff_access', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkannya
            if (!Schema::hasColumn('staff_access', 'akses_alquran_learning')) {
                $table->boolean('akses_alquran_learning')->default(false);
            }
            
            if (!Schema::hasColumn('staff_access', 'akses_extrakurikuler')) {
                $table->boolean('akses_extrakurikuler')->default(false);
            }
            
            if (!Schema::hasColumn('staff_access', 'akses_worship_character')) {
                $table->boolean('akses_worship_character')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_access', function (Blueprint $table) {
            // Cek apakah kolom ada sebelum menghapusnya
            if (Schema::hasColumn('staff_access', 'akses_alquran_learning')) {
                $table->dropColumn('akses_alquran_learning');
            }
            
            if (Schema::hasColumn('staff_access', 'akses_extrakurikuler')) {
                $table->dropColumn('akses_extrakurikuler');
            }
            
            if (Schema::hasColumn('staff_access', 'akses_worship_character')) {
                $table->dropColumn('akses_worship_character');
            }
        });
    }
};
