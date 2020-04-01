<div id="admin-sidenav" class="sidenav py-3 w-100">
    <div class="top-sidenav ml-3">
        <h1 class="h2"><a class="text-secondary" href='/'><b>Bébés Lutins</b></a></h1>

        <div class="row m-0 mt-3">
            <div class="col-2 p-0">
                <img class="w-100 svg @if(url()->current() == route('admin.orders')) active @endif"
                    src="{{ asset('images/icons/order-bw.svg') }}" height="2rem" alt="commandes">
            </div>
            <div class="col-10 d-flex flex-column">
                <a href='{{ route('admin.orders') }}' class='h5 mb-0 @if(url()->current() == route('admin.orders')) active @endif'>
                    Commandes</a>

                <a href='{{ route('admin.orders', ['status' => ['WAITING_PAYMENT', 'PROCESSING', 'DELIVERING']]) }}' class='mb-0
                    @if(url()->current() == route('admin.orders') && (request('status') == ['WAITING_PAYMENT', 'PROCESSING', 'DELIVERING'] || request('status') == null)) active @endif'>
                    En cours</a>
                <a href='{{ route('admin.orders', ['status' => ['DELIVERED', 'WITHDRAWAL', 'REGISTERED_PARTICIPATION']]) }}' class='mb-0
                    @if(url()->current() == route('admin.orders') && request('status') == ['DELIVERED', 'WITHDRAWAL', 'REGISTERED_PARTICIPATION']) active @endif'>
                    Terminées</a>
                <a href='{{ route('admin.orders', ['status' => ['REFUSED_PAYMENT', 'CANCELED']]) }}' class='mb-0
                    @if(url()->current() == route('admin.orders') && request('status') == ['REFUSED_PAYMENT', 'CANCELED']) active @endif'>
                    Refusées</a>
            </div>
        </div>

        <div class="row m-0 mt-3">
            <div class="col-2 p-0">
                <img class="w-100 svg @if(url()->current() == route('admin.products') || url()->current() == route('admin.categories')) active @endif"
                    src="{{ asset('images/icons/product-bw.svg') }}" alt="produits">
            </div>
            <div class="col-10 d-flex flex-column">
                <a href='{{ route('admin.products') }}' class='h5 mb-0
                    @if(url()->current() == route('admin.products') || url()->current() == route('admin.categories')) active @endif'>
                    Produits</a>

                <a href='{{ route('admin.products') }}' class='mb-0
                    @if(url()->current() == route('admin.products') && request('isHighlighted') == null) active @endif'>
                    Tous les produits</a>
                <a href='{{ route('admin.categories') }}' class='mb-0
                    @if(url()->current() == route('admin.categories')) active @endif'>
                    Toutes les catégories</a>
                <a href='{{ route('admin.products', ['isHighlighted' => 1]) }}' class='mb-0
                    @if(url()->current() == route('admin.products') && request('isHighlighted') == 1) active @endif'>
                    Mis en avant</a>
            </div>
        </div>

        <div class="row m-0 mt-3">
            <div class="col-2 p-0">
                <img class="w-100 svg @if(url()->current() == route('admin.customers')) active @endif"
                    src="{{ asset('images/icons/customer-bw.svg') }}" alt="clients">
            </div>
            <div class="col-10 d-flex flex-column">
                <a href='{{ route('admin.customers') }}' class='h5 mb-0
                    @if(url()->current() == route('admin.customers') && url()->current() == route('admin.reviews')) active @endif'>
                    Clients</a>

                <a href='{{ route('admin.customers') }}' class='mb-0
                    @if(url()->current() == route('admin.customers')) active @endif'>
                    Tous les clients</a>
                <a href='{{ route('admin.reviews') }}' class='mb-0
                    @if(url()->current() == route('admin.reviews')) active @endif'>
                    Avis clients</a>
            </div>
        </div>

        <div class="row m-0 mt-3">
            <div class="col-2 p-0">
                <img class="w-100 svg  @if(url()->current() == route('admin.contents')) active @endif"
                    src="{{ asset('images/icons/content-bw.svg') }}" alt="contenus">
            </div>
            <div class="col-10 d-flex flex-column">
                <a href='{{ route('admin.contents') }}' class='h5 mb-0
                    @if(url()->current() == route('admin.contents')) active @endif'>
                    Contenus</a>

                <a href='{{ route('admin.contents') }}' class='mb-0
                    @if(url()->current() == route('admin.contents'))active @endif'>
                    Bas de page</a>
            </div>
        </div>
    </div>

    <div class="bottom-sidenav text-center">
        <p style="color:grey">Version 6.0.0</p>
    </div>
</div>
