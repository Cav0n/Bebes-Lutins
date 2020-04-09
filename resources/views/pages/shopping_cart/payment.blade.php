@extends('templates.cart')

@section('cart.title', "Paiement")

@section('cart.content')
    {{-- PAYMENT SELECTION --}}
    <div class="col-12 p-0">
        <div id="payment-form" class="border bg-white p-3 d-flex flex-column">
            <div class="next-button-container ld-over">
                <a name="credit-card-payment-btn" id="credit-card-payment-btn" class="btn btn-primary rounded-0 w-100" href="#" role="button">
                    Payer par carte bancaire</a>
                <div class="ld ld-ring ld-spin"></div>
            </div>

            <div class="separator my-3 border-top border-bottom">

            </div>
            <div class="next-button-container ld-over">
                <button id="cheque-infos-display-btn" type="button" class="btn btn-primary rounded-0 w-100">
                    Payer par chèque bancaire</button>
                <div class="ld ld-ring ld-spin"></div>
            </div>

            <div id='cheque-infos-container' class='p-3 border my-2'>
                <p class="mb-0">Merci d'établir votre chèque à l'ordre de : <b>ACTYPOLES</b>.<BR>
                    <BR>
                    Le paiement est à nous faire parvenir à :<BR>
                    Actypoles / Bébés Lutins<BR>
                    4, rue du 19 mars 1962<BR>
                    63300 THIERS<BR>
                    <BR>
                    Montant de votre commande : <b>{{ \App\NumberConvertor::doubleToPrice($cart->totalPrice + $cart->shippingCosts) }}</b>.<BR>
                    <BR>
                    Votre commande sera traitée et expédiée à réception de votre chèque.</p>

                <div class="separator my-3 border-top border-bottom"></div>

                <div class="next-button-container ld-over">
                    <a name="cheque-payment-btn" id="cheque-payment-btn" class="btn btn-primary w-100 rounded-0" href="{{ route('order.createFromCart', ['cart' => $cart]) . '?paymentMethod=CHEQUE' }}" role="button">
                        Valider ma commande</a>
                    <div class="ld ld-ring ld-spin"></div>
                </div>
            </div>

            <small class="mt-2">En cliquant sur les boutons ci-dessus vous acceptez sans réserve les conditions générales de vente.</small>
        </div>
    </div>

@endsection
