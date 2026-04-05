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
        Schema::create('survey_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('survey_name');
            $table->date('start_date'); // Y-m-d format
            $table->time('start_time');
            $table->date('end_date'); // Y-m-d format
            $table->time('end_time');
            $table->boolean('is_active')->default(0); // 0 - no : 1 - yes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_schedules');
    }
};
