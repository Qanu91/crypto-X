<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $totalUsers = User::count();

        $totalDeposits = Deposit::count();

        $totalWithdrawals = Withdrawal::count();

        $totalTransactions = Transaction::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDeposits',
            'totalWithdrawals',
            'totalTransactions'
        ));
    }
}