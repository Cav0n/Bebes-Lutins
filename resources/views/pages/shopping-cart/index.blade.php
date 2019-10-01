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
@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/shopping-cart/index.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading-btn.css')}}">
@endsection

@section('content')
<main id='main-shopping-cart' class='container-fluid dim-background'>
    <div class="row justify-content-center py-3 py-md-4 py-lg-5">
        @if (count($shopping_cart->items) <= 0)

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
            <div class="row justify-content-center">

                {{--  ITEMS  --}}
                <div class="col-12 col-sm-10 col-lg-5 my-md-2 my-lg-0">

                    {{--  Shopping Cart Items for desktops and tablets  --}}
                    <div class="card p-0 border-0 rounded-0 d-none d-sm-flex">
                        <div class="card-header bg-white">
                            <h1 class='h5 mb-0'>Votre panier</h1>
                        </div>
                        <div class="card-body border-0">
                            @foreach ($shopping_cart->items as $item)
                            <div class="row m-0 my-3">
                                <div class="col-2 p-0">
                                    <img class='product-image w-100' src='{{asset('images/products/' . $item->product->mainImage)}}' alt='Image du produit' style='object-fit:cover;'>                            
                                </div>
                                <div class="col-5 d-flex flex-column justify-content-center">
                                    <p class='mb-0'>{{$item->product->name}}</p>
                                </div>
                                <div class="col-1 d-flex flex-column justify-content-center">
                                    <p class='mb-0'>{{$item->quantity}}</p>
                                </div>
                                <div class="col-2 d-flex flex-column justify-content-center">
                                    <p class='mb-0'>{{number_format($item->product->price, 2)}} €</p>
                                </div>
                                <div class="col-2 d-flex flex-column justify-content-center p-0">
                                    <button type="button" class="btn btn-danger ld-over-inverse" onclick='remove_item_from_shopping_cart($(this), "{{$item->id}}")' style='font-size:0.8rem;'>
                                        Supprimer
                                        <div class="ld ld-ring ld-spin"></div>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{--  Shopping Cart Items for mobiles and tiny tablets  --}}
                    @foreach ($shopping_cart->items as $item)
                    <div class="card p-0 m-0 border-0 rounded-0 d-sm-none mb-2" style="height:7rem;">
                        <div class="row m-0 p-0">
                            <div class="col-4 p-0">
                                <img class='product-image w-100 h-100' src='{{asset('images/products/' . $item->product->mainImage)}}' alt='Image du produit' style='object-fit:cover;'>                        
                            </div>
                            <div class="col-8 p-2">
                                <div class="col-12 p-0 d-flex">
                                    <div class="col-10 p-0 pr-2" style='line-height:0'>
                                        <a href='/produits/{{$item->product->id}}' class='mb-0 font-weight-bold text-dark' style='font-size:0.7rem;line-height:0.9rem;'>{{$item->product->name}}</a> 
                                    </div>
                                    <div class="col-2 p-1 d-flex flex-column justify-content-center">
                                        <button type="button" class="btn btn-danger p-0 w-100" style="font-size:0.7rem;">X</button>
                                    </div>
                                </div>
                                <div class="col-12 p-0">
                                    <p class='mb-0 small'>{{number_format($item->product->price, 2)}} €</p>                                       
                                </div>
                                <div class="col-12 p-0">
                                    <div class="form-group row m-0">
                                        <div class="col-4 p-0 d-flex flex-column justify-content-center">
                                            <label for="quantity" class='small mb-0'>Quantité :</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" name="quantity" id="quantity" style='font-size:0.7rem;height:1.4rem;'>
                                            <option selected>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            </select>
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

                        {{--  Free shipping info  --}}
                        <div class="col-12 my-2 my-lg-0 mt-lg-2 order-2">
                            @if ($price_before_free_shipping > 0)
                            <div class="card p-0 border-0 rounded-0">
                                <div class="card-body infos row m-0">
                                    <p class="card-text">Plus que {{number_format($price_before_free_shipping, 2)}} € pour profiter de la livraison gratuite.</p>
                                </div>
                            </div>
                            @endif
                        </div>

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
        url: "/panier/remove_item/aaa" + item_id,
        type: 'DELETE',
        data: { },
        success: function(data){
            console.log('Produit bien retiré du panier.');
            //document.location.href = '/panier'
        },
        beforeSend: function() {
            btn.addClass('running');
        }
    })
    .done(function( data ) {
        
    }); 
}
</script>

@endsection