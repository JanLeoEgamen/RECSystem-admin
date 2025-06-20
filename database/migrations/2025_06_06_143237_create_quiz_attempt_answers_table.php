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
        Schema::create('quiz_attempt_answers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('attempt_id')->constrained('quiz_attempts')->onDelete('cascade');
    $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
    $table->text('answer')->nullable();
    $table->integer('points_earned')->default(0);
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempt_answers');
    }
};
