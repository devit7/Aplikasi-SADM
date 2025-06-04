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
        if (!Schema::hasTable('worship_category_staff_access')) {
            Schema::create('worship_category_staff_access', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('worship_character_categories')->cascadeOnDelete();
                $table->foreignId('staff_access_id')->constrained('staff_access')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['category_id', 'staff_access_id'], 'worship_cat_staff_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worship_category_staff_access');
    }
};
