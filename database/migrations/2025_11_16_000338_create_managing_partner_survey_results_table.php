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
        Schema::create('managing_partner_survey_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_question_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('grading_1_count');
            $table->string('grading_2_count');
            $table->string('grading_3_count');
            $table->string('grading_4_count');
            $table->string('grading_5_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managing_partner_survey_results');
    }
};
