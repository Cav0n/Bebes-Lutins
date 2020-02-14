@php
    $categories = App\Category::all();
@endphp

<header class="fixed-top p-0 container-fluid border-bottom">
    <img id="logo" src="{{asset('images/logo.png')}}" class="fixed-top transition-fast d-none d-lg-flex" style="top: -2rem;left: calc(50vw - 7rem);cursor: pointer;height:14rem;">

    <nav class="navbar navbar-expand-lg navbar-light bg-white p-3 p-lg-0">
        <a class="navbar-brand d-flex d-lg-none" href="#">Bébés Lutins</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">

            {{-- DESKTOP NAVBAR --}}
            <ul class="navbar-nav w-100 mr-auto mt-2 mt-lg-0 d-none d-lg-flex flex-column text-center">
                <div class="top-navbar d-flex justify-content-between">
                    <div class="left">
                        <div class="contact-container py-2 h-100" style="width: 18rem;">
                            <a href="#" class="h3 font-weight-bold" style="text-transform: uppercase;">Contactez-nous</a>
                        </div>
                    </div>
                    <div class="right d-flex">
                         <div class="customer-container d-flex flex-column py-2 border-right" style="width: 12rem;">
                            <a href="{{route('customer.area')}}" class="h3 font-weight-bold" style="text-transform: uppercase;">Mon compte</a>
                            @auth
                            <a href="{{route('customer.area')}}">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</a>
                            <a href="{{route('logout')}}">Se déconnecter</a>
                            @endauth
                            @guest
                            <a href="{{route('login')}}">Se connecter</a>
                            <a href="{{route('registration')}}">Créer mon compte</a>
                            @endguest

                         </div>
                         <div class="cart-container d-flex flex-column py-2" style="width: 12rem;">
                            <a href="#" class="h3 font-weight-bold" style="text-transform: uppercase;">Mon panier</a>
                            <a href="#">0.00€</a>
                            <a href="#">0 articles</a>
                         </div>
                    </div>
                </div>

                <div class="bottom-navbar d-flex justify-content-between border-top">
                    <div class="left d-flex">
                        <a href="/" style="width:9rem;" class="h5 py-2 m-0 border-right">Accueil</a>
                        <a href="#" style="width:9rem;" class="h5 py-2 m-0 border-right dropdown-toggle" id="categories-dropdown-desktop" aria-haspopup="true" aria-expanded="false">Nos produits</a>
                        <div id="categories-dropdown-desktop-container" class="dropdown-menu w-100" aria-labelledby="categories-dropdown-desktop">
                            @include('components.utils.categories.dropdown_menu', ['categories' => $categories])
                        </div>
                    </div>
                    <div class="right d-flex">
                        <a href="#" style="width: 12rem;" class="h5 py-2 m-0 border-right border-left">Qui sommes nous ?</a>
                        <a href="#" style="width: 12rem;" class="h5 py-2 m-0">Guide et conseils</a>
                    </div>
                </div>
            </ul>


            {{-- MOBILE NAVBAR --}}
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 d-flex d-lg-none">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="categories-dropdown-mobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nos produits</a>
                    <div class="dropdown-menu" aria-labelledby="categories-dropdown-mobile">
                        @foreach ($categories as $category)
                            <a class="dropdown-item" href="{{route('category', ['category' => $category->id])}}">
                                {{$category->name}}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Mon panier</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('login')}}">Se connecter</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Guides et conseils</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Qui sommes nous ?</a>
                </li>
            </ul>

        </div>
    </nav>

    <script>

    $('#categories-dropdown-desktop').on('click', function (event) {
        $('.dropdown-menu').toggleClass('show')
    });

    $('body').on('click', function (e) {
        if (!$('.dropdown-menu').is(e.target)
            && $('.dropdown-menu').has(e.target).length === 0
            && $('#categories-dropdown-desktop').has(e.target).length === 0
            && !$('#categories-dropdown-desktop').is(e.target)
        ) {
            console.log (  )
            $('.dropdown-menu').removeClass('show');
        }
    });

    </script>
</header>
