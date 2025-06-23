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
                Schema::dropIfExists('survey_invitations');
        Schema::dropIfExists('survey_answers');
        Schema::dropIfExists('survey_responses');
        Schema::dropIfExists('survey_questions');
        Schema::dropIfExists('surveys');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
