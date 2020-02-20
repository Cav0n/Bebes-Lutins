<div class="title card-title px-3 pt-3 mb-0 border-bottom">
    <h2 class="mb-0 font-weight-bold">Bienvenue {{Auth::user()->firstname}} {{Auth::user()->lastname}}</h2>
    <p class="mb-0">Votre espace client</p>
    <ul class="nav nav-tabs border-bottom-0 mt-3">
        <li class="nav-item dropdown d-flex d-sm-none">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Naviguer</a>
            <div class="dropdown-menu">
                <a class="dropdown-item @if(request()->path() == 'espace-client') active @endif" href="{{ route('customer.area') }}">Mes informations</a>
                <a class="dropdown-item @if(request()->path() == 'espace-client/mes-commandes') active @endif" href="{{ route('customer.area.orders') }}">Mes commandes</a>
                <a class="dropdown-item @if(request()->path() == 'espace-client/mes-adresses') active @endif" href="{{ route('customer.area.addresses') }}">Mes adresses</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Se déconnecter</a>
            </div>
        </li>

        <li class="nav-item d-none d-sm-flex">
            <a class="nav-link @if(request()->path() == 'espace-client') active @endif" href="{{ route('customer.area') }}">
                Mes informations</a>
        </li>
        <li class="nav-item d-none d-sm-flex">
            <a class="nav-link @if(request()->path() == 'espace-client/mes-commandes') active @endif" href="{{ route('customer.area.orders') }}">
                Mes commandes</a>
        </li>
        <li class="nav-item d-none d-sm-flex">
            <a class="nav-link @if(request()->path() == 'espace-client/mes-adresses') active @endif" href="{{ route('customer.area.addresses') }}">
                Mes adresses</a>
        </li>
    </ul>
</div>
