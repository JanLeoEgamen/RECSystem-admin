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
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('student_number')->nullable()->after('is_student');
            $table->string('school')->nullable()->after('student_number');
            $table->string('program')->nullable()->after('school');
            $table->string('year_level')->nullable()->after('program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn(['student_number', 'school', 'program', 'year_level']);
        });
    }
};