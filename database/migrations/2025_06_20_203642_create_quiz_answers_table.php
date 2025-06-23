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
 Schema::create('quiz_answers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('response_id')->constrained('quiz_responses')->cascadeOnDelete();
    $table->foreignId('question_id')->constrained('quiz_questions')->cascadeOnDelete();
    $table->text('answer');
    $table->decimal('score', 8, 2)->default(0.00);
    $table->boolean('is_correct')->default(false);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};
