@php
    $cart = Session::get('shopping_cart');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800&display=swap" rel="stylesheet">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('optional_css')

    <title>@yield('title', 'Bébés Lutins')</title>
</head>
<body class="bg-white">
    <script src="{{ asset('js/app.js') }}"></script>

    @include('components.header.default')

    <div class="content-container bg-light">
        @yield('content')
    </div>

    @include('components.footer.default')

    @include('components.modal.product_added_to_cart')

    <script>
        const FREE_SHIPPING_FROM = {{ env('FREE_SHIPPING_FROM', 70.00) }}

        const SHIPPING_COSTS = {{ env('SHIPPING_COSTS', 5.90) }}

        const SPINNER_CONFIG = {
            decrementButton: "<strong>-</strong>", // button text
            incrementButton: "<strong>+</strong>", // ..
            groupClass: "quantity-selector", // css class of the resulting input-group
            buttonsClass: "btn-outline-dark rounded-0",
            buttonsWidth: "2.5rem",
            textAlign: "center",
            autoDelay: 500, // ms holding before auto value change
            autoInterval: 100, // speed of auto value change
            boostThreshold: 10, // boost after these steps
            boostMultiplier: "auto" // you can also set a constant number as multiplier
        }

        $(".input-spinner").inputSpinner(SPINNER_CONFIG);
    </script>

    @yield('scripts')
</body>
</html>
