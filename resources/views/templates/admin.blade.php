<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @yield('optional_css')

    <title>@yield('title', 'Administration')</title>
    <meta name="description" content="@yield('description', "Bienvenue sur votre page d'administration.")">
</head>
<body>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

    <header class="d-flex d-lg-none fixex-top">
        <nav class="navbar navbar-expand-sm navbar-light bg-light w-100">
            <a class="h2 font-weight-bold mb-0 text-secondary" href="/">Bébés Lutins</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item @if(request()->url() == route('admin.orders')) active @endif">
                    <a class="nav-link" href='{{ route('admin.orders') }}'>
                        Commandes</a>
                </li>
                <li class="nav-item @if(request()->url() == route('admin.products')) active @endif">
                    <a class="nav-link" href='{{ route('admin.products') }}'>
                        Produits</a>
                </li>
                <li class="nav-item @if(request()->url() == route('admin.customers')) active @endif">
                    <a class="nav-link" href='{{ route('admin.customers') }}'>
                        Clients</a>
                </li>
              </ul>
            </div>
          </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="d-none d-lg-flex col-lg-2 p-0">
                <div class="sidenav py-3 w-100">
                    <div class="top-sidenav">
                        <h1 class="h2 text-center">
                            <a class="text-secondary" href='/'><b>Bébés Lutins</b></a></h1>

                        <div class="p-3 d-flex flex-column">
                            <a href='{{ route('admin') }}' class='h5 mb-0'>Commandes</a>
                            <a href='{{ route('admin') }}' class='mb-0'>En cours</a>
                            <a href='{{ route('admin') }}' class='mb-0'>Terminées</a>
                            <a href='{{ route('admin') }}' class='mb-0'>Refusées</a>

                            <a href='{{ route('admin.products') }}' class='h5 mt-3 mb-0'>Produits</a>
                            <a href='{{ route('admin.products') }}' class='mb-0'>Tous les produits</a>
                            <a href='{{ route('admin.categories') }}' class='mb-0'>Toutes les catégories</a>
                            <a href='{{ route('admin.products') }}' class='mb-0'>Mis en avant</a>

                            <a href='{{ route('admin.customers') }}' class='h5 mt-3 mb-0'>Clients</a>
                            <a href='{{ route('admin.customers') }}' class='mb-0'>Tous les clients</a>
                            <a href='{{ route('admin.customers') }}' class='mb-0'>Avis clients</a>
                            <a href='{{ route('admin.customers') }}' class='mb-0'>Messages</a>
                        </div>
                    </div>

                    <div class="bottom-sidenav text-center">
                        <p style="color:grey">Version 6.0.0</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-10 py-3">
                @yield('content')
            </div>
        </div>
    </div>


    @yield('scripts')
</body>
</html>
