<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Auth::user()->wallets;

        $usdtWallet = $wallets->where('currency', 'USDT')->first();
        $trxWallet = $wallets->where('currency', 'TRX')->first();
        $pkrWallet = $wallets->where('currency', 'PKR')->first();

        return view('wallet', compact(
            'wallets',
            'usdtWallet',
            'trxWallet',
            'pkrWallet'
        ));
    }
}