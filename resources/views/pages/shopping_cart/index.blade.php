@extends('templates.default')

@section('title', "Mon panier - Bébés Lutins")

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
            <h1 class="font-weight-bold">Mon panier - {{$cartQuantity}} produits</h1>
            <div class="row m-0">

                {{-- ITEMS LIST --}}
                <div class="col-lg-8">
                    @foreach ($cart->items as $item)
                    <div class="cart-product-container row border bg-white my-2">
                        <div class="col-lg-3">
                            <img src='{{asset($item->product->images->first()->url)}}' class="w-100">
                        </div>
                        <div class="col-lg-9 p-3">
                            <a class="mb-0 font-weight-bold" href={{ route('product', ['product' => $item->product->id]) }}>{{ $item->product->name }}</a>
                            <p class="mb-0">Prix unitaire : {{ \App\NumberConvertor::doubleToPrice($item->product->price) }}</p>
                            <p class="mb-0">Quantité : {{ $item->quantity }}</p>
                            <a class="btn btn-primary" href="{{ route('cart.item.delete', ['cartItem'=>$item->id]) }}" role="button">Supprimer</a>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- CART RECAP --}}
                <div class="col-lg-4 my-2">
                    <div id="price-recap" class="border mb-2 bg-white p-3">
                        <p class="mb-0">{{ $cartQuantity }} produits : {{ \App\NumberConvertor::doubleToPrice($cartPrice) }}</p>
                        <p class="mb-0">Frais de ports : {{ \App\NumberConvertor::doubleToPrice($shippingCosts) }}</p>
                        <p>TOTAL T.T.C. : {{ \App\NumberConvertor::doubleToPrice($cartPrice + $shippingCosts) }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
