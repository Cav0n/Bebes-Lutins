@extends('templates.default')

@section('title', "Mes adresses | Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 card p-0">
            <div class="title card-title px-3 pt-3 mb-0 border-bottom">
                <h2 class="mb-0 font-weight-bold">Bienvenue {{Auth::user()->firstname}} {{Auth::user()->lastname}}</h2>
                <p class="mb-0">Votre espace client</p>
                <nav class="nav nav-tabs border-bottom-0 mt-3">
                    <a class="nav-link" href="{{ route('customer.area') }}">Mes informations</a>
                    <a class="nav-link" href="{{ route('customer.area.orders') }}">Mes commandes</a>
                    <a class="nav-link active" href="{{ route('customer.area.addresses') }}">Mes adresses</a>
                </nav>
            </div>
            <div class="body p-3">
                <div class="row py-3">
                    <div class="col-lg-12">
                        <h3 class="h4 font-weight-bold">Mes adresses</h3>
                        @foreach (Auth::user()->addresses as $address)
                            <p class="company">{{ $address->company }}</p>
                            <p class="street">{{ $address->street }}</p>
                            <p class="complements">{{ $address->complements }}</p>
                            <p class="zipCode-city">{{ $address->zipCode }}, {{ $address->city }}</p>
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
