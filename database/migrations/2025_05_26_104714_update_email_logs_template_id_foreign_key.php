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
        Schema::table('email_logs', function (Blueprint $table) {
            // Drop existing foreign key constraint on template_id
            $table->dropForeign(['template_id']);
            
            // Re-add foreign key with onDelete('set null')
            $table->foreign('template_id')
                  ->references('id')->on('email_templates')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            // Drop the foreign key with onDelete('set null')
            $table->dropForeign(['template_id']);
            
            // Restore original foreign key with onDelete('cascade')
            $table->foreign('template_id')
                  ->references('id')->on('email_templates')
                  ->onDelete('cascade');
        });
    }
};
