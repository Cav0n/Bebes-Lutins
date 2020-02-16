@extends('templates.default')

@section('title', "Mon panier | Paiement - Bébés Lutins")

@section('content')

@php
    $cart = Session::get('shopping_cart');

    $cartQuantity = $cart->totalQuantity;
    $cartPrice = $cart->totalPrice;
    $shippingCosts = $cart->shippingCosts;
@endphp

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="font-weight-bold">Paiement</h1>
            <div class="row m-0">

                {{-- PAYMENT SELECTION --}}
                <div class="col-lg-8 my-2 p-0">
                    <form id="payment-form" action="{{ route('cart.delivery.validation') }}" method="POST" class="border bg-white p-3">
                        @csrf
                        <div class="form-group">
                            <label for="payment_select">Méthode de paiement</label>
                            <select id="payment_select" class="custom-select" name="paymentSelect">
                                <option>Carte bancaire</option>
                                <option>Chèque bancaire</option>
                            </select>
                        </div>
                    </form>
                </div>

                {{-- CART RECAP --}}
                <div class="col-lg-4 my-2">
                    <div id="price-recap" class="border bg-white p-3">
                        <p class="mb-0">{{ $cart->totalQuantity }} produits : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice) }}</p>
                        <p class="mb-0">Frais de ports : {{ \App\NumberConvertor::doubleToPrice($cart->shippingCosts) }}</p>
                        <p class="mb-0">TOTAL T.T.C. : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice + $cart->shippingCosts) }}</p>
                        <button class="btn btn-primary w-100 rounded-0 mt-2" role="submit" form="new-address-form">Payer</button>
                    </div>

                    @if($cart->priceLeftBeforeFreeShipping > 0)
                    <div id="price-recap" class="border mt-2 bg-white p-3">
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
    </div>
</div>

@endsection

@section('scripts')
    $(document).ready(function(){
        $('#delivery-choice').hide();

        $('#sameAddresses').on('click', function(){
            $('#delivery-choice').toggle()
        });
    });
@endsection
