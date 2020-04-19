@extends('templates.admin')

@section('content')

<div class="row justify-content-between mx-0">
    <a class="btn btn-dark mb-3" href="{{ route('admin.orders') }}" role="button">
        < Commandes</a>
</div>

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Commande de {{ $order->billingAddress->firstname . ' ' . $order->billingAddress->lastname }}</h2>
    </div>
    <div class="card-body">
        @include('components.utils.orders.order', ['order' => $order])
    </div>
</div>

@endsection
