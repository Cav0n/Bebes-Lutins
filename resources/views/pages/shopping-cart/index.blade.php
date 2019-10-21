<?php
    $pricesAndQuantities = $shoppingCart->calculatePricesAndQuantities();

    $products_price_without_voucher = $pricesAndQuantities['products_price'];
    $total_quantity = $pricesAndQuantities['total_quantity'];
    $total = $shoppingCart->productsPrice + $shoppingCart->shippingPrice;
    $price_before_free_shipping = 70 - $shoppingCart->productsPrice;
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
        @if (count($shoppingCart->items) <= 0)

        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
            <div class="card my-5 p-0 border rounded-0">
                <div class="card-body border-0 row justify-content-center">
                    <h4 class="col-12 card-title text-center font-weight-bold">Votre panier est vide 😢</h4>
                    <p class="col-12 card-text text-center">Découvrez nos superbes articles !</p>
                    <div class='button-container d-flex justify-content-center col-6'>
                        <a name="discover-button" id="discover-button" class="btn btn-secondary text-center w-100" href="/" role="button">Découvrir</a>
                    </div>
                </div>
            </div>
        </div>

        @else

        <div class="col-12">

            {{-- STEPS --}}
            @include('pages.shopping-cart.steps')

            @if($shoppingCart->id != session('shopping_cart')->id)
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-lg-8 my-2">
                    <h2 class='mb-0 bg-white p-2'>
                        Panier partagé @if($shoppingCart->user != null){{'par '. $shoppingCart->user->firstname }}@endif
                    </h2>
                </div>
            </div>
            @endif

            <div class="row justify-content-center">
                
                {{--  ITEMS  --}}
                <div class="col-12 col-sm-10 col-lg-5 my-md-2 my-lg-0">

                    {{--  Shopping Cart Items for mobiles and tiny tablets  --}}
                    @if(isset($shoppingCartInfos))
                    <div class="card p-0 m-0 border-0 rounded-0 mb-2 p-3 bg-warning">
                        <p class='mb-0 font-weight-bold'>{{$shoppingCartInfos}}</p>
                    </div>
                    
                    @endif
                    @foreach ($shoppingCart->items as $item)
                    <div id='product-{{$item->product->id}}' class="card p-0 m-0 border-0 rounded-0 mb-2">
                        <div class="row m-0 p-0">
                            <div class="col-4 p-0" style='min-height:8rem; max-height:10rem;'>
                                <img class='product-image w-100 h-100' src='{{asset('images/products/' . $item->product->mainImage)}}' alt='Image du produit' style='object-fit:cover;'>                        
                            </div>
                            <div class="col-8 p-2 d-flex flex-column">
                                <div class="row m-0">
                                    <div class="col-12 p-0">
                                        <a href='/produits/{{$item->product->id}}' class='mb-0 font-weight-bold text-dark d-flex d-md-none item-name-cropped'>{{$item->product->name}}</a> 
                                        <a href='/produits/{{$item->product->id}}' class='mb-0 font-weight-bold text-dark d-none d-md-flex item-name-full'>{{$item->product->name}}</a> 
                                    </div>
                                </div>
                                <div class="row m-0 mb-auto">
                                    <div class="col-12 p-0">
                                        <p class='mb-0 small'>Prix unitaire : {{number_format($item->product->price, 2)}} €</p>                                       
                                    </div>
                                </div>
                                <div class="row m-0">
                                    <div class="col-12 p-0">
                                        <div class="form-group row m-0">
                                            <div class="col-12 col-sm-6 col-lg-7 d-flex p-0 order-1 order-lg-1">
                                                <div class='d-flex flex-column justify-content-center ld-over'>
                                                    <input id="item-quantity" class="spinnerProduct" type="number" name="quantity" value="{{$item->quantity}}" min="0" max="{{$item->product->stock}}" step="1" @if($item->product->stock <= 1) disabled @endif onchange="change_quantity($(this), '{{$item->id}}')" style="height:1rem;font-size:0.8rem;"/>
                                                    <div class="ld ld-ring ld-spin"></div>
                                                </div>
                                                @if($shoppingCart->id == session('shopping_cart')->id)
                                                <div class='svg-container ld-over d-flex flex-column justify-content-center ml-2' style='width:2rem;' onclick='remove_item_from_shopping_cart($(this), "{{$item->id}}")'>
                                                    <img class='svg' src='{{asset('images/icons/trash.svg')}}' style='height:1rem;'>
                                                    <div class="ld ld-ring ld-spin"></div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 col-lg-5 d-flex justify-content-left justify-content-sm-end p-0 pt-2 pt-lg-0 order-3 order-lg-3">
                                                <div class="d-flex flex-column justify-content-center">
                                                    @if($shoppingCart->voucher != null && $shoppingCart->voucher->discountType == 1 && $item->hasReduction)
                                                    <p class='mb-0 small font-weight-bold text-right'>Total : <del>{{number_format($item->product->price * $item->quantity, 2)}} €</del><BR>{{number_format($item->newPrice * $item->quantity, 2)}} €</p>
                                                    @else
                                                    <p class='mb-0 small font-weight-bold'>Total : {{number_format($item->product->price * $item->quantity, 2)}} €</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="card p-0 m-0 border-0 rounded-0 mb-2">
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

                        {{--  Voucher code  --}}
                        @if($shoppingCart->id == session('shopping_cart')->id)
                        <div class="col-12 mb-2 order-1">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-header bg-white">
                                    <h1 class='h5 mb-0'>Réductions</h1>
                                </div>
                                <div class="card-body row m-0">
                                    @if ($shoppingCart->voucher == null)
                                    <div class='voucher'>
                                        <div class="form-group">
                                            <label for="voucher-code">Code coupon : </label>
                                            <div class="row m-0 p-0">
                                                <div class="col-8 p-0 pr-2">
                                                    <input type="text" class="form-control" name="voucher-code" id="voucher-code" aria-describedby="helpVoucher" placeholder="">
                                                </div>
                                                <div class="col-4 p-0">
                                                    <button type="button" class="btn btn-light w-100 ld-over" onclick="add_voucher($(this), $('#voucher-code').val())">
                                                        Ajouter
                                                        <div class="ld ld-ring ld-spin"></div>
                                                    </button>
                                                </div> 
                                            </div>
                                            <small id="helpVoucher" class="form-text text-muted">Tapez ici votre code de réduction (si vous en avez un)</small>
                                        </div>
                                    </div>
                                    @else
                                    <div class='voucher'>
                                        <div class="form-group">
                                            <label for="voucher-code">Code coupon : </label>
                                            <div class="row m-0 p-0">
                                                <div class="col-8 p-0 pr-2">
                                                    <input type="text" class="form-control" name="voucher-code" id="voucher-code" aria-describedby="helpVoucher" placeholder="" disabled value='{{$shoppingCart->voucher->code}}'>
                                                </div>
                                                <div class="col-4 p-0">
                                                    <button type="submit" class="btn btn-danger w-100 ld-over" onclick="remove_voucher($(this))">
                                                        Supprimer
                                                        <div class="ld ld-ring ld-spin"></div>
                                                    </button>
                                                </div> 
                                            </div>
                                        </div>
                                        @if($shoppingCart->voucher->discountType == 1)
                                        <small>- {{number_format($shoppingCart->voucher->discountValue, 2)}} % sur une sélection d'articles.</small>
                                        @elseif($shoppingCart->voucher->discountType == 2)
                                        <small>- {{$shoppingCart->voucher->discountValue}} € sur votre commande dès {{number_format($shoppingCart->voucher->minimalPrice, 2)}} € d'achat.</small>
                                        @elseif($shoppingCart->voucher->discountType == 3)
                                        <small>Frais de port offert sur votre commande.</small>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

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

                                    @if($shoppingCart->id == session('shopping_cart')->id)
                
                                    <div class="col-12 col-md-6 col-lg-12 mb-2" style='line-height:0;'>
                                        <small class="small" style="line-height:1rem;">En cliquant sur ce bouton vous acceptez sans 
                                        réserve les conditions générales de vente.</small>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <button type="button" class="btn btn-primary w-100" onclick='load_url("/panier/livraison")'>Valider mon panier</button>
                                    </div>

                                    @else

                                    <div class="col-12 col-md-6 col-lg-12">
                                        <button type="button" class="btn btn-primary w-100" onclick='load_url("/panier/{{$shoppingCart->id}}/commander")'>Commander ce panier</button>
                                    </div>

                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- SHARING --}}
                        @if($shoppingCart->id == session('shopping_cart')->id)
                        <div class="col-12 p-0 px-lg-3 my-2 order-3">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-body row justify-content-center m-0 d-flex flex-column">
                                    <p>Pour partager votre panier vous pouvez copier le lien ci dessous :</p>
                                    <p class='small text-center py-2 border rounded-0 text-dark bg-light'>https://www.bebes-lutins.fr/panier/{{$shoppingCart->id}}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{--  Free shipping info  --}}
                        @if($shoppingCart->id == session('shopping_cart')->id && isset($price_before_free_shipping))
                        <div class="col-12 my-2 my-lg-0 mt-lg-2 order-4">
                            @if ($price_before_free_shipping > 0)
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-body infos row m-0">
                                    <p class="card-text">Plus que {{number_format($price_before_free_shipping, 2)}} € pour profiter de la livraison gratuite.</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>
</main>

<script>
    function add_voucher(btn, code){

        $.ajax({
            url: "/panier/code-coupon/ajouter",
            type: 'POST',
            data: { code:code },
            success: function(data){
                btn.removeClass('running');
                data = JSON.parse(data);
                if(data.status == 'error') textclass='text-danger';
                else textclass='text-success';

                $('#voucher-message').remove();
                $('.voucher').prepend('<p id="voucher-message" class="'+textclass+'">'+ data.message +'</p>');

                if(data.status != 'error') location.reload();
            },
            error: function(data) {
                console.log("Impossible d'ajouter le code.")
                btn.removeClass('running');
            },
            beforeSend: function() {
                btn.addClass('running');
            }
        });
    }

    function remove_voucher(btn){
        $.ajax({
            url: "/panier/code-coupon/supprimer",
            type: 'POST',
            data: { },
            success: function(data){
                btn.removeClass('running');

                $('.voucher').prepend('<p id="voucher-message" class="text-success">Le code a été supprimé du panier.</p>');
                location.reload();
            },
            error: function(data) {
                console.log("Impossible de supprimer le code.")
                btn.removeClass('running');
            },
            beforeSend: function() {
                btn.addClass('running');
            }
        }) 
    }
</script>

{{-- AJAX SETUP --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function remove_item_from_shopping_cart(btn, item_id){
        $.ajax({
            url: "/panier/remove_item/" + item_id,
            type: 'DELETE',
            data: { },
            success: function(data){
                console.log('Produit bien retiré du panier.');
                document.location.href = '/panier'
            },
            beforeSend: function() {
                btn.addClass('running');
            }
        })
        .done(function( data ) {
            
        }); 
    }
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

{{-- Custom Spinner --}}
<script>
    $(".spinnerProduct").inputSpinner();
</script>

{{-- CHANGE ITEM QUANTITY --}}
<script>
    function change_quantity(select, item_id){
        quantity = select.val();
        console.log(item_id);

        if(quantity == 0){
            remove_item_from_shopping_cart(select, item_id);
        } else {
            $.ajax({
                url: "/panier/change_quantity/" + item_id,
                type: 'POST',
                data: { quantity:quantity },
                success: function(data){
                    console.log('Quantité modifié avec succés.');
                    document.location.href = '/panier'
                },
                beforeSend: function() {
                    select.parent().addClass('running');
                }
            }) 
        }
    }
</script>

{{-- REDUCE TEXT LENGHT --}}
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