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
        if (!Schema::hasTable('extrakurikuler_category_staff_access')) {
            Schema::create('extrakurikuler_category_staff_access', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('extrakurikuler_categories')->cascadeOnDelete();
                $table->foreignId('staff_access_id')->constrained('staff_access')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['category_id', 'staff_access_id'], 'ekskul_staff_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extrakurikuler_category_staff_access');
    }
};
