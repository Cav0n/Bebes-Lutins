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
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/bootstrap/bootstrap.css')}}">
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>

    {{-- Custom CSS --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/main.css')}}">

    {{-- Dashboard CSS --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/dashboard/dashboard.css')}}">

    <!-- FontAwesome icons -->
    <script src="{{asset('js/fontawesome/fontawesome.js')}}"></script>

    @yield('head-options')

    <title>@yield('title', 'DASHBOARD - Bébés Lutins')</title>
</head>
<body>
    <main class='container-fluid'>
        <div class="row justify-content-md-center">
            <div class="col-lg-10 col-xl-8">
            @include('layouts.dashboard.header')
            
            <div class="row">
                
                @include('layouts.dashboard.sidenav')
                
                <div class="col-12 col-lg-9">
                    @yield('content')
                </div>
            </div>

            @include('layouts.dashboard.footer')
            </div>
        </div>
    </main>
    @include('components.dashboard.loader')
</body>
</html>