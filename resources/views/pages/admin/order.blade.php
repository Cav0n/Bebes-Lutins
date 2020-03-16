@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Commande de {{ $order->billingAddress->firstname . ' ' . $order->billingAddress->lastname }}</h2>
    </div>
    <div class="card-body">
        <a href='{{ route('admin') }}' class='text-dark'>< Commandes</a>
        @include('components.utils.orders.order', ['order', $order])
    </div>
</div>

@endsection
