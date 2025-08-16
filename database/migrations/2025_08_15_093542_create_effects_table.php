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
        Schema::create('effects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('syllabus_version_id');
            $table->string('number');
            $table->string('method');
            $table->string('grade_below_50');
            $table->string('grade_50_59');
            $table->string('grade_60_74');
            $table->string('grade_75_100');
            $table->timestamps();

            $table->foreign('syllabus_version_id')->references('id')->on('syllabus_versions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('effects');
    }
};
