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
                    <div id="payment-form" class="border bg-white p-3 d-flex flex-column">
                        <a name="credit-card-payment-btn" id="credit-card-payment-btn" class="btn btn-primary rounded-0" href="#" role="button">
                            Payer par carte bancaire</a>

                        <div class="separator my-3 border-top border-bottom">

                        </div>
                        <button id="cheque-infos-display-btn" type="button" class="btn btn-primary rounded-0">
                            Payer par chèque bancaire</button>

                        <div id='cheque-infos-container' class='p-3 border my-2'>
                            <p class="mb-0">Merci d'établir votre chèque à l'ordre de : <b>ACTYPOLES</b>.<BR>
                                <BR>
                                Le paiement est à nous faire parvenir à :<BR>
                                Actypoles / Bébés Lutins<BR>
                                4, rue du 19 mars 1962<BR>
                                63300 THIERS<BR>
                                <BR>
                                Montant de votre commande : <b>{{ \App\NumberConvertor::doubleToPrice($cartPrice + $shippingCosts) }}</b>.<BR>
                                <BR>
                                Votre commande sera traitée et expédiée à réception de votre chèque.</p>

                            <div class="separator my-3 border-top border-bottom"></div>

                            <a name="cheque-payment-btn" id="cheque-payment-btn" class="btn btn-primary w-100 rounded-0" href="{{ route('order.createFromCart', ['cart' => $cart]) . '?paymentMethod=CHEQUE' }}" role="button">
                                Valider ma commande</a>
                        </div>

                        <small class="mt-2">En cliquant sur les boutons ci-dessus vous acceptez sans réserve les conditions générales de vente.</small>
                    </div>
                </div>

                {{-- CART RECAP --}}
                <div class="col-lg-4 my-2">
                    <div id="price-recap" class="border bg-white p-3">
                        <p class="mb-0">{{ $cart->totalQuantity }} produits : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice) }}</p>
                        <p class="mb-0">Frais de ports : {{ \App\NumberConvertor::doubleToPrice($cart->shippingCosts) }}</p>
                        <p class="mb-0">TOTAL T.T.C. : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice + $cart->shippingCosts) }}</p>
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
<script>
    $(document).ready(function(){
        $('#cheque-infos-container').hide();

        $('#cheque-infos-display-btn').on('click', function(){
            $('#cheque-infos-container').toggle();
        });
    });
</script>
@endsection
