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
            $table->decimal('refund_amount', 10, 2)->nullable()->after('gcash_number');
            $table->string('refund_receipt_path')->nullable()->after('refund_amount');
            $table->text('refund_remarks')->nullable()->after('refund_receipt_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn(['refund_amount', 'refund_receipt_path', 'refund_remarks']);
        });
    }
};
