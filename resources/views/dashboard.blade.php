
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif



@extends('layouts.app')

@section('content')

    @include('components.balance-cards')

    @include('components.stats-row')

     @include('components.market-overview')

      @include('components.transactions-table')

       @include('components.swap-portfolio')

@endsection