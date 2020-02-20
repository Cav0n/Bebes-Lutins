<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <title>@yield('title', 'Bébés Lutins')</title>
</head>
<body>
    <script src="{{asset('js/app.js')}}"></script>

    @include('components.header.default')

    <div class="content-container">
        @yield('content')
    </div>

    @include('components.footer.default')

    @include('components.modal.product_added_to_cart')

    @yield('scripts')
</body>
</html>
