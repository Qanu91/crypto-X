@extends('layouts.app')
@section('title', 'Deposit')
@section('content')

<div class="container">

    <h2>Deposit Funds</h2>

    <form action="{{ route('deposit.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Currency</label>

        <select name="currency" id="currency-select" class="form-control">
            <option value="TRX">TRX</option>
            <option value="USDT">USDT</option>
            <option value="PKR">PKR</option>
        </select>
    </div>

    <div class="mb-3 id="crypto-address-section">

    <label>Deposit Address</label>

    <div class="input-group">

        <input
            type="text"
            id="deposit-address"
            class="form-control"
            readonly
            value="@foreach($depositAddresses as $address)@if($address->currency == 'TRX'){{ $address->address }}@endif @endforeach">

    <div class="d-flex align-items-center">


    <i
        class="ti ti-copy copy-icon"
        onclick="copyAddress()">
    </i>

</div>
    </div>

</div>
<div class="mb-3" id="pkr-payment-section" style="display: none;">

    <label>Payment Account</label>

    @foreach($paymentAccounts as $account)
        <div class="border rounded p-3 mb-2">

            <strong>{{ $account->method }}</strong>

            @if($account->bank_name)
                <div>Bank: {{ $account->bank_name }}</div>
            @endif

            <div>Account Title: {{ $account->account_title }}</div>

            <div>Account Number: {{ $account->account_number }}</div>

        </div>
    @endforeach

</div>
    <div class="mb-3">
        <label>Amount</label>

        <input
            type="number"
            name="amount"
            class="form-control"
            required>
    </div>

    <button type="submit" class="btn btn-primary">
        Create Deposit
    </button>

</form>
<hr class="my-4">

<h4>Recent Deposits</h4>

<table class="table">

    <thead>
        <tr>
            <th>Currency</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>

        @forelse($deposits as $deposit)

            <tr>

                <td>{{ $deposit->currency }}</td>

                <td>{{ number_format($deposit->amount, 2) }}</td>

                <td>{{ $deposit->status }}</td>

                <td>{{ $deposit->created_at->format('d M Y') }}</td>

            </tr>

        @empty

            <tr>
                <td colspan="4">
                    No deposits found.
                </td>
            </tr>

        @endforelse

    </tbody>

</table>

</div>

<script>
const addresses = {
    @foreach($depositAddresses as $address)
        '{{ $address->currency }}': '{{ $address->address }}',
    @endforeach
};

const currencySelect = document.getElementById('currency-select');
const cryptoSection = document.getElementById('crypto-address-section');
const pkrSection = document.getElementById('pkr-payment-section');
const addressField = document.getElementById('deposit-address');

currencySelect.addEventListener('change', function () {

    if (this.value === 'PKR') {

        cryptoSection.style.display = 'none';
        pkrSection.style.display = 'block';

    } else {

        cryptoSection.style.display = 'block';
        pkrSection.style.display = 'none';

        addressField.value = addresses[this.value] || '';

    }
});

function copyAddress() {

    navigator.clipboard.writeText(addressField.value);

    alert('Address copied successfully!');
}
</script>

@endsection