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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-lg-3 col-xl-2 p-0">
                <div class="sidenav py-3">
                    <h1 class="h2 text-center text-secondary"><b>Bébés Lutins</b></h1>

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
            </div>
            <div class="col-lg-10 py-3">
                @yield('content')
            </div>
        </div>
    </div>


    @yield('scripts')
</body>
</html>
