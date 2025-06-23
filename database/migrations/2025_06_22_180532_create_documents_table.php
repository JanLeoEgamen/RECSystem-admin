<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_type');
            $table->string('file_size');
            $table->string('url')->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        Schema::create('document_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->boolean('is_viewed')->default(false);
            $table->timestamp('viewed_at')->nullable();
            $table->boolean('is_downloaded')->default(false);
            $table->timestamp('downloaded_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_member');
        Schema::dropIfExists('documents');
    }
};