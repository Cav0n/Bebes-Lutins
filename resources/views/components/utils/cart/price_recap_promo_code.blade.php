{{-- HT PRICE --}}
<p class="mb-0 total-quantity">
    {{ $cart->totalQuantity }} produits :
    @if($cart->promoCode->discountType === 'PERCENT' || $cart->promoCode->discountType === 'PRICE')
        <del>{{ \App\NumberConvertor::doubleToPrice($cart->totalPrice) }}</del> {{ \App\NumberConvertor::doubleToPrice($cart->totalPriceWithPromo) }}
    @else
        {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice) }}
    @endif
</p>

{{-- SHIPPING COSTS --}}
<p class="mb-0 total-shipping-costs">
    Frais de ports :
    @if($cart->promoCode->discountType === 'FREE_SHIPPING_COSTS')
        <del>{{ \App\NumberConvertor::doubleToPrice($cart->shippingCosts) }}</del> 0.00 €
    @else {{ \App\NumberConvertor::doubleToPrice($cart->shippingCosts) }} @endif
</p>

{{-- TTC PRICE --}}
<p class="mb-0 total">T
    OTAL T.T.C. : {{ \App\NumberConvertor::doubleToPrice($cart->totalPriceTTCWithPromo) }}
</p>
