<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\DepositAddress;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = auth()->user()
        ->deposits()
        ->latest()
        ->get();

    $depositAddresses = DepositAddress::all();

    return view('deposit', compact(
        'deposits',
        'depositAddresses'
    ));
    }
    public function store(Request $request)
{
    $request->validate([
        'currency' => 'required',
        'amount' => 'required|numeric|min:1',
    
    ]);

    $depositAddress = DepositAddress::where(
    'currency',
    $request->currency
)->first();

    Deposit::create([
    'user_id' => auth()->id(),
    'currency' => $request->currency,
    'amount' => $request->amount,
    'wallet_address' => $depositAddress?->address,
    'status' => 'Pending'
]);
    return back()->with('success', 'Deposit request created.');
}
}