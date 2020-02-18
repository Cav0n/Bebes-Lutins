@extends('templates.default')

@section('title', "Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 card p-0">
            <div class="title card-title px-3 pt-3 mb-0 border-bottom">
                <h2 class="mb-0 font-weight-bold">Bienvenue {{Auth::user()->firstname}} {{Auth::user()->lastname}}</h2>
                <p class="mb-0">Votre espace client</p>
                <nav class="nav nav-tabs border-bottom-0 mt-3">
                    <a class="nav-link" href="{{ route('customer.area') }}">Mes informations</a>
                    <a class="nav-link active" href="{{ route('customer.area.orders') }}">Mes commandes</a>
                    <a class="nav-link" href="#">Mes adresses</a>
                </nav>
            </div>
            <div class="body p-3">
                <div class="row py-3">
                    <div class="col-lg-12">
                        <h3 class="h4 font-weight-bold">Mes commandes</h3>
                        @foreach (Auth::user()->orders as $order)
                            <p>Commande passée {{ Carbon\Carbon::parse($order->created_at)->locale('fr')->calendar() }}</p>
                            <p>
                                Montant total de la commande : {{ \App\NumberConvertor::doubleToPrice($order->totalPrice + $order->shippingCosts) }}<br>
                                Frais de livraison : {{ \App\NumberConvertor::doubleToPrice($order->shippingCosts) }}<br>
                                Payé par {{ $order->paymentMethod }}
                            </p>
                            <p>Status : {{ $order->status }}</p>
                            <div class="order-items-container">
                                @foreach ($order->items as $item)
                                <p>{{ $item->product->name }} - {{ \App\NumberConvertor::doubleToPrice($item->product->price) }}</p>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer border-bottom p-3">
                <a href="{{route('logout')}}" class="mb-0 text-dark">Se déconnecter</a>
            </div>
        </div>
    </div>
</div>

@endsection
