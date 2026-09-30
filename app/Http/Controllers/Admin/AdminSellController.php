<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellOrder;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminSellController extends Controller
{
    public function index()
    {
        $sellOrders = SellOrder::latest()->get();

        return view(
            'admin.sell-orders',
            compact('sellOrders')
        );
    }

   public function approve(SellOrder $sellOrder)
{
    DB::transaction(function () use ($sellOrder) {

        if ($sellOrder->status != 'Pending') {
            return;
        }

        $cryptoWallet = Wallet::where('user_id', $sellOrder->user_id)
            ->where('currency', $sellOrder->currency)
            ->first();

        if (!$cryptoWallet) {
            abort(404, 'Wallet not found.');
        }

        if ($cryptoWallet->balance < $sellOrder->amount) {
            abort(400, 'Insufficient balance.');
        }

        $cryptoWallet->balance -= $sellOrder->amount;
        $cryptoWallet->save();

        $sellOrder->status = 'Approved';
        $sellOrder->save();

        Transaction::create([
            'user_id' => $sellOrder->user_id,
            'type' => 'Sell',
            'currency' => $sellOrder->currency,
            'amount' => $sellOrder->amount,
            'status' => 'Completed'
        ]);

    });

    return back()->with(
        'success',
        'Sell order approved successfully.'
    );
}

public function reject(SellOrder $sellOrder)
{
    if ($sellOrder->status == 'Pending') {

        $sellOrder->status = 'Rejected';

        $sellOrder->save();
    }

    return back()->with(
        'success',
        'Sell order rejected successfully.'
    );
}
}