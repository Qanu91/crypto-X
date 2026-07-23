<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SwapController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\AdminBuyController;
use App\Http\Controllers\Admin\AdminSellController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\Admin\AdminExchangeRateController;

// ---------------------------------------------------------------
// Root — redirect based on auth state
// ---------------------------------------------------------------
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('register');
});

// ---------------------------------------------------------------
// User routes
// ---------------------------------------------------------------
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/swap', [SwapController::class, 'store'])->name('swap.store');

    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit.index');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');

    Route::get('/withdrawal', [WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::post('/withdrawal', [WithdrawalController::class, 'store'])->name('withdrawal.store');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    Route::get('/buy', [BuyController::class, 'index'])->name('buy.index');
    Route::post('/buy', [BuyController::class, 'store'])->name('buy.store');

    Route::get('/sell', [SellController::class, 'index'])->name('sell.index');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');

});

// ---------------------------------------------------------------
// Admin routes — all protected by auth + admin middleware
// ---------------------------------------------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Deposits
    Route::get('/deposits', [AdminDepositController::class, 'index'])->name('admin.deposits');
    Route::post('/deposits/{deposit}/approve', [AdminDepositController::class, 'approve'])->name('admin.deposits.approve');
    Route::post('/deposits/{deposit}/reject', [AdminDepositController::class, 'reject'])->name('admin.deposits.reject');

    // Withdrawals
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('admin.withdrawals');
    Route::post('/withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [AdminWithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');

    // Buy orders
    Route::get('/buy-orders', [AdminBuyController::class, 'index'])->name('admin.buy-orders');
    Route::post('/buy-orders/{buyOrder}/approve', [AdminBuyController::class, 'approve'])->name('admin.buy-orders.approve');
    Route::post('/buy-orders/{buyOrder}/reject', [AdminBuyController::class, 'reject'])->name('admin.buy-orders.reject');

    // Sell orders
    Route::get('/sell-orders', [AdminSellController::class, 'index'])->name('admin.sell-orders');
    Route::post('/sell-orders/{sellOrder}/approve', [AdminSellController::class, 'approve'])->name('admin.sell-orders.approve');
    Route::post('/sell-orders/{sellOrder}/reject', [AdminSellController::class, 'reject'])->name('admin.sell-orders.reject');

    // Exchange rates
    Route::get('/exchange-rates', [AdminExchangeRateController::class, 'index'])->name('admin.exchange-rates');
    Route::post('/exchange-rates', [AdminExchangeRateController::class, 'store'])->name('admin.exchange-rates.store');

});

require __DIR__.'/auth.php';
