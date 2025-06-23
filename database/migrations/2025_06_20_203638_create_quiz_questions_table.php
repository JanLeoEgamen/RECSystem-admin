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
Schema::create('quiz_questions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
    $table->text('question');
    $table->enum('type', ['identification', 'true-false', 'checkbox', 'multiple-choice']);
    $table->json('options')->nullable();
    $table->unsignedInteger('order')->default(0);
    $table->decimal('points', 8, 2)->default(1.00);
    $table->json('correct_answers')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
