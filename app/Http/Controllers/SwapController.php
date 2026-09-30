<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\ExchangeRate;

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

        $fromRate = ExchangeRate::where('currency', $request->from_currency)->first();
        $toRate   = ExchangeRate::where('currency', $request->to_currency)->first();

        if (!$fromRate) {
            return back()->with('error', 'From currency rate not found.');
        }

        if (!$toRate) {
            return back()->with('error', 'To currency rate not found.');
        }

        // Convert via PKR as intermediate: from -> PKR -> to
        $pkrAmount       = $request->amount * $fromRate->sell_rate;
        $convertedAmount = $pkrAmount / $toRate->buy_rate;

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

        return back()->with('success', 'Swap completed successfully.');
    }
}
