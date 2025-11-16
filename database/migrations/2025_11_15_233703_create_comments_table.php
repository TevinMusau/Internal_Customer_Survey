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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('comment_about')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->longText('comment');
            $table->date('date');
            $table->string('comment_type'); // can be 'End of Survey' or 'General'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
