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
        Schema::create('survey_responses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('survey_id')->constrained()->onDelete('cascade');
    $table->foreignId('member_id')->constrained()->onDelete('cascade');
    $table->timestamp('started_at')->nullable();
    $table->timestamp('completed_at')->nullable();
    $table->integer('score')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
