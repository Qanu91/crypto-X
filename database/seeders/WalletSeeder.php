<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {

            Wallet::create([
    'user_id' => $user->id,
    'currency' => 'USDT',
    'balance' => 842300,
]);

 Wallet::create([
    'user_id' => $user->id,
    'currency' => 'TRX',
    'balance' => 842300,
]);

Wallet::create([
    'user_id' => $user->id,
    'currency' => 'PKR',
    'balance' => 3464000,
]);
        }
    }
}