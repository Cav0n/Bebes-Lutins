<div class="sidenav py-3 w-100">
    <div class="top-sidenav ml-3">
        <h1 class="h2"><a class="text-secondary" href='/'><b>Bébés Lutins</b></a></h1>

        <div class="row m-0 mt-3">
            <div class="col-2 p-0">
                <img class="w-100 svg" src="{{ asset('images/icons/order-bw.svg') }}" height="2rem" alt="commandes">
            </div>
            <div class="col-10 d-flex flex-column">
                <a href='{{ route('admin.orders') }}' class='h5 mb-0 @if(url()->current() == route('admin.orders')) text-dark @endif'>
                    Commandes</a>

                <a href='{{ route('admin.orders', ['status' => ['WAITING_PAYMENT', 'PROCESSING', 'DELIVERING']]) }}' class='mb-0
                    @if(url()->current() == route('admin.orders') && request('status') == ['WAITING_PAYMENT', 'PROCESSING', 'DELIVERING']) text-dark @endif'>
                    En cours</a>
                <a href='{{ route('admin.orders', ['status' => ['DELIVERED', 'WITHDRAWAL', 'REGISTERED_PARTICIPATION']]) }}' class='mb-0
                    @if(url()->current() == route('admin.orders') && request('status') == ['DELIVERED', 'WITHDRAWAL', 'REGISTERED_PARTICIPATION']) text-dark @endif'>
                    Terminées</a>
                <a href='{{ route('admin.orders', ['status' => ['REFUSED_PAYMENT', 'CANCELED']]) }}' class='mb-0
                    @if(url()->current() == route('admin.orders') && request('status') == ['REFUSED_PAYMENT', 'CANCELED']) text-dark @endif'>
                    Refusées</a>
            </div>
        </div>

        <div class="row m-0 mt-3">
            <div class="col-2 p-0">
                <img class="w-100 svg" src="{{ asset('images/icons/product-bw.svg') }}" alt="produits">
            </div>
            <div class="col-10 d-flex flex-column">
                <a href='{{ route('admin.products') }}' class='h5 mb-0'>
                    Produits</a>

                <a href='{{ route('admin.products') }}' class='mb-0'>
                    Tous les produits</a>
                <a href='{{ route('admin.categories') }}' class='mb-0'>
                    Toutes les catégories</a>
                <a href='{{ route('admin.products', ['isHighlighted' => 1]) }}' class='mb-0'>
                    Mis en avant</a>
            </div>
        </div>

        <div class="row m-0 mt-3">
            <div class="col-2 p-0">
                <img class="w-100 svg" src="{{ asset('images/icons/customer-bw.svg') }}" alt="clients">
            </div>
            <div class="col-10 d-flex flex-column">
                <a href='{{ route('admin.customers') }}' class='h5 mb-0'>
                    Clients</a>

                <a href='{{ route('admin.customers') }}' class='mb-0'>
                    Tous les clients</a>
                <a href='{{ route('admin.customers') }}' class='mb-0'>
                    Avis clients</a>
            </div>
        </div>

        <div class="row m-0 mt-3">
            <div class="col-2 p-0">
                <img class="w-100 svg" src="{{ asset('images/icons/content-bw.svg') }}" alt="contenus">
            </div>
            <div class="col-10 d-flex flex-column">
                <a href='{{ route('admin.contents') }}' class='h5 mb-0'>
                    Contenus</a>

                <a href='{{ route('admin.contents') }}' class='mb-0'>
                    Bas de page</a>
            </div>
        </div>
    </div>

    <div class="bottom-sidenav text-center">
        <p style="color:grey">Version 6.0.0</p>
    </div>
</div>
