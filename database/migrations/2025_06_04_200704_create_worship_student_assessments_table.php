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
        if (!Schema::hasTable('worship_student_assessments')) {
            Schema::create('worship_student_assessments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('worship_character_categories')->cascadeOnDelete();
                $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
                $table->string('predicate')->comment('Such as A, B, C, D, E');
                $table->string('explanation')->nullable()->comment('Such as Excellent, Good, Enough, etc.');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users');
                $table->foreignId('updated_by')->nullable()->constrained('users');
                $table->timestamps();

                $table->unique(['category_id', 'siswa_id'], 'worship_assessment_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worship_student_assessments');
    }
};
