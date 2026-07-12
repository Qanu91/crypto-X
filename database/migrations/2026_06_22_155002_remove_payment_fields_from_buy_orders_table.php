<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buy_orders', function (Blueprint $table) {

            $table->dropColumn([
                'payment_method',
                'account_title',
                'account_number'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('buy_orders', function (Blueprint $table) {

            $table->string('payment_method');
            $table->string('account_title');
            $table->string('account_number');

        });
    }
};