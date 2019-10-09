<?php 
    $pricesAndQuantities = $shoppingCart->calculatePricesAndQuantities();
    
    $products_price = $pricesAndQuantities['products_price'];
    $shipping_price = $pricesAndQuantities['shipping_price'];
    $total_quantity = $pricesAndQuantities['total_quantity'];
    $total = $products_price + $shipping_price;
    if($products_price < 70) $price_before_free_shipping = 70 - $products_price;
    else $price_before_free_shipping = 0;

    $has_addresses = Auth::check() && count(Auth::user()->addresses) > 0;
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

            {{-- Errors --}}
            @if (session()->has('delivery-error'))
            <div class="row m-0 justify-content-center">
                <div class="col-lg-8">
                    <div class="alert alert-danger">
                        <p class='mb-0'>{{ session('delivery-error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
            <div class="row m-0 justify-content-center">
                <div class="col-lg-8">
                    <div class="alert alert-danger">
                        <ul class='mb-0'>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>  
            </div>
            @endif

            <div class="row justify-content-center">

                {{--  ITEMS  --}}
                <div class="col-12 col-sm-10 col-lg-5 my-md-2 my-lg-0">
                    <div id='paiement-selection' class="card p-0 border-0 rounded-0">
                        <div class="card-header bg-white">

                            Paiement
                            
                        </div>
                        <div id='delivery-choices-container' class='card-body d-flex flex-column'>
                            <div class='d-flex w-100'>
                                <button type="button" class="btn btn-primary w-100 d-flex rounded-0" onclick='load_url("/panier/paiement/carte-bancaire")'>
                                    <div class='svg-container' style='height:3rem;width:3rem;'>
                                        <img class='svg h-100 w-100' src='{{asset('images/icons/credit-card.svg')}}'>
                                    </div>
                                    <p class='my-auto ml-3'>Payer par carte bancaire ></p>
                                </button>
                            </div>
                            <div class='w-100 border-top my-4'></div>
                            <div class='d-flex flex-column w-100'>
                                <button type="button" class="btn btn-primary w-100 d-flex rounded-0" onclick='display_cheque_payment()'>
                                    <div class='svg-container' style='height:3rem;width:3rem;'>
                                        <img class='svg h-100 w-100' src='{{asset('images/icons/bank-cheque.svg')}}'>
                                    </div>
                                    <p class='my-auto ml-3'>Payer par chèque bancaire ></p>
                                </button>
                                <div id='cheque-payment' class='my-3 p-4 border'>
                                    <p class='mb-0'>
                                        Merci d'établir votre chèque à l'ordre de : <b>ACTYPOLES.</b><BR>
                                        <BR>
                                        Le paiement est à nous faire parvenir à :<BR>
                                        Actypoles / Bébés Lutins<BR>
                                        4, rue du 19 mars 1962<BR>
                                        63300 THIERS<BR>
                                        <BR>
                                        Montant de votre commande : <b>{{number_format($total, 2)}} €.</b><BR>
                                        <BR>
                                        Votre commande sera traitée et expédiée à réception de votre chèque.</p>
                                    <div class='w-100 border-top my-4'></div>
                                    <button type="button" class="btn btn-primary rounded-0 w-100" onclick='load_url("/panier/paiement/validation/cheque")'>Valider ma commande</button>
                                </div>
                            </div>
                            <div class='w-100 border-top my-4'></div>
                            <div class='d-flex w-100'>
                                <small>En cliquant sur les boutons ci-dessus vous acceptez sans réserve les conditions générales de vente.</small>
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
                                        <p class="card-text text-right">{{number_format($products_price, 2)}} €</p>
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
                                </div>
                            </div>
                        </div>

                        {{--  Voucher code  --}}
                        @if($shoppingCart->voucher != null)
                        <div class="col-12 my-2 my-lg-2 order-0 order-lg-1">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-header bg-white">
                                    <h1 class='h5 mb-0'>Réductions</h1>
                                </div>
                                <div class="card-body row m-0">
                                    @if ($shoppingCart->voucher == null)
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
                                    @foreach ($shoppingCart->items as $item)
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

                        {{-- Addresses summary --}}
                        <div class="col-12 my-2 my-lg-0 mb-lg-2 order-1 order-lg-0">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-header bg-white">
                                    <h1 class='h5 mb-0'>Adresses</h1>
                                </div>
                                <div class="card-body">
                                    <div class='billing-address'>
                                        <p class='h5'>Facturation</p>
                                        <?php $billing_address = $shoppingCart->billing_address; ?>
                                        <p class='mb-0'><b>{{$billing_address->firstname}} {{$billing_address->lastname}}</b></p>
                                        @if($billing_address->company != null) <small class="mb-0"><b>{{$billing_address->company}}</b></small>@endif
                                        @if($billing_address->complement != null) <small class="mb-0">{{$billing_address->complement}}</small>@endif
                                        <p class='mb-0'>{{$billing_address->street}}</p>
                                        <p class='mb-0'>{{$billing_address->zipCode}}, {{$billing_address->city}}</p>
                                    </div>
                                    
                                    <div class='shipping-address mt-4'>
                                            
                                        <p class='h5'>Livraison</p>
                                        @if($shoppingCart->shipping_address != null)
                                        <?php $shipping_address = $shoppingCart->shipping_address; ?>
                                        <p class='mb-0'><b>{{$shipping_address->firstname}} {{$shipping_address->lastname}}</b></p>
                                        @if($shipping_address->company != null) <small class="mb-0"><b>{{$shipping_address->company}}</b></small>@endif
                                        @if($shipping_address->complement != null) <small class="mb-0">{{$shipping_address->complement}}</small>@endif
                                        <p class='mb-0'>{{$shipping_address->street}}</p>
                                        <p class='mb-0'>{{$shipping_address->zipCode}}, {{$shipping_address->city}}</p>
                                        @else 
                                        <p class='mb-0'>Livraison à l'atelier</p>
                                        <small class='mb-0'>{{$billing_address->email}}</small>
                                        @if($billing_address->phone != null)<small class='mb-0'>{{$billing_address->phone}}</small>@endif
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $('#cheque-payment').hide();
    function display_cheque_payment()
    {
        $('#cheque-payment').fadeToggle(200);
    }
</script>

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