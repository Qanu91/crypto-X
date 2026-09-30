<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $portfolioWallets = auth()->user()->wallets->where('currency', '!=', 'PKR');

        $wallets = Auth::user()->wallets->where('currency', '!=', 'PKR');
        $usdtWallet = $wallets->where('currency', 'USDT')->first();
$trxWallet = $wallets->where('currency', 'TRX')->first();

$transactions = auth()->user()
    ->transactions()
    ->latest()
    ->take(5)
    ->get();
$response = Http::get(
    'https://api.coingecko.com/api/v3/simple/price',
    [
        'ids' => 'tether,tron',
        'vs_currencies' => 'usd',
    ]
);

$exchangeResponse = Http::get(
    'https://open.er-api.com/v6/latest/USD'
);

$exchangeData = $exchangeResponse->json();

$usdToPkr = $exchangeData['rates']['PKR'] ?? 280;

$prices = $response->json();

$usdtPrice = $prices['tether']['usd'] ?? 1;
$trxPrice = $prices['tron']['usd'] ?? 0.30;$usdtPricePkr = $usdtPrice * $usdToPkr;
$trxPricePkr = $trxPrice * $usdToPkr;

$swapRates = [

    'USDT' => [
        'TRX' => $usdtPrice / $trxPrice,
    ],

    'TRX' => [
        'USDT' => $trxPrice / $usdtPrice,
    ],

];

return view('dashboard', compact(
    'wallets',
    'usdtWallet',
    'trxWallet',
    'transactions',
    'portfolioWallets',
    'usdtPrice',
    'trxPrice',
    'usdToPkr',
    'swapRates',
    'usdtPricePkr',
    'trxPricePkr',
));
    }
}