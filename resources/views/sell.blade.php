@extends('layouts.app')
@section('title', 'Sell Crypto')
@section('content')

<div class="container">

    <h2>Sell Crypto</h2>

    <form action="{{ route('sell.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Currency</label>

            <select
                name="currency"
                class="form-control">

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

        <div class="mb-3">
            <label>Payment Method</label>

            <select
                name="payment_method"
                class="form-control">

                <option value="Easypaisa">Easypaisa</option>
                <option value="JazzCash">JazzCash</option>
                <option value="Bank Transfer">Bank Transfer</option>

            </select>
        </div>

        <div class="mb-3">
            <label>Account Title</label>

            <input
                type="text"
                name="account_title"
                class="form-control"
                required>
        </div>

        <div class="mb-3">
            <label>Account Number</label>

            <input
                type="text"
                name="account_number"
                class="form-control"
                required>
        </div>

        <button
            type="submit"
            class="btn btn-primary">

            Submit Sell Request

        </button>

    </form>

    <hr>

    <h4>Sell Request History</h4>

    <table class="table">

        <thead>
            <tr>
                <th>Currency</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

        @forelse($sellOrders as $order)

            <tr>

                <td>{{ $order->currency }}</td>
                <td>{{ $order->amount }}</td>
                <td>{{ $order->status }}</td>

            </tr>

        @empty

            <tr>
                <td colspan="3">
                    No sell requests found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection