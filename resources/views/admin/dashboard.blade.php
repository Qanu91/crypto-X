@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Users</h6>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Deposits</h6>
                    <h3>{{ $totalDeposits }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Withdrawals</h6>
                    <h3>{{ $totalWithdrawals }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Transactions</h6>
                    <h3>{{ $totalTransactions }}</h3>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection