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
        Schema::create('syllabus_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->integer('version_number')->default(1);
            $table->boolean('dark_mode')->default(false);
            $table->string('unit');
            $table->string('major');
            $table->string('profile');
            $table->string('specialty');
            $table->string('module_type');
            $table->integer('ects');
            $table->string('year_semester');
            $table->string('coordinator');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->unique(['course_id', 'version_number']); // Ensure unique versions per course
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('current_version_id')->references('id')->on('syllabus_versions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabus_versions');
    }
};
