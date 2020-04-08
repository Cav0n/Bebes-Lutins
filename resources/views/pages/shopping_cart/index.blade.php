@extends('templates.default')

@section('title', "Mon panier - Bébés Lutins")

@section('optional_css')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css"/>
@endsection

@section('content')

@php
    $cart = Session::get('shopping_cart');

    $cartQuantity = $cart->totalQuantity;
    $cartPrice = $cart->totalPrice;
    $shippingCosts = $cart->shippingCosts;
@endphp

<div id="cart" class="container-fluid py-5">
    <div class="row justify-content-center">

        @if($cart->items->isEmpty())

            <div class="empty-cart-container px-3 border bg-white text-center py-5">
                <h1 class="font-weight-bold">Votre panier semble bien vide 😪</h1>
                <a name="add-some-products" id="add-some-products" class="btn btn-outline-primary rounded-0" href="/" role="button">Ajoutez quelques produits !</a>
            </div>

        @else

        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">
            @include('components.utils.cart.steps')

            <h1 class="font-weight-bold">Mon panier - {{$cartQuantity}} produits</h1>
            <div class="row">

                {{-- ITEMS LIST --}}
                <div class="col-lg-8">
                    @foreach ($cart->items as $item)
                    @include('components.utils.cart.item')
                    @endforeach
                </div>

                {{-- CART RECAP --}}
                <div class="col-md-4 pr-0 pl-0 pl-md-2 my-2">
                    <div id="price-recap" class="border bg-white p-3">
                        <p class="mb-0 total-quantity">{{ $cart->totalQuantity }} produits : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice) }}</p>
                        <p class="mb-0 total-shipping-costs">Frais de ports : {{ \App\NumberConvertor::doubleToPrice($cart->shippingCosts) }}</p>
                        <p class="mb-0 total">TOTAL T.T.C. : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice + $cart->shippingCosts) }}</p>
                        <a class="btn btn-primary w-100 rounded-0 mt-2" href="/panier/livraison" role="button">Valider mon panier</a>
                    </div>

                    @if($cart->priceLeftBeforeFreeShipping > 0)
                    <div id="price-left" class="border mt-2 bg-white p-3">
                        <p class="mb-0">Plus que {{ \App\NumberConvertor::doubleToPrice($cart->priceLeftBeforeFreeShipping) }} pour profiter de
                            la livraison gratuite.</p>
                    </div>
                    @endif

                    <div id="sharing-container" class="border mt-2 bg-white p-3">
                        <p>Vous pouvez partager votre panier avec ce lien : </p>
                        <p class='mb-0 font-weight-bold'>https://bebes-lutins.fr/panier/{{$cart->id}}</p>
                    </div>
                </div>
            </div>
        </div>

        @endif

    </div>
</div>

@endsection

@section('scripts')
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
@endsection
