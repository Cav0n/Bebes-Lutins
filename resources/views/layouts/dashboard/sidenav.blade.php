<div id='sidenav' class="col-3 d-none d-lg-flex flex-column">
    <a href='/dashboard/commandes/en-cours' class='text-dark @if(Request::is('*/commandes*')) active @endif'><img src='{{asset('images/icons/orders.svg')}}' style='width:2.4rem;'> - Commandes</a>
        <a href="/dashboard/commandes/en-cours" class='sublink text-dark @if(Request::is('*/commandes/en-cours')) active @endif'> En cours</a>
        <a href="/dashboard/commandes/terminees" class='sublink text-dark @if(Request::is('*/commandes/terminees')) active @endif'> Terminées</a>
        <a href="/dashboard/commandes/refusees" class='sublink text-dark @if(Request::is('*/commandes/refusees')) active @endif'> Refusées</a>
    <a href='/dashboard/produits' class='text-dark mt-3 @if(Request::is('*/produits*')) active @endif'><img src='{{asset('images/icons/products.svg')}}' style='width:2.4rem;'> - Produits</a>
        <a href="/dashboard/produits" class='sublink text-dark @if(Request::is('*/produits')) active @endif'> Tous les produits</a>
        <a href="/dashboard/produits/categories" class='sublink text-dark @if(Request::is('*/produits/categories')) active @endif'> Toutes les catégories</a>
        <a href="/dashboard/produits/stocks" class='sublink text-dark @if(Request::is('*/produits/stocks')) active @endif'> Stocks</a>
    <a href='/dashboard/clients' class='text-dark mt-3 @if(Request::is('*/clients*')) active @endif'><img src='{{asset('images/icons/customers.svg')}}' style='width:2.4rem;'> - Clients</a>
        <a href='/dashboard/clients' class='sublink text-dark @if(Request::is('*/clients')) active @endif'> Tous les clients</a>
        <a href='/dashboard/clients/avis' class='sublink text-dark @if(Request::is('*/clients/avis')) active @endif'> Avis clients</a>
    <a href='/dashboard/reductions' class='text-dark mt-3 @if(Request::is('*/reductions*')) active @endif'><img src='{{asset('images/icons/vouchers.svg')}}' style='width:2.4rem;'> - Réductions</a>
    <a href='/dashboard/newsletters' class='text-dark mt-3 @if(Request::is('*/newsletters*')) active @endif'><img src='{{asset('images/icons/newsletters.svg')}}' style='width:2.4rem;'> - Newsletters</a>
</div>