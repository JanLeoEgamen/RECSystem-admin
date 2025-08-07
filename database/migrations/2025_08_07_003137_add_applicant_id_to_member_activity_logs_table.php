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
        Schema::table('member_activity_logs', function (Blueprint $table) {
            // Make member_id nullable first (to avoid constraint issues)
            $table->unsignedBigInteger('member_id')->nullable()->change();
            
            // Add applicant_id column with foreign key
            $table->unsignedBigInteger('applicant_id')->nullable()->after('member_id');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_activity_logs', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['applicant_id']);
            
            // Remove the column
            $table->dropColumn('applicant_id');
            
            // Change member_id back to not nullable if needed
            $table->unsignedBigInteger('member_id')->nullable(false)->change();
        });
    }
};
