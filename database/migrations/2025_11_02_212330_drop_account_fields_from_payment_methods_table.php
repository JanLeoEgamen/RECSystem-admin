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
        Schema::table('payment_methods', function (Blueprint $table) {
            // Drop columns one by one to avoid issues
            if (Schema::hasColumn('payment_methods', 'account_name')) {
                $table->dropColumn('account_name');
            }
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            if (Schema::hasColumn('payment_methods', 'account_number')) {
                $table->dropColumn('account_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('account_name')->nullable()->after('category');
            $table->string('account_number')->nullable()->after('account_name');
        });
    }
};