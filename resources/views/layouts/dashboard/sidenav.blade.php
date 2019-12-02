<div id='sidenav' class="col-3 d-none d-lg-flex flex-column my-3">
    <a href='/dashboard/commandes/toutes' class='text-dark d-flex @if(Request::is('*/commandes*')) active @endif'><img src='{{asset('images/icons/orders1.svg')}}' class='svg'><p class='ml-2 my-auto'>- Commandes</p></a>
        <a href="/dashboard/commandes" class='sublink text-dark @if(Request::is('*/commandes')) active @endif'><p class='mb-0'>Toutes les commandes</p></a>
        <a href="/dashboard/commandes/en-cours" class='sublink text-dark @if(Request::is('*/commandes/en-cours')) active @endif'><p class='mb-0'>En cours</p></a>
        <a href="/dashboard/commandes/terminees" class='sublink text-dark @if(Request::is('*/commandes/terminees')) active @endif'><p class='mb-0'>Terminées</p></a>
        <a href="/dashboard/commandes/refusees" class='sublink text-dark @if(Request::is('*/commandes/refusees')) active @endif'><p class='mb-0'>Refusées</p></a>
    <a href='/dashboard/produits' class='text-dark d-flex mt-3 @if(Request::is('*/produits*')) active @endif'><img src='{{asset('images/icons/nappy2.svg')}}' class='svg'><p class='ml-2 my-auto'>- Produits</p></a>
        <a href="/dashboard/produits" class='sublink text-dark @if(Request::is('*/produits')) active @endif'><p class='mb-0'>Tous les produits</p></a>
        <a href="/dashboard/produits/categories" class='sublink text-dark @if(Request::is('*/produits/categories')) active @endif'><p class='mb-0'>Toutes les catégories</p></a>
        <a href="/dashboard/produits/mis-en-avant" class='sublink text-dark @if(Request::is('*/produits/mis-en-avant')) active @endif'><p class='mb-0'>Mis en avant</p></a>
        <a href="/dashboard/produits/stocks" class='sublink text-dark @if(Request::is('*/produits/stocks')) active @endif'><p class='mb-0'>Stocks</p></a>
    <a href='/dashboard/clients' class='text-dark d-flex mt-3 @if(Request::is('*/clients*')) active @endif'><img src='{{asset('images/icons/customer5.svg')}}' class='svg'><p class='ml-2 my-auto'>- Clients</p></a>
        <a href='/dashboard/clients' class='sublink text-dark @if(Request::is('*/clients')) active @endif'><p class='mb-0'>Tous les clients</p></a>
        <a href='/dashboard/clients/avis' class='sublink text-dark @if(Request::is('*/clients/avis*')) active @endif'><p class='mb-0'>Avis clients</p></a>
        <a href='/dashboard/clients/messages' class='sublink text-dark @if(Request::is('*/clients/messages*')) active @endif'><p class='mb-0'>Messages</p></a>
    <a href='/dashboard/reductions' class='text-dark d-flex mt-3 @if(Request::is('*/reductions*')) active @endif'><img src='{{asset('images/icons/coupon4.svg')}}' class='svg'><p class='ml-2 my-auto'>- Réductions</p></a>
    <a href='/dashboard/newsletters' class='text-dark d-flex mt-3 @if(Request::is('*/newsletters*')) active @endif'><img src='{{asset('images/icons/newsletters2.svg')}}' class='svg'><p class='ml-2 my-auto'>- Newsletters</p></a>
    <a href='/dashboard/analyses' class='text-dark d-flex mt-3 @if(Request::is('*/analyses*')) active @endif'><img src='{{asset('images/icons/analytics.svg')}}' class='svg'><p class='ml-2 my-auto'>- Analyses<span class="badge badge-secondary ml-2">New</span></p></a>

    <a href='/dashboard/changelog' class='ml-5 mt-3 text-muted'><small>Version 5.0.2.1</small></a>
</div>