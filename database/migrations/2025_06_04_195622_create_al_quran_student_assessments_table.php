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
        if (!Schema::hasTable('al_quran_student_assessments')) {
            Schema::create('al_quran_student_assessments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subcategory_id')->constrained('al_quran_learning_subcategories')->cascadeOnDelete();
                $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
                $table->string('predicate')->comment('Such as A, B, C, D, E');
                $table->string('explanation')->nullable()->comment('Such as Excellent, Good, Enough, etc.');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users');
                $table->foreignId('updated_by')->nullable()->constrained('users');
                $table->timestamps();

                $table->unique(['subcategory_id', 'siswa_id'], 'al_quran_assessment_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('al_quran_student_assessments');
    }
};
