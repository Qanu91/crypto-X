@extends('layouts.admin')

@section('title', 'Sell Orders')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3 px-4">
        <h4>Sell Orders</h4>
        <span class="badge bg-primary">{{ $sellOrders->count() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
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
                @forelse($sellOrders as $sellOrder)
                    <tr>
                        <td>{{ $sellOrder->user_id }}</td>
                        <td>{{ $sellOrder->currency }}</td>
                        <td>{{ $sellOrder->amount }}</td>
                        <td>{{ $sellOrder->payment_method }}</td>
                        <td>{{ $sellOrder->account_title }}</td>
                        <td>{{ $sellOrder->account_number }}</td>
                        <td>
                            @if($sellOrder->status === 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($sellOrder->status === 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($sellOrder->status === 'Pending')
                                <form action="{{ route('admin.sell-orders.approve', $sellOrder) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.sell-orders.reject', $sellOrder) }}" method="POST" class="d-inline">
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
                        <td colspan="8" class="text-center text-muted py-4">No sell orders found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
