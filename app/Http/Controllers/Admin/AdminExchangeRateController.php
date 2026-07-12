<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class AdminExchangeRateController extends Controller
{
    public function index()
    {
        $rates = ExchangeRate::all();

        return view(
            'admin.exchange-rates',
            compact('rates')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'currency'  => 'required',
            'buy_rate'  => 'required|numeric|min:0',
            'sell_rate' => 'required|numeric|min:0',
        ]);

        ExchangeRate::updateOrCreate(
            [
                'currency' => $request->currency
            ],
            [
                'buy_rate'  => $request->buy_rate,
                'sell_rate' => $request->sell_rate,
            ]
        );

        return back()->with(
            'success',
            'Exchange rate saved successfully.'
        );
    }
}