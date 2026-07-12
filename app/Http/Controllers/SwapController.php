<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;

class SwapController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'from_currency' => 'required',
            'to_currency'   => 'required',
            'amount'        => 'required|numeric|min:0.0001',
        ]);

        if ($request->from_currency == $request->to_currency) {
            return back()->with('error', 'Please select different currencies.');
        }

        $user = auth()->user();
        $response = Http::get(
    'https://api.coingecko.com/api/v3/simple/price',
    [
        'ids' => 'tether,tron',
        'vs_currencies' => 'usd',
    ]
);

$prices = $response->json();

$usdtPrice = $prices['tether']['usd'] ?? 1;
$trxPrice = $prices['tron']['usd'] ?? 0;

        $fromWallet = $user->wallets()
            ->where('currency', $request->from_currency)
            ->first();

        $toWallet = $user->wallets()
            ->where('currency', $request->to_currency)
            ->first();

        if (!$fromWallet || !$toWallet) {
            return back()->with('error', 'Wallet not found.');
        }

        if ($fromWallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        $fromRate = null;
        $toRate = null;

        if ($request->from_currency != 'PKR') {
            $fromRate = ExchangeRate::where(
                'currency',
                $request->from_currency
            )->first();
        }

        if ($request->to_currency != 'PKR') {
            $toRate = ExchangeRate::where(
                'currency',
                $request->to_currency
            )->first();
        }

        if ($request->from_currency != 'PKR' && !$fromRate) {
            return back()->with('error', 'From currency rate not found.');
        }

        if ($request->to_currency != 'PKR' && !$toRate) {
            return back()->with('error', 'To currency rate not found.');
        }

        /* Conversion Logic */

        if (
            $request->from_currency == 'PKR' &&
            $request->to_currency != 'PKR'
        ) {

            $convertedAmount =
                $request->amount / $toRate->buy_rate;

        } elseif (

            $request->to_currency == 'PKR' &&
            $request->from_currency != 'PKR'

        ) {

            $convertedAmount =
                $request->amount * $fromRate->sell_rate;

        } else {

            $pkrAmount =
                $request->amount * $fromRate->sell_rate;

            $convertedAmount =
                $pkrAmount / $toRate->buy_rate;
        }

        DB::transaction(function () use (
            $fromWallet,
            $toWallet,
            $request,
            $convertedAmount,
            $user
        ) {

            $fromWallet->balance -= $request->amount;
            $fromWallet->save();

            $toWallet->balance += $convertedAmount;
            $toWallet->save();

            Transaction::create([
                'user_id'  => $user->id,
                'type'     => 'Swap',
                'currency' => $request->to_currency,
                'amount'   => $convertedAmount,
                'status'   => 'Completed',
            ]);
        });

        return back()->with(
            'success',
            'Swap completed successfully.'
        );
    }
}