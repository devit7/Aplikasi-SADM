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
        if (!Schema::hasTable('worship_character_categories')) {
            Schema::create('worship_character_categories', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->text('deskripsi')->nullable();
                $table->json('predicates')->nullable()->comment('JSON array of available predicates (A-E)');
                $table->json('explanations')->nullable()->comment('JSON array of explanations (Excellent, Good, etc.)');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worship_character_categories');
    }
};
