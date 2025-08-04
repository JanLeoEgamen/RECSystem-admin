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
        Schema::create('member_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // e.g., 'payment', 'status_change', 'profile_update', etc.
            $table->string('action'); // e.g., 'created', 'updated', 'failed', 'succeeded', 'pending'
            $table->string('details')->nullable(); // short summary
            $table->json('meta')->nullable(); // arbitrary structured data: amount, transaction_id, previous_status, etc.
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_activity_logs');
    }
};
