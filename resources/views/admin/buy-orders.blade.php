@extends('layouts.admin')

@section('title', 'Buy Orders')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3 px-4">
        <h4>Buy Orders</h4>
        <span class="badge bg-primary">{{ $buyOrders->count() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
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
                @forelse($buyOrders as $order)
                    <tr>
                        <td>{{ $order->user_id }}</td>
                        <td>{{ $order->currency }}</td>
                        <td>{{ $order->amount }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            @if($order->status === 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($order->status === 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($order->status === 'Pending')
                                <form action="{{ route('admin.buy-orders.approve', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.buy-orders.reject', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No buy orders found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
