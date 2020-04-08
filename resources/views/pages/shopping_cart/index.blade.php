@extends('templates.cart')

@section('cart.title', 'Mon panier')

@section('cart.content')
{{-- ITEMS LIST --}}
<div class="@if (0 < $cartStep) col-12 col-md-8 my-0 @else col-12 my-2 @endif pl-0 pr-2">

    @if($cart->items->isEmpty())

        <div class="empty-cart-container px-3 border bg-white text-center py-5">
            <h1 class="font-weight-bold">Votre panier semble bien vide 😪</h1>
            <a name="add-some-products" id="add-some-products" class="btn btn-outline-primary rounded-0" href="/" role="button">Ajoutez quelques produits !</a>
        </div>

    @else

        @foreach ($cart->items as $item)
        @include('components.utils.cart.item')
        @endforeach

    @endif

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
