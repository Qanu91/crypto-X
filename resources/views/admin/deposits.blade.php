@extends('layouts.admin')

@section('title', 'Manage Deposits')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3 px-4">
        <h4>Manage Deposits</h4>
        <span class="badge bg-primary">{{ $deposits->count() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($deposits as $deposit)
                    <tr>
                        <td>{{ $deposit->user_id }}</td>
                        <td>{{ $deposit->currency }}</td>
                        <td>{{ $deposit->amount }}</td>
                        <td>
                            @if($deposit->status === 'Confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($deposit->status === 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($deposit->status === 'Pending')
                                <form action="{{ route('admin.deposits.approve', $deposit) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.deposits.reject', $deposit) }}" method="POST" class="d-inline">
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
                        <td colspan="5" class="text-center text-muted py-4">No deposits found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
