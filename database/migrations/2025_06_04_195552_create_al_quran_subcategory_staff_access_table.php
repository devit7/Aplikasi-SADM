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
        if (!Schema::hasTable('al_quran_subcategory_staff_access')) {
            Schema::create('al_quran_subcategory_staff_access', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subcategory_id')->constrained('al_quran_learning_subcategories')->cascadeOnDelete();
                $table->foreignId('staff_access_id')->constrained('staff_access')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['subcategory_id', 'staff_access_id'], 'al_quran_staff_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('al_quran_subcategory_staff_access');
    }
};
