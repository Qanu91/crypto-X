@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Manage Buy Orders</h2>

    <table class="table">

        <thead>

            <tr>

                <th>User ID</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Action</th>

            </tr>

        </thead>

        <tbody>

        @foreach($buyOrders as $order)

            <tr>

                <td>{{ $order->user_id }}</td>

                <td>{{ $order->currency }}</td>

                <td>{{ $order->amount }}</td>

                <td>{{ $order->payment_method }}</td>

                <td>{{ $order->status }}</td>

                <td>

                    @if($order->status == 'Pending')

                        <form
                            action="{{ route('admin.buy-orders.approve', $order) }}"
                            method="POST"
                            class="d-inline">

                            @csrf

                            <button class="btn btn-success">
                                Approve
                            </button>

                        </form>

                        <form
                            action="{{ route('admin.buy-orders.reject', $order) }}"
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