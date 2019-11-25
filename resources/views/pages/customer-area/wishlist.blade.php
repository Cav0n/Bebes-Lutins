@extends('templates.customer-area')

@section('body')
<div class="row">
    <div class="col-12">

        <p class='h5 font-weight-bold'>Ma liste d'envie</p>

        @if(count($wishlist->items) <= 0)
        <p>Vous n'avez aucun article dans votre liste d'envie.</p>
        @else
        <div class="row">
        @foreach ($wishlist->items as $item)
            @php
                $product = $item->product;
            @endphp
            @include('components.public.product-display')
        @endforeach
        </div>

        @endif

    </div>
</div>

@include('components.public.popups.add-to-cart')

@endsection