@extends('templates.template')

@section('content')
<main class='container-fluid mt-md-0 dim-background'>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
            <div class="card my-5">
                <div class="card-header bg-white">
                    <p class='h2 mb-0'>Bonjour {{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
                    <p class='font-weight-light text-muted'>Bienvenue dans votre espace client</p>
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link @if(Request::is('*/profil')) active @endif text-dark" href="/espace-client/profil">Mon profil</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link @if(Request::is('*/commandes')) active @endif text-dark" href="/espace-client/commandes">Mes commandes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Request::is('*/adresses')) active @endif text-dark" href="/espace-client/adresses">Mes adresses</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    @yield('body')
                </div>
                <div class="card-footer bg-white text-muted">
                    <a href='/logout' class="text-muted font-weight-light">Se déconnecter</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection