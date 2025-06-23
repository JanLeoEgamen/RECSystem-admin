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
        Schema::dropIfExists('quiz_attempt_answers');
        Schema::dropIfExists('quiz_answers');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
