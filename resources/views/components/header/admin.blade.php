<nav class="navbar navbar-expand-sm navbar-light bg-light w-100">
    <a class="h2 font-weight-bold mb-0 text-secondary" href="/">Bébés Lutins</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse"
     id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item @if(request()->url() == route('admin.homepage')) active @endif">
                <a class="nav-link" href='{{ route('admin.homepage') }}'>
                    Accueil</a>
            </li>
            <li class="nav-item @if(request()->url() == route('admin.orders')) active @endif">
                <a class="nav-link" href='{{ route('admin.orders') }}'>
                    Commandes</a>
            </li>
            <li class="nav-item @if(request()->url() == route('admin.products')) active @endif">
                <a class="nav-link" href='{{ route('admin.products') }}'>
                    Produits</a>
            </li>
            <li class="nav-item @if(request()->url() == route('admin.customers')) active @endif">
                <a class="nav-link" href='{{ route('admin.customers') }}'>
                    Clients</a>
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
