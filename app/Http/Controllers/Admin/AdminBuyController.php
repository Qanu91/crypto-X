<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyOrder;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminBuyController extends Controller
{
    public function index()
    {
        $buyOrders = BuyOrder::latest()->get();

        return view(
            'admin.buy-orders',
            compact('buyOrders')
        );
    }

    public function approve(BuyOrder $buyOrder)
{
    DB::transaction(function () use ($buyOrder) {

        if ($buyOrder->status !== 'Pending') {
            return;
        }

        $wallet = Wallet::where('user_id', $buyOrder->user_id)
            ->where('currency', $buyOrder->currency)
            ->first();

        if (!$wallet) {
            abort(404, 'Wallet not found.');
        }

        $wallet->balance += $buyOrder->amount;
        $wallet->save();

        $buyOrder->status = 'Approved';
        $buyOrder->save();

        Transaction::create([
            'user_id' => $buyOrder->user_id,
            'type' => 'Buy',
            'currency' => $buyOrder->currency,
            'amount' => $buyOrder->amount,
            'status' => 'Completed'
        ]);
    });

    return back()->with(
        'success',
        'Buy order approved successfully.'
    );
}

    public function reject(BuyOrder $buyOrder)
    {
        $buyOrder->status = 'Rejected';

        $buyOrder->save();

        return back()->with(
            'success',
            'Buy order rejected.'
        );
    }
}