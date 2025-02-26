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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_kelas_id')->constrained('detail_kelas')->onDelete('cascade');
            $table->foreignId('matapelajaran_id')->constrained('matapelajaran')->onDelete('cascade');
            $table->string('nilai_uas');
            $table->string('nilai_uts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
