@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Manage Sell Orders</h2>

    <table class="table">

        <thead>

            <tr>

                <th>User ID</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Account Title</th>
                <th>Account Number</th>
                <th>Status</th>
                <th>Action</th>

            </tr>

        </thead>

        <tbody>

        @foreach($sellOrders as $sellOrder)

            <tr>

                <td>{{ $sellOrder->user_id }}</td>

                <td>{{ $sellOrder->currency }}</td>

                <td>{{ $sellOrder->amount }}</td>

                <td>{{ $sellOrder->payment_method }}</td>

                <td>{{ $sellOrder->account_title }}</td>

                <td>{{ $sellOrder->account_number }}</td>

                <td>{{ $sellOrder->status }}</td>

               <td>

    @if($sellOrder->status == 'Pending')

        <form
            action="{{ route('admin.sell-orders.approve', $sellOrder) }}"
            method="POST"
            class="d-inline">

            @csrf

            <button class="btn btn-success">
                Approve
            </button>

        </form>

        <form
            action="{{ route('admin.sell-orders.reject', $sellOrder) }}"
            method="POST"
            class="d-inline">

            @csrf

            <button class="btn btn-danger">
                Reject
            </button>

        </form>

    @endif

</td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection