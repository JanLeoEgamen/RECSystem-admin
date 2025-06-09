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
        Schema::create('survey_invitations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('survey_id')->constrained()->onDelete('cascade');
    $table->foreignId('member_id')->constrained()->onDelete('cascade');
    $table->string('token')->unique();
    $table->timestamp('sent_at')->nullable();
    $table->timestamp('answered_at')->nullable();
    $table->timestamp('results_sent_at')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_invitations');
    }
};
