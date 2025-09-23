<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['tutorial_video', 'faq', 'user_guide', 'support']);
            $table->longText('content')->nullable(); // For FAQ answers, guide steps, support info
            $table->string('video_url')->nullable(); // For tutorial videos
            $table->string('contact_email')->nullable(); // For support contacts
            $table->string('contact_phone')->nullable(); // For support contacts
            $table->string('contact_hours')->nullable(); // For support contacts
            $table->json('steps')->nullable(); // For user guide steps
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manual_contents');
    }
};