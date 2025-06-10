<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('al_quran_student_assessments', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_id')->nullable()->after('created_by');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('al_quran_student_assessments', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
        });
    }
};
