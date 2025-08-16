<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('syllabuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained()->onDelete('cascade');
            $table->string('subject_name');
            $table->text('description')->nullable();
            $table->text('learning_goals')->nullable();
            $table->text('learning_outcomes')->nullable();
            $table->text('prerequisites')->nullable();
            $table->text('literature')->nullable();
            $table->text('assessment_methods')->nullable();
            $table->integer('hours')->nullable();
            $table->string('semester')->nullable();
            $table->json('history')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('syllabuses');
    }
};
