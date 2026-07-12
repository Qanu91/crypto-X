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
    Schema::table('withdrawals', function (Blueprint $table) {

        $table->string('withdrawal_method')
              ->nullable()
              ->after('wallet_address');

        $table->string('account_title')
              ->nullable()
              ->after('withdrawal_method');

    });
}

public function down(): void
{
    Schema::table('withdrawals', function (Blueprint $table) {

        $table->dropColumn([
            'withdrawal_method',
            'account_title'
        ]);

    });
}
};
