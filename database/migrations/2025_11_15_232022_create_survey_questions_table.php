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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->string('sub_category_name')->unique();
            // $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->longText('sub_category_description');
            $table->foreignId('question_category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->longText('question');
            $table->foreignId('rating_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
