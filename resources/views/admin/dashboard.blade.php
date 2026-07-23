@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="row g-4 mb-4">

    <div class="col-12">
        <h4 class="fw-bold mb-0">Admin Dashboard</h4>
        <p class="text-muted" style="font-size:13px">Platform overview</p>
    </div>

    <div class="col-md-3">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon blue"><i class="ti ti-users"></i></div>
                <div>
                    <div class="stats-label">Total Users</div>
                    <div class="stats-value">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon green"><i class="ti ti-download"></i></div>
                <div>
                    <div class="stats-label">Total Deposits</div>
                    <div class="stats-value">{{ $totalDeposits }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon yellow"><i class="ti ti-upload"></i></div>
                <div>
                    <div class="stats-label">Total Withdrawals</div>
                    <div class="stats-value">{{ $totalWithdrawals }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon red"><i class="ti ti-repeat"></i></div>
                <div>
                    <div class="stats-label">Total Transactions</div>
                    <div class="stats-value">{{ $totalTransactions }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-md-4">
        <a href="{{ route('admin.deposits') }}" class="text-decoration-none">
            <div class="card p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stats-icon green"><i class="ti ti-download"></i></div>
                    <div>
                        <div class="fw-semibold">Manage Deposits</div>
                        <div class="text-muted" style="font-size:13px">Approve or reject deposit requests</div>
                    </div>
                    <i class="ti ti-chevron-right ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.withdrawals') }}" class="text-decoration-none">
            <div class="card p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stats-icon yellow"><i class="ti ti-upload"></i></div>
                    <div>
                        <div class="fw-semibold">Manage Withdrawals</div>
                        <div class="text-muted" style="font-size:13px">Approve or reject withdrawal requests</div>
                    </div>
                    <i class="ti ti-chevron-right ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.buy-orders') }}" class="text-decoration-none">
            <div class="card p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stats-icon blue"><i class="ti ti-shopping-cart"></i></div>
                    <div>
                        <div class="fw-semibold">Buy Orders</div>
                        <div class="text-muted" style="font-size:13px">Review and approve buy orders</div>
                    </div>
                    <i class="ti ti-chevron-right ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.sell-orders') }}" class="text-decoration-none">
            <div class="card p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stats-icon red"><i class="ti ti-tag"></i></div>
                    <div>
                        <div class="fw-semibold">Sell Orders</div>
                        <div class="text-muted" style="font-size:13px">Review and approve sell orders</div>
                    </div>
                    <i class="ti ti-chevron-right ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.exchange-rates') }}" class="text-decoration-none">
            <div class="card p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stats-icon blue"><i class="ti ti-currency-dollar"></i></div>
                    <div>
                        <div class="fw-semibold">Exchange Rates</div>
                        <div class="text-muted" style="font-size:13px">Set buy and sell rates</div>
                    </div>
                    <i class="ti ti-chevron-right ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

</div>

@endsection
