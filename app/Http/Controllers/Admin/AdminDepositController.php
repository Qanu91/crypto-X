<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Wallet;
use App\Models\Transaction;

class AdminDepositController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $deposits = Deposit::latest()->get();

        return view('admin.deposits', compact('deposits'));
    }

    public function approve(Deposit $deposit)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($deposit->status === 'Confirmed') {
            return back();
        }

        $wallet = Wallet::where('user_id', $deposit->user_id)
            ->where('currency', $deposit->currency)
            ->first();

        if ($wallet) {
            $wallet->balance += $deposit->amount;
            $wallet->save();
        }

        $deposit->status = 'Confirmed';
        $deposit->save();

        Transaction::create([
            'user_id' => $deposit->user_id,
            'type' => 'Deposit',
            'currency' => $deposit->currency,
            'amount' => $deposit->amount,
            'status' => 'Completed'
        ]);

        return back()->with('success', 'Deposit approved.');
    }

    public function reject(Deposit $deposit)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $deposit->status = 'Rejected';
    $deposit->save();

    return back()->with('success', 'Deposit rejected.');
}
}