@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Manage Withdrawals</h2>

    <table class="table">

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

        @foreach($withdrawals as $withdrawal)

            <tr>

                <td>{{ $withdrawal->user_id }}</td>

                <td>{{ $withdrawal->currency }}</td>

                <td>{{ $withdrawal->amount }}</td>

<td>{{ $withdrawal->withdrawal_method }}</td>

<td>{{ $withdrawal->account_title }}</td>

<td>{{ $withdrawal->wallet_address }}</td>

<td>{{ $withdrawal->status }}</td>

               <td>

    @if($withdrawal->status == 'Pending')

        <form
            action="{{ route('admin.withdrawals.approve', $withdrawal) }}"
            method="POST"
            class="d-inline">

            @csrf

            <button class="btn btn-success">
                Approve
            </button>

        </form>

        <form
            action="{{ route('admin.withdrawals.reject', $withdrawal) }}"
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