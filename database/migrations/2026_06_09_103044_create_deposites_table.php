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
    Schema::create('deposits', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        $table->string('currency'); // TRX, USDT, PKR

        $table->decimal('amount', 20, 8)
              ->nullable();

        $table->string('wallet_address')
              ->nullable();

        $table->string('txid')
              ->nullable();

        $table->enum('status', [
            'Pending',
            'Confirmed',
            'Failed'
        ])->default('Pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposites');
    }
};
