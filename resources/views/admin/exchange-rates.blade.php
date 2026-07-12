@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Exchange Rates</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.exchange-rates.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label class="form-label">Currency</label>

            <select
                name="currency"
                class="form-control"
                required>

                <option value="">Select Currency</option>
                <option value="USDT">USDT</option>
                <option value="TRX">TRX</option>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Buy Rate (PKR)</label>

            <input
                type="number"
                step="0.00000001"
                name="buy_rate"
                class="form-control"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Sell Rate (PKR)</label>

            <input
                type="number"
                step="0.00000001"
                name="sell_rate"
                class="form-control"
                required>
        </div>

        <button class="btn btn-primary">
            Save Rate
        </button>

    </form>

    <hr>

    <h4>Current Rates</h4>

    <table class="table">

        <thead>

            <tr>

                <th>Currency</th>
                <th>Buy Rate</th>
                <th>Sell Rate</th>

            </tr>

        </thead>

        <tbody>

        @foreach($rates as $rate)

            <tr>

                <td>{{ $rate->currency }}</td>

                <td>{{ $rate->buy_rate }}</td>

                <td>{{ $rate->sell_rate }}</td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection