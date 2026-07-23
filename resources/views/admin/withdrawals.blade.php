@extends('layouts.admin')

@section('title', 'Manage Withdrawals')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3 px-4">
        <h4>Manage Withdrawals</h4>
        <span class="badge bg-primary">{{ $withdrawals->count() }} total</span>
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
                        <th>Account Title</th>
                        <th>Wallet Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td>{{ $withdrawal->user_id }}</td>
                        <td>{{ $withdrawal->currency }}</td>
                        <td>{{ $withdrawal->amount }}</td>
                        <td>{{ $withdrawal->withdrawal_method }}</td>
                        <td>{{ $withdrawal->account_title }}</td>
                        <td>{{ $withdrawal->wallet_address }}</td>
                        <td>
                            @if($withdrawal->status === 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($withdrawal->status === 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($withdrawal->status === 'Pending')
                                <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST" class="d-inline">
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
                        <td colspan="8" class="text-center text-muted py-4">No withdrawals found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
