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
                <option value="PKR">PKR</option>
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

<div id="pkr-fields" style="display:none;">

    <div class="mb-3">

        <label>Withdrawal Method</label>

        <select
            name="withdrawal_method"
            class="form-control">

            <option value="Easypaisa">
                Easypaisa
            </option>

            <option value="JazzCash">
                JazzCash
            </option>

            <option value="Bank Transfer">
                Bank Transfer
            </option>

        </select>

    </div>

    <div class="mb-3">

        <label>Account Title</label>

        <input
            type="text"
            name="account_title"
            class="form-control">

    </div>

    <div class="mb-3">

        <label>Account Number</label>

        <input
            type="text"
             name="account_number"
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
<script>

const currencySelect =
    document.getElementById('currency-select');

const cryptoFields =
    document.getElementById('crypto-fields');

const pkrFields =
    document.getElementById('pkr-fields');

currencySelect.addEventListener('change', function () {

    if (this.value === 'PKR') {

        cryptoFields.style.display = 'none';

        pkrFields.style.display = 'block';

    } else {

        cryptoFields.style.display = 'block';

        pkrFields.style.display = 'none';

    }

});

</script>
@endsection
