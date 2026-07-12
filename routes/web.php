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
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\Admin\AdminExchangeRateController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/swap', [SwapController::class, 'store'])
    ->middleware('auth')
    ->name('swap.store');

    Route::get('/deposit', [DepositController::class, 'index'])
    ->middleware('auth')
    ->name('deposit.index');

    Route::post('/deposit', [DepositController::class, 'store'])
    ->middleware('auth')
    ->name('deposit.store');

    Route::get('/withdrawal', [WithdrawalController::class, 'index'])
    ->middleware('auth')
    ->name('withdrawal.index');

    Route::post('/withdrawal', [WithdrawalController::class, 'store'])
    ->middleware('auth')
    ->name('withdrawal.store');

    Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

    Route::get('/admin/deposits', [AdminDepositController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.deposits');

Route::post('/admin/deposits/{deposit}/approve', [AdminDepositController::class, 'approve'])
    ->middleware(['auth', 'admin'])
    ->name('admin.deposits.approve');

    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])
        ->name('admin.withdrawals');

    Route::post('/withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])
        ->name('admin.withdrawals.approve');
});

Route::post(
    '/admin/deposits/{deposit}/reject',
    [AdminDepositController::class, 'reject']
)->name('admin.deposits.reject');

Route::post(
    '/withdrawals/{withdrawal}/reject',
    [AdminWithdrawalController::class, 'reject']
)->name('admin.withdrawals.reject');

Route::get('/transactions', [TransactionController::class, 'index'])
    ->middleware('auth')
    ->name('transactions.index');

    Route::get('/buy', [BuyController::class, 'index'])
    ->middleware('auth')
    ->name('buy.index');

Route::post('/buy', [BuyController::class, 'store'])
    ->middleware('auth')
    ->name('buy.store');

    Route::get(
    '/admin/buy-orders',
    [AdminBuyController::class, 'index']
)->name('admin.buy-orders');

Route::post(
    '/admin/buy-orders/{buyOrder}/approve',
    [AdminBuyController::class, 'approve']
)->name('admin.buy-orders.approve');

Route::post(
    '/admin/buy-orders/{buyOrder}/reject',
    [AdminBuyController::class, 'reject']
)->name('admin.buy-orders.reject');

Route::get('/sell', [SellController::class, 'index'])
    ->middleware('auth')
    ->name('sell.index');

Route::post('/sell', [SellController::class, 'store'])
    ->middleware('auth')
    ->name('sell.store');

    Route::get('/wallet', [WalletController::class, 'index'])
    ->name('wallet.index');

    Route::get('/admin/sell-orders', [AdminSellController::class, 'index'])
    ->name('admin.sell-orders');

    Route::post('/admin/sell-orders/{sellOrder}/approve', [AdminSellController::class, 'approve'])
    ->name('admin.sell-orders.approve');

Route::post('/admin/sell-orders/{sellOrder}/reject', [AdminSellController::class, 'reject'])
    ->name('admin.sell-orders.reject');
    
Route::get('/admin/exchange-rates', [AdminExchangeRateController::class, 'index'])
    ->name('admin.exchange-rates');

Route::post('/admin/exchange-rates', [AdminExchangeRateController::class, 'store'])
    ->name('admin.exchange-rates.store');
require __DIR__.'/auth.php';
