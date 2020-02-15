@extends('templates.default')

@section('title', "Mon panier | Livraison - Bébés Lutins")

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
            <h1 class="font-weight-bold">Livraison</h1>
            <div class="row m-0">

                {{-- ITEMS LIST --}}
                <form id="new-address-form" action="{{ route('cart.delivery.validation') }}" method="POST" class="col-lg-8 my-2 border bg-white p-3">
                    @csrf
                    <div id="billing-choice">
                        <h2>Facturation</h2>
                        <div class="form-group">
                            <label for="civility">Civilité</label>
                            <select id="civility" class="form-control" name="billing[civility]">
                                <option>Madame</option>
                                <option>Monsieur</option>
                                <option>Non précisé</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control" name="billing[firstname]" id="firstname" aria-describedby="helpFirstname">
                                <small id="helpFirstname" class="form-text text-muted">Votre prénom</small>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="lastname">Nom de famille</label>
                                <input type="text" class="form-control" name="billing[lastname]" id="lastname" aria-describedby="helpLastname">
                                <small id="helpLastname" class="form-text text-muted">Votre nom de famille</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="street">Rue</label>
                            <input type="text" class="form-control" name="billing[street]" id="street" aria-describedby="helpStreet">
                            <small id="helpStreet" class="form-text text-muted">Le numéro et la rue de votre logement.</small>
                        </div>
                        <div class="form-group">
                            <label for="complements">Compléments</label>
                            <input type="text" class="form-control" name="billing[complements]" id="complements" aria-describedby="helpComplements">
                            <small id="helpComplements" class="form-text text-muted">Compléments d'adresse (numéro d'appartement, résidence...)</small>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="zipCode">Code postal</label>
                                <input type="text" class="form-control" name="billing[zipCode]" id="zipCode" aria-describedby="helpZipCode" maxlength="5">
                                <small id="helpZipCode" class="form-text text-muted">Le code postal</small>
                            </div>
                            <div class="form-group col-lg-8">
                                <label for="city">Ville</label>
                                <input type="text" class="form-control" name="billing[city]" id="city" aria-describedby="helpCity">
                                <small id="helpCity" class="form-text text-muted">La ville</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company">Entreprise</label>
                            <input type="text" class="form-control" name="billing[company]" id="company" aria-describedby="helpCompany">
                            <small id="helpCompany" class="form-text text-muted">Le nom de l'entreprise à laquelle livrer</small>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="sameAddresses" id="sameAddresses" checked="checked"> Adresse du livraison identique
                            </label>
                        </div>
                    </div>

                    <div id="delivery-choice">
                        <div class="form-group">
                            <h2>Livraison</h2>
                            <label for="civility">Civilité</label>
                            <select id="civility" class="form-control" name="shipping[civility]">
                                <option>Madame</option>
                                <option>Monsieur</option>
                                <option>Non précisé</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control" name="shipping[firstname]" id="firstname" aria-describedby="helpFirstname">
                                <small id="helpFirstname" class="form-text text-muted">Votre prénom</small>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="lastname">Nom de famille</label>
                                <input type="text" class="form-control" name="shipping[lastname]" id="lastname" aria-describedby="helpLastname">
                                <small id="helpLastname" class="form-text text-muted">Votre nom de famille</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="street">Rue</label>
                            <input type="text" class="form-control" name="shipping[street]" id="street" aria-describedby="helpStreet">
                            <small id="helpStreet" class="form-text text-muted">Le numéro et la rue de votre logement.</small>
                        </div>
                        <div class="form-group">
                            <label for="complements">Compléments</label>
                            <input type="text" class="form-control" name="shipping[complements]" id="complements" aria-describedby="helpComplements">
                            <small id="helpComplements" class="form-text text-muted">Compléments d'adresse (numéro d'appartement, résidence...)</small>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="zipCode">Code postal</label>
                                <input type="text" class="form-control" name="shipping[zipCode]" id="zipCode" aria-describedby="helpZipCode" maxlength="5">
                                <small id="helpZipCode" class="form-text text-muted">Le code postal</small>
                            </div>
                            <div class="form-group col-lg-8">
                                <label for="city">Ville</label>
                                <input type="text" class="form-control" name="shipping[city]" id="city" aria-describedby="helpCity">
                                <small id="helpCity" class="form-text text-muted">La ville</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company">Entreprise</label>
                            <input type="text" class="form-control" name="shipping[company]" id="company" aria-describedby="helpCompany">
                            <small id="helpCompany" class="form-text text-muted">Le nom de l'entreprise à laquelle livrer</small>
                        </div>
                    </div>
                </form>

                {{-- CART RECAP --}}
                <div class="col-lg-4 my-2">
                    <div id="price-recap" class="border bg-white p-3">
                        <p class="mb-0">{{ $cart->totalQuantity }} produits : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice) }}</p>
                        <p class="mb-0">Frais de ports : {{ \App\NumberConvertor::doubleToPrice($cart->shippingCosts) }}</p>
                        <p class="mb-0">TOTAL T.T.C. : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice + $cart->shippingCosts) }}</p>
                        <button class="btn btn-primary" role="submit" form="new-address-form">Passer au paiement</button>
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
