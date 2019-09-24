@extends('templates.template')

@section('content')
<main class='container-fluid mt-md-0'>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10">
            <div class="card my-5">
                <div class="card-header bg-white">
                    <p class='h2 mb-0'>Bonjour {{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
                    <p class='font-weight-light text-muted'>Bienvenue dans votre espace client</p>
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Mon profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Mes commandes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Mes adresses</a>
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