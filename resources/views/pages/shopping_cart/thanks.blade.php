@extends('templates.default')

@section('title', "Accueil - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">
            <h1 class="h1 font-weight-bold">
                Merci pour votre commande !
            </h1>
            <p class="mb-0">
                @auth
                Vous pouvez retrouvez les informations de votre commande dans votre espace client, rubrique <a href='{{ route('customer.area.orders') }}'>mes commandes</a>.<BR>
                @endauth

                Vous devriez recevoir une confirmation de votre commande par email avec le numéro de suivi de celle-ci.<br>
                Si vous le souhaitez, vous pouvez suivre l'avancement de votre commande <a href='{{ route('order.tracking.show') }}'>ici</a> (votre numéro de suivi est {{ $order->trackingNumber }}).
            </p>
        </div>
    </div>
</div>

@endsection
