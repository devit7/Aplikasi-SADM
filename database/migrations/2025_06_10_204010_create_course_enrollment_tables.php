<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel pivot untuk Al-Quran courses
        Schema::create('siswa_alquran_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained('al_quran_learning_subcategories')->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('users');
            $table->timestamps();

            // Pastikan siswa tidak bisa didaftarkan ke subcategory yang sama lebih dari sekali
            $table->unique(['siswa_id', 'subcategory_id']);
        });

        // Buat tabel pivot untuk Extrakurikuler courses
        Schema::create('siswa_extrakurikuler_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('extrakurikuler_categories')->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->unique(['siswa_id', 'category_id']);
        });

        // Buat tabel pivot untuk Worship courses
        Schema::create('siswa_worship_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('worship_character_categories')->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->unique(['siswa_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_worship_courses');
        Schema::dropIfExists('siswa_extrakurikuler_courses');
        Schema::dropIfExists('siswa_alquran_courses');
    }
};
