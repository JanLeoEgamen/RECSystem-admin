<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('mode_of_payment_qr_image');
        });
    }

    public function down()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }
};