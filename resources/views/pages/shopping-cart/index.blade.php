<?php
    $pricesAndQuantities = $shoppingCart->calculatePricesAndQuantities();
    
    $products_price = $pricesAndQuantities['products_price'];
    $shipping_price = $pricesAndQuantities['shipping_price'];
    $total_quantity = $pricesAndQuantities['total_quantity'];
    $total = $products_price + $shipping_price;
    if($products_price < 70) $price_before_free_shipping = 70 - $products_price;
    else $price_before_free_shipping = 0;
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
                    @foreach ($shoppingCart->items as $item)
                    <div class="card p-0 m-0 border-0 rounded-0 mb-2">
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
                                                <div class='d-flex flex-column justify-content-center'>
                                                    <label for="quantity" class='small mb-0 pr-2'>Quantité :</label>
                                                </div>
                                                <div class='d-flex flex-column justify-content-center ld-over'>
                                                    <select class="form-control" name="quantity" id="quantity" style='font-size:0.7rem;height:1.4rem;max-width:3rem;' onchange="change_quantity($(this), '{{$item->id}}')" @if($shoppingCart->id != session('shopping_cart')->id) disabled @endif>
                                                        <option value='0'>Supprimer</option>
                                                        @for ($quantity = 1; ($quantity <= $item->product->stock) && ($quantity <= 10); $quantity++)
                                                            <option value='{{$quantity}}' @if($item->quantity == $quantity) selected @endif>{{$quantity}}</option>
                                                        @endfor
                                                    </select>
                                                    <div class="ld ld-ring ld-spin"></div>
                                                </div>
                                                @if($shoppingCart->id == session('shopping_cart')->id)
                                                <div class='svg-container ld-over d-flex flex-column justify-content-center ml-2' style='width:1rem;' onclick='remove_item_from_shopping_cart($(this), "{{$item->id}}")'>
                                                    <img class='svg' src='{{asset('images/icons/trash.svg')}}' style='height:1rem;'>
                                                    <div class="ld ld-ring ld-spin"></div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 col-lg-5 d-flex justify-content-end p-0 pt-2 pt-lg-0 order-3 order-lg-3">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class='mb-0 small font-weight-bold'>Total : {{number_format($item->product->price * $item->quantity, 2)}} €</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{--  SUMMARY AND OTHERS  --}}
                <div class="col-12 col-sm-10 col-lg-3">
                    <div class="row">

                        {{-- SHARING --}}
                        @if($shoppingCart->id == session('shopping_cart')->id)
                        <div class="col-12 my-2 my-lg-0 mb-lg-2 order-1 order-lg-0">
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-header bg-white">
                                    <h1 class='h5 mb-0'>Partage</h1>
                                </div>
                                <div class="card-body row justify-content-center m-0 d-flex flex-column">
                                    <p>Pour partager votre panier veuillez copier le lien ce dessous :</p>
                                    <p class='small text-center py-2 border rounded-0 text-dark bg-light'>www.bebes-lutins.fr/panier/{{$shoppingCart->id}}</p>
                                </div>
                            </div>
                        </div>
                        @endif

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

                        {{--  Voucher code  --}}
                        @if($shoppingCart->id == session('shopping_cart')->id)
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

                        {{--  Free shipping info  --}}
                        @if($shoppingCart->id == session('shopping_cart')->id)
                        <div class="col-12 my-2 my-lg-0 mt-lg-2 order-2">
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

<script>
    function change_quantity(select, item_id){
        quantity = select.val();

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
        }) }
    }
</script>

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