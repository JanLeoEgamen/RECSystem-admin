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
    $table->foreignId('survey_id')->constrained()->onDelete('cascade');
    $table->text('question');
    $table->enum('type', ['short-answer', 'long-answer', 'checkbox', 'multiple-choice']);
    $table->json('options')->nullable(); // For checkbox and multiple-choice options
    $table->integer('order')->default(0);
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
