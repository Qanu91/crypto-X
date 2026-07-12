<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'Deposit',
            'currency' => 'USDT',
            'amount' => 5000,
            'status' => 'Completed',
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'Swap',
            'currency' => 'TRX',
            'amount' => 25000,
            'status' => 'Completed',
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'Withdrawal',
            'currency' => 'PKR',
            'amount' => 100000,
            'status' => 'Pending',
        ]);
    }
}