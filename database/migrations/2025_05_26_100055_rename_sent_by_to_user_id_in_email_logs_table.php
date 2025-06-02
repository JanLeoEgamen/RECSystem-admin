<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            // Drop old foreign key and column
            $table->dropForeign(['sent_by']);
            $table->dropColumn('sent_by');

            // Add new column with foreign key
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            // Drop new foreign key and column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Re-add old column
            $table->foreignId('sent_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    }
};
