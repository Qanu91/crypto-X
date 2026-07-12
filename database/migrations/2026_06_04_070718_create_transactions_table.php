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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        $table->string('type'); // Deposit, Withdraw, Swap

        $table->string('currency');

        $table->decimal('amount', 20, 8);

        $table->string('status')
              ->default('completed');

        $table->timestamps();
    });
}
};
