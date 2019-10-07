<?php $shopping_cart = session('shopping_cart'); 
//session()->forget('shopping_cart');

$total_price = 0.00;
$total_quantity = 0;
$shipping_price = 5.90;
$total = 0.00;
$price_before_free_shipping = 70.00;

if(count($shopping_cart->items) > 0){
    foreach ($shopping_cart->items as $item) {
        $total_price += $item->product->price * $item->quantity;

        $total_quantity += $item->quantity;
    }
    $price_before_free_shipping -= $total_price;
}

if($total_price >= 70){
    $shipping_price = 0;
    $price_before_free_shipping = 0.00;
}

$total = $total_price + $shipping_price;

?>

@extends('templates.template')

@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/shopping-cart/index.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading-btn.css')}}">
@endsection

@section('content')
<main id='main-shopping-cart' class='container-fluid dim-background'>
    <div class="row justify-content-center py-3 py-md-4 py-lg-5">
        <div class="col-12">

            {{-- STEPS --}}
            @include('pages.shopping-cart.steps')

            <div class="row justify-content-center">

                {{--  ITEMS  --}}
                <div class="col-12 col-sm-10 col-lg-5 my-md-2 my-lg-0">
                    <div id='delivery-selection' class="card p-0 border-0 rounded-0">
                        <div class="card-header bg-white">
                            <ul id='nav-delivery' class="nav nav-tabs card-header-tabs justify-content-center">
                                @if(Auth::check() && count(Auth::user()->addresses) > 0)
                                <li class="nav-item mx-2">
                                    <a class="nav-link mb-0 noselect" onclick='select_nav_item($(this), $(".savedAddresses"))'>
                                        Vos adresses</a>
                                </li>
                                @endif
                                <li class="nav-item mx-2">
                                    <a class="nav-link mb-0 noselect active" onclick='select_nav_item($(this), $(".newAddress"))'>
                                        Nouvelle adresse</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link mb-0 noselect" onclick='select_nav_item($(this), $(".withdrawalShop"))'>
                                        Retrait à l'atelier</a>
                                </li>
                            </ul>
                        </div>
                        <div id='delivery-choices-container' class='card-body'>

                            @if(Auth::check() && count(Auth::user()->addresses) > 0)
                            <?php $address = Auth::user()->addresses[0]; ?>
                            <div id="savedAddresses" class='delivery-choice savedAddresses d-none'>
                                <p class='h4'>Vos adresses sauvegardées</p>

                                <form action="/panier/livraison/validation" method="POST">
                                    <input type='hidden' value='saved-address'>
                                    <div id='saved-billing-address-container'>
                                        <div id='saved-billing-address' class="form-group">
                                            <label for="billing-address">Choisissez une adresse de facturation</label>
                                            <select class="custom-select" name="billing-address" id="billing-address-selector">
                                                @foreach (Auth::user()->addresses as $select_address)
                                                    <option value='{{$select_address->id}}'>{{$select_address->street}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id='billing-address-summary'>
                                            <p class='identity mb-0'>{{$address->civilityToString()}} {{$address->firstname}} {{$address->lastname}}</p>
                                            <small class='complement'>{{$address->complement}}</small>
                                            <small class='company font-weight-bold'>{{$address->company}}</small>
                                            <p class='street mb-0'>{{$address->street}}</p>
                                            <p class='zipcode-city mb-0'>{{$address->zipCode}}, {{$address->city}}</p>
                                        </div>
                                    </div>

                                    <div class="custom-control custom-checkbox max-content mx-auto my-3 pointer">
                                        <input type="checkbox" class="custom-control-input pointer" id="same-saved-address-checkbox" checked>
                                        <label class="custom-control-label noselect pointer" for="same-saved-address-checkbox">Adresse de livraison identique</label>
                                    </div>

                                    <div id='saved-shipping-address-container'>
                                        <div id='saved-shipping-address' class='form-group'>
                                            <label for="shipping-address">Choisissez une adresse de livraison</label>
                                            <select class="custom-select" name="shipping-address" id="shipping-address-selector">
                                                @foreach (Auth::user()->addresses as $select_address)
                                                    <option value='{{$select_address->id}}'>{{$select_address->street}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id='shipping-address-summary'>
                                            <p class='identity mb-0'>{{$address->civilityToString()}} {{$address->firstname}} {{$address->lastname}}</p>
                                            <small class='complement'>{{$address->complement}}</small>
                                            <small class='company font-weight-bold'>{{$address->company}}</small>
                                            <p class='street mb-0'>{{$address->street}}</p>
                                            <p class='zipcode-city mb-0'>{{$address->zipCode}}, {{$address->city}}</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif

                            <div id="newAddress" class='delivery-choice newAddress'>
                                <form action="/panier/livraison/validation" method="POST">
                                    <input type='hidden' value='new-address'>

                                    {{-- BILLING ADDRESS --}}
                                    <div id='billing-address-container'>
                                        <p class='h4'>Adresse de facturation</p>
                                        <small>Les champs avec un astérisque (*) sont obligatoires.</small>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="civility" class='mb-0'>Civilité *</label>
                                            <select class="custom-select" name="civility-billing" id="civility">
                                                <option value='1'>Monsieur</option>
                                                <option value='2'>Madame</option>
                                                <option value='3'>Non précisé</option>
                                            </select>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group mb-0 mt-2 col-6">
                                                <label for="firstname" class='mb-0'>Prénom *</label>
                                                <input type="text" class="form-control" name="firstname-billing" id="firstname" aria-describedby="helpFirstname" placeholder="Jean">
                                            </div>
                                            <div class="form-group mb-0 mt-2 col-6">
                                                <label for="lastname" class='mb-0'>Nom de famille *</label>
                                                <input type="text" class="form-control" name="lastname-billing" id="lastname" aria-describedby="helpLastname" placeholder="Dupont">
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="street" class='mb-0'>Rue *</label>
                                            <input type="text" class="form-control" name="street-billing" id="street" aria-describedby="helpStreet" placeholder="">
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="zipcode" class='mb-0'>Code postal *</label>
                                            <input type="text" class="form-control" name="zipcode-billing" id="zipcode" aria-describedby="helpZipcode" placeholder="63300" minlength="5" maxlength="5">
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="city" class="mb-0">Ville *</label>
                                            <input type="text" class="form-control" name="city-billing" id="city" aria-describedby="helpCity" placeholder="Thiers">
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="complements" class="mb-0">Compléments</label>
                                            <input type="text" class="form-control" name="complements-billing" id="complements" aria-describedby="helpComplements" placeholder="">
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="company" class="mb-0">Entreprise</label>
                                            <input type="text" class="form-control" name="company-billing" id="company" aria-describedby="helpCompany" placeholder="">
                                        </div>
                                    </div>

                                    <div class="custom-control custom-checkbox max-content mx-auto my-3 pointer">
                                        <input type="checkbox" class="custom-control-input pointer" id="same-address-checkbox" checked>
                                        <label class="custom-control-label noselect pointer" for="same-address-checkbox">Adresse de livraison identique</label>
                                    </div>

                                    {{-- SHIPPING ADDRESS --}}
                                    <div id='shipping-address-container'>
                                        <p class='h4'>Adresse de livraison</p>
                                        <small>Les champs avec un astérisque (*) sont obligatoires.</small>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="civility" class='mb-0'>Civilité *</label>
                                            <select class="custom-select" name="civility-shipping" id="civility">
                                                <option value='1'>Monsieur</option>
                                                <option value='2'>Madame</option>
                                                <option value='3'>Non précisé</option>
                                            </select>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group mb-0 mt-2 col-6">
                                                <label for="firstname" class='mb-0'>Prénom *</label>
                                                <input type="text" class="form-control" name="firstname-shipping" id="firstname" aria-describedby="helpFirstname" placeholder="Jean">
                                            </div>
                                            <div class="form-group mb-0 mt-2 col-6">
                                                <label for="lastname" class='mb-0'>Nom de famille *</label>
                                                <input type="text" class="form-control" name="lastname-shipping" id="lastname" aria-describedby="helpLastname" placeholder="Dupont">
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="street" class='mb-0'>Rue *</label>
                                            <input type="text" class="form-control" name="street-shipping" id="street" aria-describedby="helpStreet" placeholder="">
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="zipcode" class='mb-0'>Code postal *</label>
                                            <input type="text" class="form-control" name="zipcode-shipping" id="zipcode" aria-describedby="helpZipcode" placeholder="63300" minlength="5" maxlength="5">
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="city" class="mb-0">Ville *</label>
                                            <input type="text" class="form-control" name="city-shipping" id="city" aria-describedby="helpCity" placeholder="Thiers">
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="complements" class="mb-0">Compléments</label>
                                            <input type="text" class="form-control" name="complements-shipping" id="complements" aria-describedby="helpComplements" placeholder="">
                                        </div>
                                        <div class="form-group mb-0 mt-2">
                                            <label for="company" class="mb-0">Entreprise</label>
                                            <input type="text" class="form-control" name="company-shipping" id="company" aria-describedby="helpCompany" placeholder="">
                                        </div>
                                    </div>

                                </form>
                            </div>
                            
                            <div id="withdrawalShop" class='delivery-choice withdrawalShop d-none'>
                                <p class='h4'>Retrait à l'atelier</p>
                                <small>Les champs avec un astérisque (*) sont obligatoires.</small>
                                <p class='small'>
                                    Une fois votre commande prête, nous vous envoyons un mail (et un SMS si vous 
                                    indiquez votre numéro de téléphone) pour vous prévenir. Vous pourrez venir retirer 
                                    votre commande à notre atelier de 9h00 à 12h00 et de 13h30 à 17h00, du lundi au vendredi.
                                </p>
                                <p class='small'>
                                    Adresse de l'atelier :<BR>
                                    ACTYPOLES (Bébés Lutins)<BR>
                                    Rue du 19 Mars 1962<BR>
                                    63300 THIERS
                                </p>
                                <form action="/panier/livraison/validation" method="POST">
                                    <input type='hidden' value='withdrawal-shop'>
                                    <div class="form-group mb-0 mt-2">
                                        <label for="email" class='mb-0'>Adresse email *</label>
                                        <input type="email" class="form-control" name="email" id="email" aria-describedby="helpEmail" placeholder="jeandupont@gmail.com">
                                        <small id="helpEmail" class="form-text text-muted">Votre adresse email</small>
                                    </div>
                                    <div class="form-group mb-0 mt-2">
                                        <label for="phone" class="mb-0">Numéro de téléphone</label>
                                        <input type="phone" class="form-control" name="phone" id="phone" aria-describedby="helpPhone" placeholder="0123456789">
                                        <small id="helpPhone" class="form-text text-muted">Votre numéro de téléphone</small>
                                    </div>
                                    <div class="form-group mb-0 mt-2">
                                        <label for="civility" class='mb-0'>Civilité *</label>
                                        <select class="custom-select" name="civility-billing" id="civility">
                                            <option value='1'>Monsieur</option>
                                            <option value='2'>Madame</option>
                                            <option value='3'>Non précisé</option>
                                        </select>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group mb-0 mt-2 col-6">
                                            <label for="firstname" class='mb-0'>Prénom *</label>
                                            <input type="text" class="form-control" name="firstname-billing" id="firstname" aria-describedby="helpFirstname" placeholder="Jean">
                                        </div>
                                        <div class="form-group mb-0 mt-2 col-6">
                                            <label for="lastname" class='mb-0'>Nom de famille *</label>
                                            <input type="text" class="form-control" name="lastname-billing" id="lastname" aria-describedby="helpLastname" placeholder="Dupont">
                                        </div>
                                    </div>
                                    <p class='h4 mt-4'>Adresse de facturation</p>
                                    <div class="form-group mb-0 mt-2">
                                        <label for="street" class='mb-0'>Rue *</label>
                                        <input type="text" class="form-control" name="street-billing" id="street" aria-describedby="helpStreet" placeholder="">
                                    </div>
                                    <div class="form-group mb-0 mt-2">
                                        <label for="zipcode" class='mb-0'>Code postal *</label>
                                        <input type="text" class="form-control" name="zipcode-billing" id="zipcode" aria-describedby="helpZipcode" placeholder="63300" minlength="5" maxlength="5">
                                    </div>
                                    <div class="form-group mb-0 mt-2">
                                        <label for="city" class="mb-0">Ville *</label>
                                        <input type="text" class="form-control" name="city-billing" id="city" aria-describedby="helpCity" placeholder="Thiers">
                                    </div>
                                    <div class="form-group mb-0 mt-2">
                                        <label for="complements" class="mb-0">Compléments</label>
                                        <input type="text" class="form-control" name="complements-billing" id="complements" aria-describedby="helpComplements" placeholder="">
                                    </div>
                                    <div class="form-group mb-0 mt-2">
                                        <label for="company" class="mb-0">Entreprise</label>
                                        <input type="text" class="form-control" name="company-billing" id="company" aria-describedby="helpCompany" placeholder="">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                {{--  SUMMARY AND OTHERS  --}}
                <div class="col-12 col-sm-10 col-lg-3">
                    <div class="row">

                        {{--  Summary  --}}
                        <div class="col-12 my-2 my-lg-0 mb-lg-2 order-1 order-lg-0">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-header bg-white">
                                    <h1 class='h5 mb-0'>Résumé</h1>
                                </div>
                                <div class="card-body row justify-content-center m-0">
                                    <div class="col-6 p-0">
                                        <p class="card-text">{{$total_quantity}} produits :</p>
                                    </div>
                                    <div class="col-6 p-0">
                                        <p class="card-text text-right">{{number_format($total_price, 2)}} €</p>
                                    </div>
                
                                    <div class="col-6 p-0">
                                        <p class="card-text">Frais de ports :</p>
                                    </div>
                                    <div class="col-6 p-0">
                                        <p class="card-text text-right">{{number_format($shipping_price, 2)}} €</p>
                                    </div>
                
                                    <div class="col-6 p-0">
                                        <p class="card-text font-weight-bold">TOTAL TTC :</p>
                                    </div>
                                    <div class="col-6 p-0">
                                        <p class="card-text text-right font-weight-bold">{{number_format($total, 2)}} €</p>
                                    </div>
                
                                    <div class="col-12 border-bottom my-4"></div>
                
                                    <div class="col-12 col-md-6 col-lg-12 mb-2" style='line-height:0;'>
                                        <small class="small" style="line-height:1rem;">En cliquant sur ce bouton vous acceptez sans 
                                        réserve les conditions générales de vente.</small>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <button type="button" class="btn btn-primary w-100">Valider mon panier</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--  Voucher code  --}}
                        @if($shopping_cart->voucher != null)
                        <div class="col-12 my-2 my-lg-2 order-0 order-lg-1">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-header bg-white">
                                    <h1 class='h5 mb-0'>Réductions</h1>
                                </div>
                                <div class="card-body row m-0">
                                    @if ($shopping_cart->voucher == null)
                                    <form action="/panier/code-coupon/ajout" method="POST" class='w-100'>
                                        @csrf
                                        <div class="form-group">
                                            @error('voucher-code')
                                            <div class="row m-0 p-0">
                                                Le code n'existe pas.
                                            </div>
                                            @enderror
                                            <label for="voucher-code">Code coupon : </label>
                                            <div class="row m-0 p-0">
                                                <div class="col-8 p-0 pr-2">
                                                    <input type="text" class="form-control" name="voucher-code" id="voucher-code" aria-describedby="helpVoucher" placeholder="">
                                                </div>
                                                <div class="col-4 p-0">
                                                    <button type="submit" class="btn btn-light w-100">Ajouter</button>
                                                </div> 
                                            </div>
                                            <small id="helpVoucher" class="form-text text-muted">Tapez ici votre code de réduction (si vous en avez un)</small>
                                        </div>
                                    </form>
                                    @else
                                    <form action="/panier/code-coupon/suppression" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="voucher-code">Code coupon : </label>
                                            <div class="row m-0 p-0">
                                                <div class="col-8 p-0 pr-2">
                                                    <input type="text" class="form-control" name="voucher-code" id="voucher-code" aria-describedby="helpVoucher" placeholder="" disabled>
                                                </div>
                                                <div class="col-4 p-0">
                                                    <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                                                </div> 
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        @endif

                        {{--  Products summary  --}}
                        <div class="col-12 my-2 my-lg-0 mb-lg-2 order-1 order-lg-0">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-header bg-white">
                                    <h1 class='h5 mb-0'>{{$total_quantity}} articles</h1>
                                </div>
                                <div class="card-body">
                                    @foreach ($shopping_cart->items as $item)
                                    <div class='product row m-0 mb-2' style='font-size:0.7rem;'>
                                        <div class="col-3 p-0" style='max-height:4rem;'>
                                            <img class='w-100 h-100' src='{{asset('/images/products/' . $item->product->mainImage)}}' style='object-fit:cover;'>
                                        </div>
                                        <div class="col-9 d-flex flex-column">
                                            <a href='/produits/{{$item->product->id}}' class='mb-0 item-name-cropped text-dark'>{{$item->product->name}}</a>
                                            <p>{{number_format($item->product->price, 2)}} € x {{$item->quantity}} = <b>{{number_format($item->product->price * $item->quantity, 2)}} €</b></p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- Tabs selection changed --}}
<script>
    function select_nav_item(item, contentToShow){
        $('#nav-delivery').children('li').children('a').removeClass('active');
        item.addClass('active');
        $('.delivery-choice').addClass('d-none');
        contentToShow.removeClass('d-none');
    }
</script>

{{-- Check same shipping address --}}
<script>
    $('#shipping-address-container').hide();
    $("#same-address-checkbox").change(function() {
        if(this.checked) {
            $('#shipping-address-container').hide();
        } else $('#shipping-address-container').show();
    });

    $('#saved-shipping-address-container').hide();
    $('#same-saved-address-checkbox').change(function(){
        if(this.checked) {
            $('#saved-shipping-address-container').hide();
        } else $('#saved-shipping-address-container').show();
    });

</script>

@if(Auth::check() && count(Auth::user()->addresses) > 0)
{{-- Choose saved address--}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#billing-address-selector').on('change', function() {
        address_id = this.value;
        billing_address_summary = $('#billing-address-summary');

        $.ajax({
            url: "/addresses/" + address_id,
            type: 'POST',
            data: { },
            success: function(data){
                var json = $.parseJSON(data);
                address = json.address;
                billing_address_summary.children('.identity').text(
                    address.civility + ' ' + address.firstname + ' ' + address.lastname
                );
                billing_address_summary.children('.complement').text(address.complement);
                billing_address_summary.children('.company').text(address.company);
                billing_address_summary.children('.street').text(address.street);
                billing_address_summary.children('.zipcode-city').text(address.zipcode + ' ' + address.city);

            },
            beforeSend: function() {
                //btn.addClass('running');
            }
        })
    });

    $('#shipping-address-selector').on('change', function() {
        address_id = this.value;
        shipping_address_summary = $('#shipping-address-summary');

        $.ajax({
            url: "/addresses/" + address_id,
            type: 'POST',
            data: { },
            success: function(data){
                var json = $.parseJSON(data);
                address = json.address;
                shipping_address_summary.children('.identity').text(
                    address.civility + ' ' + address.firstname + ' ' + address.lastname
                );
                shipping_address_summary.children('.complement').text(address.complement);
                shipping_address_summary.children('.company').text(address.company);
                shipping_address_summary.children('.street').text(address.street);
                shipping_address_summary.children('.zipcode-city').text(address.zipcode + ' ' + address.city);

            },
            beforeSend: function() {
                //btn.addClass('running');
            }
        })
    });
</script>
@endif

{{--  Reduce product title  --}}
<script>
    function textAbstract(el, maxlength = 20, delimiter = " ") {
        let txt = $(el).text();
        if (el == null) {
            return "";
        }
        if (txt.length <= maxlength) {
            return txt;
        }
        let t = txt.substring(0, maxlength);
        let re = /\s+\S*$/;
        let m = re.exec(t);
        t = t.substring(0, m.index);
        return t + "...";
    }

    var maxlengthwanted = 50;

    $('.item-name-cropped').each(function(index, element) {
        $(element).text(textAbstract(element, maxlengthwanted, " "));
    });
</script>

@endsection