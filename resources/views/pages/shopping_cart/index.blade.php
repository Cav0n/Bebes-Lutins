@extends('templates.cart')

@section('cart.title', 'Mon panier')

@section('cart.content')
{{-- ITEMS LIST --}}
<div class="col-12 p-0">

    @if($cart->items->isEmpty())

        <div class="empty-cart-container px-3 border bg-white text-center py-5">
            <h1 class="font-weight-bold">Votre panier semble bien vide 😪</h1>
            <a name="add-some-products" id="add-some-products" class="btn btn-outline-primary rounded-0" href="/" role="button">Ajoutez quelques produits !</a>
        </div>

    @else

        @foreach ($cart->items as $item)
        @include('components.utils.cart.item')
        @endforeach

    @endif

</div>
@endsection
