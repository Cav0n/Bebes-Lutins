<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- JQuery 3.4.1 --}}
    <script src="{{asset('js/jquery/jquery-3.4.1.js')}}"></script>

    {{-- PopperJS --}}
    <script src="{{asset('js/popper/popper.min.js')}}"></script>

    {{-- Bootstrap --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/bootstrap/bootstrap.min.css')}}">
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>

    {{-- Custom CSS --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/custom/main.css')}}">

    <!-- FontAwesome icons -->
    <script src="{{asset('js/fontawesome/fontawesome.js')}}"></script>

    @yield('head-options')

    <title>@yield('title', 'Bébés Lutins')</title>
</head>
<body>
    @include('layouts.public.header')
    @yield('content')
    @include('layouts.public.footer')
</body>
</html>