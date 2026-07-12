@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Manage Deposits</h2>

    <table class="table">

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

        @foreach($deposits as $deposit)

            <tr>

                <td>{{ $deposit->user_id }}</td>

                <td>{{ $deposit->currency }}</td>

                <td>{{ $deposit->amount }}</td>

                <td>{{ $deposit->status }}</td>

               <td>

    @if($deposit->status == 'Pending')

        <form action="{{ route('admin.deposits.approve', $deposit) }}"
              method="POST">

            @csrf

            <button class="btn btn-success">
                Approve
            </button>

        </form>

        <form action="{{ route('admin.deposits.reject', $deposit) }}"
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