@extends('layouts.app')
@section('title', 'Withdrawal')
@section('content')

<div class="container">

    <h2>Withdraw Funds</h2>

    <form action="{{ route('withdrawal.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Currency</label>

            <select name="currency" id="currency-select" class="form-control">
                <option value="TRX">TRX</option>
                <option value="USDT">USDT</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Amount</label>

            <input
                type="number"
                name="amount"
                class="form-control"
                required>
        </div>

        <div id="crypto-fields">

            <div class="mb-3">

                <label>Wallet Address</label>

                <input
                    type="text"
                    name="wallet_address"
                    class="form-control">

            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            Request Withdrawal
        </button>

    </form>

    <hr>

    <h4>Withdrawal History</h4>

    <table class="table">

        <thead>
            <tr>
                <th>Currency</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

        @forelse($withdrawals as $withdrawal)

            <tr>
                <td>{{ $withdrawal->currency }}</td>
                <td>{{ number_format($withdrawal->amount, 2) }}</td>
                <td>{{ $withdrawal->status }}</td>
            </tr>

        @empty

            <tr>
                <td colspan="3">
                    No withdrawals found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection
