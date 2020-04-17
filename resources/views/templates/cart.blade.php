@extends('templates.default')

@section('title', "Mon panier - Bébés Lutins")

@section('optional_css')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css"/>
@endsection

@section('content')

<div id="cart" class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">
            @include('components.utils.cart.steps')

            <h1 class="font-weight-bold">@yield('cart.title', 'Mon panier')</h1>

            @isset($alertMessage)
                <div class="alert alert-danger" role="alert">
                    {{ $alertMessage }}
                </div>
            @endisset

            @if(!empty($errors->any()))
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                <p class="mb-0">{{ ucfirst($error) }}</p>
                @endforeach
            </div>
            @endif

            @if(!empty($unavailableItems))
            <div class="alert alert-danger" role="alert">
                <p>Certains produit de votre panier ne sont plus disponibles : </p>
                <ul class="mb-0">
                    @foreach ($unavailableItems as $item)
                        <li><a href="{{ route('product', ['product' => $item->product]) }}" class="alert-danger">
                            {{ ucfirst($item->product->name) }}
                        </a></li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(!empty($stockDecreasedItems))
            <div class="alert alert-danger" role="alert">
                <p>Le stock de certains produits ont diminué : </p>
                <ul class="mb-0">
                    @foreach ($stockDecreasedItems as $item)
                        <li><a href="{{ route('product', ['product' => $item->product]) }}" class="alert-danger">
                            {{ ucfirst($item->product->name) }}
                        </a></li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="row m-0">
                {{-- CART CONTENT --}}
                <div class="col-12 @if (0 < $cartStep && 4 > $cartStep) col-md-8 @endif pr-0 pl-0 pr-md-2 my-2">
                    @yield('cart.content')

                    @if ($cartStep >=1 && $cartStep <=3)
                    <div class="p-3 mt-2 bg-white shadow-sm w-100">
                        <div class="form-group">
                            <label for="cart_message">Vous pouvez ajouter un commentaire a votre commande ici :</label>
                            <div class="loading-textarea-container ld-over">
                                <textarea class="form-control" name="cart_message" id="cart_message" rows=4 onchange="addCartComment('{{ $cart->id }}', $(this))">{{ $cart->comment }}</textarea>
                                <div class="ld ld-ring ld-spin"></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-dark" onclick="addCartComment('{{ $cart->id }}', $('#cart_message'))">Enregistrer</button>
                    </div>
                    @endif
                </div>

                {{-- CART RECAP --}}
                @if (0 < $cartStep && 4 > $cartStep)
                <div class="col-md-4 pr-0 pl-0 pl-md-2 my-2">

                    {{-- Price recap --}}
                    <div id="price-recap" class="border bg-white p-3">
                        <p class="mb-0 total-quantity">{{ $cart->totalQuantity }} produits : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice) }}</p>
                        <p class="mb-0 total-shipping-costs">Frais de ports : {{ \App\NumberConvertor::doubleToPrice($cart->shippingCosts) }}</p>
                        <p class="mb-0 total">TOTAL T.T.C. : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice + $cart->shippingCosts) }}</p>
                        @if (1 == $cartStep || 2 == $cartStep)
                        <div class="next-button-container ld-over mt-2">
                            @if (1 == $cartStep)
                                <a class="next-step-button btn btn-primary w-100 rounded-0" href="/panier/livraison" role="button">Valider mon panier</a>
                            @elseif (2 == $cartStep)
                                <button class="next-step-button btn btn-primary w-100 rounded-0" role="submit" form="address-selection">Passer au paiement</button>
                            @endif
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                        @endif
                    </div>

                    {{-- Items recap --}}
                    @if ($cartStep >= 2)
                    <div id='items-recap' class="border bg-white mt-2 p-3">
                        @foreach ($cart->items as $item)
                        @include('components.utils.cart.item_mini')
                        @endforeach
                    </div>
                    @endif

                    {{-- Delivery recap --}}
                    @if ($cartStep >= 3)
                    <div id='delivery-recap' class="border bg-white mt-2 p-3">
                        <p class="mb-0"><b>Livré à :</b></p>
                        @include('components.utils.addresses.address', ['address' => $cart->shippingAddress])

                        <p class='mb-0 mt-2'><b>Facturé à :</b></p>
                        @include('components.utils.addresses.address', ['address' => $cart->billingAddress])
                    </div>
                    @endif

                    {{-- Price left before free shipping --}}
                    @if($cart->priceLeftBeforeFreeShipping > 0)
                    <div id="price-recap" class="border mt-2 bg-white p-3">
                        <p class="mb-0">Plus que {{ \App\NumberConvertor::doubleToPrice($cart->priceLeftBeforeFreeShipping) }} pour profiter de
                            la livraison gratuite.</p>
                    </div>
                    @endif

                    {{-- Cart sharing --}}
                    <div id="sharing-container" class="border mt-2 bg-white p-3">
                        <p>Vous pouvez partager votre panier avec ce lien : </p>
                        <p class='mb-0 font-weight-bold'>https://bebes-lutins.fr/panier/{{$cart->id}}</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $("body").on("cartCommentAdded", function(e, textarea) {
        textarea.parent('.loading-textarea-container').removeClass('running');
        $('.next-button-container').removeClass('running');
        console.log(textarea);
    });

    $(document).ready(function(){
        $('#cheque-infos-container').hide();

        $('#cheque-infos-display-btn').on('click', function(){
            $('#cheque-infos-container').toggle();
        });


    });

    function addCartComment(cartId, textarea) {
        textarea.parent('.loading-textarea-container').addClass('running');
        $('.next-button-container').addClass('running');

        comment = textarea.val();
        if ('' === comment) {
            comment = null;
        }

        console.log(cartId);
        console.log(comment);

        fetch("{{ route('api.cart.comment.add') }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                cartId: cartId,
                comment: comment,
            })
        })
        .then(response => response.json())
        .then(response => {
            if (undefined !== response.errors){
                throw response.errors;
            }

            console.log(response);
            $('body').trigger('cartCommentAdded', [textarea]);
        }).catch((errors) => {
            console.error(errors);
        });
    }
</script>

<script>
    changedInput = $('.cart-item-quantity');

    changedInput.on("change", function (event) {
        let firstSpinnerParent = $(this).parent('.spinner-container');

        firstSpinnerParent.addClass('running');

        let itemContainer = firstSpinnerParent.parent().parent();
        let itemTotalPrice = itemContainer.find('.item-total-price');
        let orderItemId = firstSpinnerParent.data('itemid');
        let oldQuantity = firstSpinnerParent.data('oldquantity');
        let newQuantity = $(this).val();

        let diff = newQuantity - oldQuantity;

        if (!isNaN(diff)) {
            let price = firstSpinnerParent.data('price');
            itemTotalPrice.text(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(price * newQuantity));

            fetch("/api/cart_item/" + orderItemId + "/quantity/update", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    quantity: newQuantity,
                })
            })
            .then(response => response.json())
            .then(response => {
                if (undefined !== response.errors){
                    throw response.errors;
                }

                $('body').trigger('cartItemQuantityChanged', [price, diff]);
                location.reload();
            }).catch((errors) => {
                password.addClass('is-invalid');
                errors.password.forEach(message => {
                    password.after(errorFeedbackHtml.replace('__error__', message));
                });
            });
        }

        firstSpinnerParent.data('oldquantity', newQuantity);
    })
</script>

<script>
    $("body").on("cartItemQuantityChanged", function(e, price, quantity) {
        let totalQuantity = $('#price-recap .total-quantity');
        let shippingCosts = $('#price-recap .total-shipping-costs');
        let total = $('#price-recap .total');

        totalQuantity.text(cartQuantity + ' produits : ' + cartPriceFormatted);

        if (FREE_SHIPPING_FROM > cartPrice) {
            shippingCosts.text('Frais de ports : ' + new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(SHIPPING_COSTS));
            totalTaxedPrice = cartPrice + SHIPPING_COSTS;
        } else {
            shippingCosts.text('Frais de ports : 0,00 €')
            totalTaxedPrice = cartPrice + 0;
        }

        total.text('TOTAL T.T.C. : ' + new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(totalTaxedPrice));
    });
</script>

<script>
    $(document).ready(function(){
        $('#new-shipping-address').show();

        if ($('#sameAddresses').attr('checked')) {
            $('#new-shipping-address').hide();
            $('#shipping').hide();
        } else {
            $('#new-shipping-address').show();
            $('#shipping').show();
        }

        @auth
        @if (0 < Auth::user()->addresses->count())
            $('#new-billing-address').hide();
        @endif
        @endauth

        newBillingAddressBtn = $('#new-billing-address-btn');

        newBillingAddressBtn.on('click', function(){
            $('#billing-address-select').toggle();
            $('#new-billing-address').toggle();

            if ( newBillingAddressBtn.hasClass('activated') ){
                newBillingAddressBtn.text('Ou créez en une nouvelle');
                newBillingAddressBtn.removeClass('activated')
                $('#is-new-billing-address').val('0');
            } else {
                newBillingAddressBtn.text('Selectionner une de vos adresses');
                newBillingAddressBtn.addClass('activated')
                $('#is-new-billing-address').val('1');
            }
        });

        newShippingAddressBtn = $('#new-shipping-address-btn');

        newShippingAddressBtn.on('click', function(){
            $('#shipping-address-select').toggle();
            $('#new-shipping-address').toggle();

            if ( newShippingAddressBtn.hasClass('activated') ){
                newShippingAddressBtn.text('Ou créez en une nouvelle');
                newShippingAddressBtn.removeClass('activated')
                $('#is-new-shipping-address').val('0');
            } else {
                newShippingAddressBtn.text('Selectionner une de vos adresses');
                newShippingAddressBtn.addClass('activated')
                $('#is-new-shipping-address').val('1');
            }
        });
    });
</script>
@endsection
