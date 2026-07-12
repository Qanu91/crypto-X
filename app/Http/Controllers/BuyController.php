<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyOrder;
use App\Models\PaymentAccount;

class BuyController extends Controller
{
    public function index()
{
    $buyOrders = auth()->user()
        ->buyOrders()
        ->latest()
        ->get();

    $paymentAccounts = PaymentAccount::all();

    return view(
        'buy',
        compact(
            'buyOrders',
            'paymentAccounts'
        )
    );
}

    public function store(Request $request)
    {
        $request->validate([
            'currency' => 'required',
            'amount' => 'required|numeric|min:1'
        ]);

        BuyOrder::create([
            'user_id' => auth()->id(),
            'currency' => $request->currency,
            'amount' => $request->amount,
            'status' => 'Pending'
        ]);

        return back()->with(
            'success',
            'Buy request submitted successfully.'
        );
    }
}