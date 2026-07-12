<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Wallet;
use App\Models\Transaction;

class AdminWithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::latest()->get();

        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'Pending') {
            return back()->with('error', 'Already processed.');
        }

        $wallet = Wallet::where('user_id', $withdrawal->user_id)
            ->where('currency', $withdrawal->currency)
            ->first();

        if (!$wallet) {
            return back()->with('error', 'Wallet not found.');
        }

        if ($wallet->balance < $withdrawal->amount) {
            return back()->with('error', 'Insufficient wallet balance.');
        }

        $wallet->balance -= $withdrawal->amount;
        $wallet->save();

        $withdrawal->status = 'Approved';
        $withdrawal->save();

        Transaction::create([
            'user_id' => $withdrawal->user_id,
            'type' => 'Withdrawal',
            'currency' => $withdrawal->currency,
            'amount' => $withdrawal->amount,
            'status' => 'Completed'
        ]);

        return back()->with('success', 'Withdrawal approved.');
    }

    public function reject(Withdrawal $withdrawal)
{
    if ($withdrawal->status !== 'Pending') {
        return back()->with('error', 'Already processed.');
    }

    $withdrawal->status = 'Rejected';

    $withdrawal->save();

    return back()->with(
        'success',
        'Withdrawal rejected.'
    );
}
}