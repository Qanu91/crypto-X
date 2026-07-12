<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index()
{
    $withdrawals = auth()->user()
        ->withdrawals()
        ->latest()
        ->get();

    return view('withdrawal', compact('withdrawals'));
}

    public function store(Request $request)
{
    
    $request->validate([
        'currency' => 'required',
        'amount' => 'required|numeric|min:1',
        'wallet_address' => 'required'
    ]);

    $wallet = auth()->user()
        ->wallets()
        ->where('currency', $request->currency)
        ->first();

    if (!$wallet) {
        return back()->with('error', 'Wallet not found.');
    }

    if ($wallet->balance < $request->amount) {
        return back()->with('error', 'Insufficient balance.');
    }

   $walletAddress = $request->wallet_address;
$withdrawalMethod = null;
$accountTitle = null;

if ($request->currency === 'PKR') {

    $walletAddress = $request->account_number;

    $withdrawalMethod = $request->withdrawal_method;

    $accountTitle = $request->account_title;
}

Withdrawal::create([
    'user_id' => auth()->id(),
    'currency' => $request->currency,
    'amount' => $request->amount,
    'wallet_address' => $walletAddress,
    'withdrawal_method' => $withdrawalMethod,
    'account_title' => $accountTitle,
    'status' => 'Pending'
]);

    return back()->with(
        'success',
        'Withdrawal request submitted.'
    );
}
}