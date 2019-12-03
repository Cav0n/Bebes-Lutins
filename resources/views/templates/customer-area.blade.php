@extends('templates.template')

@section('head-options')
    {{-- Loading CSS --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading-btn.css')}}">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<main class='container-fluid mt-md-0 dim-background'>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
            <div class="card my-3 my-lg-5">
                <div class="card-header bg-white">
                    <p class='h2 mb-0'>Bonjour {{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
                    <p class='font-weight-light text-muted'>Bienvenue dans votre espace client</p>
                    <ul class="nav nav-tabs card-header-tabs mx-0">

                        {{-- NAV LINKS (TABS) --}}
                        <div class='d-none d-sm-flex'>
                            <li class="nav-item mr-2">
                                <a class="nav-link @if(Request::is('*/profil*')) active @endif text-dark" href="/espace-client/profil">
                                    Mon profil</a>
                            </li>
                            
                            <li class="nav-item mr-2">
                                <a class="nav-link @if(Request::is('*/commandes*')) active @endif text-dark" href="/espace-client/commandes">
                                    Mes commandes</a>
                            </li>

                            <li class="nav-item mr-2">
                                <a class="nav-link @if(Request::is('*/adresses*')) active @endif text-dark" href="/espace-client/adresses">
                                    Mes adresses</a>
                            </li>

                            <li class="nav-item mr-2">
                                <a class="nav-link @if(Request::is('*/ma-liste-d-envie*')) active @endif text-dark" href="/espace-client/ma-liste-d-envie">
                                    Ma liste d'envie</a>
                            </li>
                        </div>

                        {{-- MOBILE NAV LINKS (DROPDOWN TABS) --}}
                        <li class="nav-item dropdown d-flex d-sm-none">
                            <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Naviguer</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item @if(Request::is('*/profil*')) active @endif text-dark" href="/espace-client/profil">
                                    Mon profil</a>
                                <a class="dropdown-item @if(Request::is('*/commandes*')) active @endif text-dark" href="/espace-client/commandes">
                                    Mes commandes</a>
                                <a class="dropdown-item @if(Request::is('*/adresses*')) active @endif text-dark" href="/espace-client/adresses">
                                    Mes adresses</a>
                                <a class="dropdown-item @if(Request::is('*/ma-liste-d-envie*')) active @endif text-dark" href="/espace-client/ma-liste-d-envie">
                                    Ma liste d'envie</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" onclick='logout()'>Déconnexion</a>
                            </div>
                        </li>
                        
                    </ul>
                </div>
                <div class="card-body">
                    @yield('body')
                </div>
                <div class="card-footer bg-white text-muted">
                    <button type="button" class="btn btn-dark ld-ext-right" onclick='logout($(this))'>
                        Se déconnecter
                        <div class='ld ld-hourglass ld-spin-fast'></div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function load_url(url){
        document.location.href=url;
    }
</script>
@endsection