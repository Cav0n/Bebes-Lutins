<nav class="navbar navbar-expand-sm navbar-light w-100">
    <a class="h2 font-weight-bold mb-0 text-secondary" href="/">Bébés Lutins</a>
    <button class="navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse"
     id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item @if(request()->url() == route('admin.homepage')) active @endif">
                <a class="nav-link" href='{{ route('admin.homepage') }}'>
                    Accueil</a>
            </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted" href="#" id="orders-dropdown-mobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Commandes</a>
                    <div class="dropdown-menu shadow-none" aria-labelledby="orders-dropdown-mobile">
                        <a href='{{ route('admin.orders', ['status' => ['WAITING_PAYMENT', 'PROCESSING', 'DELIVERING']]) }}' class='mb-0 dropdown-item
                            @if(url()->current() == route('admin.orders') && (request('status') == ['WAITING_PAYMENT', 'PROCESSING', 'DELIVERING'] || request('status') == null)) active @endif'>
                            En cours</a>
                        <a href='{{ route('admin.orders', ['status' => ['DELIVERED', 'WITHDRAWAL', 'REGISTERED_PARTICIPATION']]) }}' class='mb-0 dropdown-item
                            @if(url()->current() == route('admin.orders') && request('status') == ['DELIVERED', 'WITHDRAWAL', 'REGISTERED_PARTICIPATION']) active @endif'>
                            Terminées</a>
                        <a href='{{ route('admin.orders', ['status' => ['REFUSED_PAYMENT', 'CANCELED']]) }}' class='mb-0 dropdown-item
                            @if(url()->current() == route('admin.orders') && request('status') == ['REFUSED_PAYMENT', 'CANCELED']) active @endif'>
                            Refusées</a>
                    </div>
                </li>



            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted" href="#" id="products-dropdown-mobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Produits</a>
                <div class="dropdown-menu shadow-none" aria-labelledby="products-dropdown-mobile">
                    <a class="dropdown-item @if(request()->url() == route('admin.products')) active @endif" href="{{ route('admin.products') }}">
                        Tous les produits</a>
                    <a class="dropdown-item @if(request()->url() == route('admin.categories')) active @endif" href="{{ route('admin.categories') }}">
                        Tous les catégories</a>
                    <a class="dropdown-item @if(url()->current() == route('admin.products') && request('isHighlighted') == 1) active @endif" href="{{ route('admin.products', ['isHighlighted' => 1]) }}">
                        Mis en avant</a>
                    <a class="dropdown-item @if(url()->current() == route('admin.promoCodes')) active @endif" href="{{ route('admin.promoCodes') }}">
                        Code promos</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted" href="#" id="customers-dropdown-mobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Clients</a>
                <div class="dropdown-menu shadow-none" aria-labelledby="customers-dropdown-mobile">
                    <a class="dropdown-item @if(url()->current() == route('admin.customers')) active @endif" href="{{ route('admin.customers') }}">
                        Tous les clients</a>
                    <a class="dropdown-item @if(url()->current() == route('admin.reviews')) active @endif" href="{{ route('admin.reviews') }}">
                        Avis clients</a>
                </div>
            </li>


            <li class="nav-item @if(request()->url() == route('admin.footer_elements')) active @endif">
                <a class="nav-link" href='{{ route('admin.footer_elements') }}'>
                    Contenus</a>
            </li>
            <li class="nav-item @if(request()->url() == route('admin.settings')) active @endif">
                <a class="nav-link" href='{{ route('admin.settings') }}'>
                    Réglages</a>
            </li>
        </ul>
    </div>
</nav>
