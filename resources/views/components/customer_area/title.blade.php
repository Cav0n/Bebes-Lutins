<div class="title card-title px-3 pt-3 mb-0 border-bottom">
    <h2 class="mb-0 font-weight-bold">Bienvenue {{Auth::user()->firstname}} {{Auth::user()->lastname}}</h2>
    <p class="mb-0">Votre espace client</p>
    <nav class="nav nav-tabs border-bottom-0 mt-3">
        <a class="nav-link @if(request()->path() == 'espace-client') active @endif" href="{{ route('customer.area') }}">
            Mes informations</a>
        <a class="nav-link @if(request()->path() == 'espace-client/mes-commandes') active @endif" href="{{ route('customer.area.orders') }}">
            Mes commandes</a>
        <a class="nav-link @if(request()->path() == 'espace-client/mes-adresses') active @endif" href="{{ route('customer.area.addresses') }}">
            Mes adresses</a>
    </nav>
</div>
