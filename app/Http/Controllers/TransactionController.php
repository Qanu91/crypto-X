<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()
            ->transactions()
            ->latest()
            ->get();

        return view(
            'transactions',
            compact('transactions')
        );
    }
}