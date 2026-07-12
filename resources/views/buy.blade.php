@extends('layouts.app')
@section('title', 'Buy Crypto')
@section('content')

<div class="container">

    <h2>Buy Crypto</h2>

    
    <form action="{{ route('buy.store') }}" method="POST">

        @csrf
        <div class="card mb-4">

    <div class="card-body">

        <h4>Payment Details</h4>

        @foreach($paymentAccounts as $account)

            <div class="mb-3">

                <strong>{{ $account->method }}</strong>

                <br>

                Title:
                {{ $account->account_title }}

                <br>

                Number:
                {{ $account->account_number }}

                @if($account->bank_name)

                    <br>

                    Bank:
                    {{ $account->bank_name }}

                @endif

            </div>

            <hr>

        @endforeach

    </div>

</div>

        <div class="mb-3">

            <label>Currency</label>

            <select
                name="currency"
                class="form-control">

                <option value="TRX">
                    TRX
                </option>

                <option value="USDT">
                    USDT
                </option>

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

           
        <button
            type="submit"
            class="btn btn-primary">

            Submit Buy Request

        </button>

    </form>

    <hr>

    <h4>Buy Request History</h4>

    <table class="table">

        <thead>

            <tr>

                <th>Currency</th>
                <th>Amount</th>
                <th>Status</th>

            </tr>

        </thead>

        <tbody>

        @forelse($buyOrders as $order)

            <tr>

                <td>{{ $order->currency }}</td>

                <td>{{ $order->amount }}</td>

                <td>{{ $order->status }}</td>

            </tr>

        @empty

            <tr>

                <td colspan="3">
                    No buy requests found.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection