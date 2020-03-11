@extends('templates.default')

@section('title', "Mes commandes | Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 card p-0">

            @include('components.customer_area.title')

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
