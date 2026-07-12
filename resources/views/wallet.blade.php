@extends('layouts.app')
@section('title', 'Wallet')@section('content')

    @include('components.balance-cards')

    @include('components.wallet-history')

@endsection