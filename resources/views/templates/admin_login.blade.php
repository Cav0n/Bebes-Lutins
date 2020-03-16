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

    <title>@yield('title', 'Administration | Bébés Lutins')</title>
    <meta name="description" content="@yield('description', "Connectez vous à votre espace d'administration.")">
</head>
<body>
    <script src="{{ asset('js/app.js') }}"></script>

    <div class="content-container">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
