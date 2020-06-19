@php
    $categories = App\Category::where('isDeleted', 0)->where('isHidden', 0)->get();
@endphp

<header class="sticky-top p-0 container-fluid border-bottom row m-0 bg-white justify-content-center">
    <img id="logo" src="{{ asset('images/logo.png') }}" class="fixed-top transition-fast">

    <nav class="navbar navbar-expand-lg navbar-light bg-white p-3 p-lg-0 col-xxl-10 col-xxxl-8 border-left border-right">
        <a class="navbar-brand d-none" href="#">Bébés Lutins</a>
        <button class="navbar-toggler d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">

            {{-- DESKTOP NAVBAR --}}
            <ul class="navbar-nav w-100 mr-auto mt-2 mt-lg-0 d-none d-lg-flex flex-column text-center">
                <div class="top-navbar d-flex justify-content-between">
                    <div class="left">
                        <div class="contact-container py-2 h-100" style="width: 24rem;">
                            <a href="/contact" class="h3 font-weight-bold" style="text-transform: uppercase;">
                                Contactez-nous</a>
                            <div class="row justify-content-center mt-2">
                                <div class="col-1 px-1">
                                    <img class="w-100" src="{{ asset('images/icons/telephone-color.svg') }}" alt="telephone">
                                </div>
                                <div class="col-1 px-1">
                                    <img class="w-100" src="{{ asset('images/icons/email-color.svg') }}" alt="telephone">
                                </div>
                                <div class="col-1 px-1">
                                    <img class="w-100" src="{{ asset('images/icons/location-color.svg') }}" alt="telephone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right d-flex">
                         <div class="customer-container d-flex flex-column py-2 border-right" style="width: 12rem;">
                            <a href="{{ route('customer.area') }}" class="h3 font-weight-bold" style="text-transform: uppercase;">
                                Mon compte</a>
                            @auth
                            <a href="{{ route('customer.area') }}">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</a>
                            <a href="{{ route('logout') }}">Se déconnecter</a>
                            @endauth
                            @guest
                            <a href="{{ route('login') }}">Se connecter</a>
                            <a href="{{ route('registration') }}">Créer mon compte</a>
                            @endguest

                         </div>
                         <div class="cart-container d-flex flex-column py-2" style="width: 12rem;">
                            <a href="{{ route('cart') }}" class="h3 font-weight-bold" style="text-transform: uppercase;">
                                Mon panier</a>
                            <a href="#" id="cart-total-price">{{ \App\NumberConvertor::doubleToPrice($cart ? $cart->totalPrice : 0) }}</a>
                            <a href="#" id="cart-total-quantity">{{ $cart ? $cart->totalQuantity : 0 }} articles</a>
                         </div>
                    </div>
                </div>

                <div class="bottom-navbar d-flex justify-content-between border-top">
                    <div class="left d-flex">
                        <a href="/" style="width:12rem;" class="h5 py-2 m-0 border-right">Accueil</a>
                        <a href="#" style="width:12rem;" class="h5 py-2 m-0 border-right dropdown-toggle" id="categories-dropdown-desktop" aria-haspopup="true" aria-expanded="false">Nos produits</a>
                            @include('components.utils.categories.dropdown_menu', ['categories' => $categories])
                    </div>
                    <div class="right d-flex">
                        <a href="#" style="width: 12rem;" class="h5 py-2 m-0 border-right border-left">Qui sommes nous ?</a>
                        <a href="#" style="width: 12rem;" class="h5 py-2 m-0">Guide et conseils</a>
                    </div>
                </div>
            </ul>


            {{-- MOBILE NAVBAR --}}
            <ul class="mobile navbar-nav mr-auto mt-5 mt-lg-0 d-flex d-lg-none">
                <div class="separator mt-3 mt-sm-5"></div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted" href="#" id="categories-dropdown-mobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nos produits</a>
                    <div class="dropdown-menu shadow-none" aria-labelledby="categories-dropdown-mobile">
                        @foreach ($categories as $category)
                            @if (null == $category->parentId && !$category->isHidden)
                            <a class="dropdown-item" href="{{ route('category', ['category' => $category->id]) }}">
                                {{ $category->name }}</a>
                            @endif
                        @endforeach
                    </div>
                </li>
                <li class="nav-item @if( Str::contains(url()->current(), route('cart'))) active @endif">
                    <a class="nav-link" href="{{ route('cart') }}">Mon panier</a>
                </li>
                @guest
                <li class="nav-item @if( Str::contains(url()->current(), route('login'))) active @endif">
                    <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                </li>
                @endguest
                @auth
                <li class="nav-item @if( Str::contains(url()->current(), route('customer.area'))) active @endif">
                    <a class="nav-link" href="{{ route('customer.area') }}">Mon compte</a>
                </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link" href="#">Guides et conseils</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Qui sommes nous ?</a>
                </li>
                @auth
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Se déconnecter</a>
                </li>
                @endauth
            </ul>

        </div>
    </nav>

    {{-- LOGO --}}
    <script>
        $('#logo').on('click', function() { window.location.href = '/' } );
    </script>

    {{-- CART --}}
    <script>
        cartPrice = {{ $cart ? $cart->totalPrice : 0 }};
        cartQuantity = {{ $cart ? $cart->totalQuantity : 0 }};

        $('#categories-dropdown-desktop').on('click', function (event) {
            $('.dropdown-menu').toggleClass('show')
        });

        $('body').on('click', function (e) {
            if (!$('.dropdown-menu').is(e.target)
                && $('.dropdown-menu').has(e.target).length === 0
                && $('#categories-dropdown-desktop').has(e.target).length === 0
                && !$('#categories-dropdown-desktop').is(e.target)
            ) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        $("body").on("productAddedToCart", function(e, price, quantity) {
            cartQuantity = parseInt(cartQuantity) + parseInt(quantity);
            cartPrice = cartPrice + (price * quantity);

            cartPriceFormatted = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(cartPrice);

            $('#cart-total-price').text(cartPriceFormatted)
            $("#cart-total-quantity").text(cartQuantity + ' articles');
        });

        $("body").on("cartItemQuantityChanged", function(e, price, quantity) {
            cartQuantity = parseInt(cartQuantity) + parseInt(quantity);
            cartPrice = cartPrice + (price * quantity);

            cartPriceFormatted = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(cartPrice);

            $('#cart-total-price').text(cartPriceFormatted)
            $("#cart-total-quantity").text(cartQuantity + ' articles');
        });
    </script>
</header>
