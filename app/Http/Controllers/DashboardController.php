<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $portfolioWallets = auth()->user()->wallets;

        $wallets = Auth::user()->wallets;
        $usdtWallet = $wallets->where('currency', 'USDT')->first();
$trxWallet = $wallets->where('currency', 'TRX')->first();
$pkrWallet = $wallets->where('currency', 'PKR')->first();

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
$trxPrice  = $prices['tron']['usd'] ?? 0;
$usdtPricePkr = $usdtPrice * $usdToPkr;
$trxPricePkr = $trxPrice * $usdToPkr;

$swapRates = [

    'USDT' => [
        'TRX' => $usdtPrice / $trxPrice,
        'PKR' => $usdToPkr,
    ],

    'TRX' => [
        'USDT' => $trxPrice / $usdtPrice,
        'PKR' => $trxPrice * $usdToPkr,
    ],

    'PKR' => [
        'USDT' => 1 / $usdToPkr,
        'TRX' => (1 / $usdToPkr) / $trxPrice,
    ],

];

return view('dashboard', compact(
    'wallets',
    'usdtWallet',
    'trxWallet',
    'pkrWallet',
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