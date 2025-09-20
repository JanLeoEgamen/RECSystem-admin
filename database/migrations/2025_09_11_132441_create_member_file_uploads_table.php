<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('member_file_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_file_id')->constrained('member_files');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('file_size');
            $table->text('notes')->nullable();
            $table->timestamp('uploaded_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_file_uploads');
    }
};