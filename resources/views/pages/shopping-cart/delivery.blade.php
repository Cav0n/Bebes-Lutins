<?php 
    $pricesAndQuantities = $shoppingCart->calculatePricesAndQuantities();
    
    $products_price_without_voucher = $pricesAndQuantities['products_price'];
    $total_quantity = $pricesAndQuantities['total_quantity'];
    $total = $shoppingCart->productsPrice + $shoppingCart->shippingPrice;
    $price_before_free_shipping = 70 - $shoppingCart->productsPrice;

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
                    <div id='delivery-selection' class="card p-0 border-0 rounded-0">
                        <div class="card-header bg-white">

                            @include('pages.shopping-cart.delivery.delivery-tabs')
                            
                        </div>
                        <div id='delivery-choices-container' class='card-body'>

                            @include('pages.shopping-cart.delivery.delivery-choices')

                        </div>
                    </div>

                    <div class="card p-0 m-0 border-0 rounded-0 my-2">
                        <div class="card-header bg-white">
                            <h1 class='h5 mb-0'>Ajouter un message</h1>
                        </div>
                        <div class='card-body'>
                            <p>Si vous souhaitez ajouter des précisions sur votre commande vous pouvez nous laisser un message ici : </p>
                            <div class="form-group">
                                <label for="customer-message">Votre message</label>
                                <div class='textarea-container ld-over'>
                                    <textarea class="form-control" name="customer-message" id="customer-message" rows="4">@if($shoppingCart->customerMessage != null){{$shoppingCart->customerMessage}}@endif</textarea>
                                    <div class="ld ld-ring ld-spin"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  SUMMARY AND OTHERS  --}}
                <div class="col-12 col-sm-10 col-lg-3">
                    <div class="row">

                        {{--  Summary  --}}
                        <div class="col-12 my-2 my-lg-0 mb-lg-2 order-2">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-header bg-white">
                                    <h1 class='h5 mb-0'>Résumé</h1>
                                </div>
                                <div class="card-body row justify-content-center m-0">
                                    <div class="col-6 p-0 pb-2">
                                        <p class="card-text">{{$total_quantity}} produits :</p>
                                    </div>
                                    <div class="col-6 p-0 pb-2">
                                        <p class="card-text text-right">
                                            @if($shoppingCart->voucher != null && $shoppingCart->voucher->discountType < 3) 
                                            <del class='text-danger'>{{number_format($products_price_without_voucher, 2)}} €</del><BR>
                                            <b>- {{number_format($products_price_without_voucher - $shoppingCart->productsPrice, 2)}} € </b><BR>
                                            @endif 
                                            {{number_format($shoppingCart->productsPrice, 2)}} € 
                                        </p>
                                    </div>

                                    <div class="col-6 p-0 border-top py-2">
                                        <p class="card-text">Frais de ports :</p>
                                    </div>
                                    <div class="col-6 p-0 border-top py-2">
                                        <p class="card-text text-right">
                                            @if($shoppingCart->voucher != null && $shoppingCart->voucher->discountType == 3)
                                            <del class='text-danger'>5,90 €</del><BR>
                                            @endif
                                            {{number_format($shoppingCart->shippingPrice, 2)}} €
                                        </p>
                                    </div>
                
                                    <div class="col-6 p-0 border-top pt-2">
                                        <p class="card-text font-weight-bold">TOTAL TTC :</p>
                                    </div>
                                    <div class="col-6 p-0 border-top pt-2">
                                        <p class="card-text text-right font-weight-bold">{{number_format($total, 2)}} €</p>
                                    </div>
                
                                    <div class="col-12 border-bottom my-4"></div>
                                    
                                    <div class="col-12 col-md-6 col-lg-12 mb-2" style='line-height:0;'>
                                        <small class="small" style="line-height:1rem;">En cliquant sur ce bouton vous acceptez sans 
                                        réserve les conditions générales de vente.</small>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <?php 
                                        $form = 'new-address-form';
                                        if( ($has_addresses && session('delivery-type') == null) || session('delivery-type') == 'saved-addresses' ) $form = 'saved-addresses-form';
                                        if( (!$has_addresses && session('delivery-type') == null) || session('delivery-type') == 'new-address') $form = 'new-address-form';
                                        if(session('delivery-type') == 'withdrawal-shop') $form = 'withdrawal-shop-form';
                                        ?>
                                        <button id='submit-button' type="submit" class="btn btn-primary w-100" form="{{$form}}" >Passer au paiement</button>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

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

{{-- Customer message --}}
<script>
    $("#customer-message").on('change', function(){
        customer_message = this.value;
        shopping_cart_id = "{{$shoppingCart->id}}";
        console.log(customer_message);
        $.ajax({
            url: "/panier/ajout_message/" + shopping_cart_id,
            type: 'POST',
            data: { message:customer_message, add_message:true },
            success: function(data){
                console.log('Message ajouté avec succés !');
                $(this).parent().removeClass('running');
            },
            beforeSend: function() {
                $(this).parent().addClass('running');
            }
        });
    });
</script>

@endsection