<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellOrder;

class SellController extends Controller
{
    public function index()
    {
        $sellOrders = auth()->user()
            ->sellOrders()
            ->latest()
            ->get();

        return view(
            'sell',
            compact('sellOrders')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'currency' => 'required',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required',
            'account_title' => 'required',
            'account_number' => 'required'
        ]);

        $wallet = auth()->user()
            ->wallets()
            ->where('currency', $request->currency)
            ->first();

        if (!$wallet) {
            return back()->with(
                'error',
                'Wallet not found.'
            );
        }

        if ($wallet->balance < $request->amount) {
            return back()->with(
                'error',
                'Insufficient balance.'
            );
        }

        SellOrder::create([
            'user_id' => auth()->id(),
            'currency' => $request->currency,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'account_title' => $request->account_title,
            'account_number' => $request->account_number,
            'status' => 'Pending'
        ]);

        return back()->with(
            'success',
            'Sell request submitted.'
        );
    }
}