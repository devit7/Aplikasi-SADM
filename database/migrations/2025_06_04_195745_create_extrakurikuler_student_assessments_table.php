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
        if (!Schema::hasTable('extrakurikuler_student_assessments')) {
            Schema::create('extrakurikuler_student_assessments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('extrakurikuler_categories')->cascadeOnDelete();
                $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
                $table->string('predicate')->comment('Such as A, B, C, D, E');
                $table->string('explanation')->nullable()->comment('Such as Excellent, Good, Enough, etc.');
                $table->string('created_by');
                $table->timestamps();

                $table->unique(['category_id', 'siswa_id'], 'ekskul_assessment_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extrakurikuler_student_assessments');
    }
};
