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
                    <a class="nav-link active" href="{{ route('customer.area') }}">Mes informations</a>
                    <a class="nav-link" href="{{ route('customer.area.orders') }}">Mes commandes</a>
                    <a class="nav-link" href="{{ route('customer.area.addresses') }}">Mes adresses</a>
                </nav>
            </div>
            <div class="body px-3">
                <div class="row py-3">
                    <div class="col-lg-10">
                        <h3 class="h4 font-weight-bold">Mes informations personnelles</h3>
                        <p class="mb-0">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
                        <p class="mb-0">{{Auth::user()->email}}</p>
                        <p class="mb-0">{{Auth::user()->phone}}</p>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-outline-secondary rounded-0 w-100">Modifier</button>
                    </div>
                </div>
                <div class="row py-3 border-top">
                    <div class="col-lg-10">
                        <h3 class="h4 font-weight-bold">Mot de passe</h3>
                        <p class="mb-0">Vous pouvez changer votre mot de passe quand vous le souhaitez.</p>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-outline-secondary rounded-0 w-100">Modifier</button>
                    </div>
                </div>
                <div class="row py-3 border-top">
                    <div class="col-lg-10">
                        <h3 class="h4 font-weight-bold">Newsletter</h3>
                        <p class="mb-0">Vous avez indiqué vouloir recevoir les actualités Bébés Lutins.</p>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-outline-secondary rounded-0 w-100">Activé</button>
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
