<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="max-width:1000px;margin:0 auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>@yield('title', 'Bébés Lutins')</title>
</head>
<body class="bg-dark">
    <div class="container-fluid bg-white">
        @yield('content')
    </div>
</body>
</html>
