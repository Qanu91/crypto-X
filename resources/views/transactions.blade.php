@extends('layouts.app')
@section('title', 'Transactions')
@section('content')

<div class="container">

    <h2>Transaction History</h2>
<div class="table-responsive">
    <table class="table mb-0">

        <thead>
            <tr>
                <th>Type</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>

        @forelse($transactions as $transaction)

            <tr>

                <td>{{ $transaction->type }}</td>

                <td>{{ $transaction->currency }}</td>

                <td>{{ $transaction->amount }}</td>

                <td>{{ $transaction->status }}</td>

                <td>
                    {{ $transaction->created_at->format('d M Y') }}
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5">
                    No transactions found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>
</div>

</div>

@endsection