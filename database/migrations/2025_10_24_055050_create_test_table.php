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
        Schema::create('likert_scale', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->enum('likert', ['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree']);
            $table->timestamps();
        });

        Schema::create('skill_scale', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->string('dreyfus');
            $table->timestamps();
        });

        Schema::create('personality_test_question', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->enum('traits', ['Openness', 'Conscientiousness', 'Extraversion', 'Agreeableness', 'Neuroticism']);
            $table->string('question');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('skill_scale_field', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('skill_scale_field_hm', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('softskill_test_question', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('question');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test');
    }
};
