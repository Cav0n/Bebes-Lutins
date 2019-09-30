<?php $shopping_cart = session('shopping_cart'); 
//session()->forget('shopping_cart');
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
<main id='main-shopping-cart' class='container-fluid'>
    <div class="row justify-content-center py-5 bg-light">
        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
            @if (count($shopping_cart->items) <= 0)
                <div class="card my-5 p-0 border rounded-0">
                    <div class="card-body border-0 row justify-content-center">
                        <h4 class="col-12 card-title text-center font-weight-bold">Votre panier est vide 😢</h4>
                        <p class="col-12 card-text text-center">Découvrez nos superbes articles !</p>
                        <div class='button-container d-flex justify-content-center col-6'>
                            <a name="discover-button" id="discover-button" class="btn btn-secondary text-center w-100" href="/" role="button">Découvrir</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card my-5 p-0 border rounded-0">
                    <div class="card-header bg-white">
                        <h1 class='h5 mb-0'>Votre panier</h1>
                    </div>
                    <div class="card-body border-0">
                        <table class="table">
                            <tbody>
                                @foreach ($shopping_cart->items as $item)
                                <tr>
                                    <td><img class='product-image' src='{{asset('images/products/' . $item->product->mainImage)}}' alt='Image du produit'></td>
                                    <td scope="row">{{$item->product->name}}</td>
                                    <td>{{$item->quantity}}</td>

                                    <td>
                                        <button type="button" class="btn btn-primary ld-ext-right" onclick='remove_item_from_shopping_cart($(this), "{{$item->id}}")'>
                                            Supprimer
                                            <div class="ld ld-ring ld-spin"></div>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
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

@endsection