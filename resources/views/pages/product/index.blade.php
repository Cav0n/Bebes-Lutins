@extends('templates.default')

@section('optional_og')
<meta property="og:type" content="og:product" />
<meta property="og:title" content="{{ $product->name }}" />
<meta property="og:description" content="{{ $product->description }}" />
<meta property="og:image" content="{{ $product->images()->count() ? $product->images()->first()->url : null }}" />
<meta property="og:url" content="{{ route('product', ['product' => $product]) }}" />
<meta property="og:site_name" content="Bébés Lutins" />
<meta property="product:price:amount" content="{{ $product->price }}" />
<meta property="product:price:currency" content="EUR" />
@endsection

@section('title', $product->name . " - Bébés Lutins")

@section('description', $product->description)

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5 row">
            <div id="product-image-container" class="col-12 col-sm-5 col-xxl-4 col-xxxl-3">
                @include('components.utils.carousel.product')
                <div class="rating-container d-none d-sm-flex flex-column">
                    @include('components.utils.products.ratings')
                </div>
            </div>
            <div class="col-12 col-sm-7 col-xxl-8 col-xxxl-9 p-0">
                <p id="product-breadcrumb" class="px-3 pt-2">{!! $product->breadcrumb !!}</p>
                <div class="bg-white p-3 shadow-sm">
                    <h1 class="mb-0 h2 d-none d-sm-flex">{{ $product->name }}</h1>
                    <p class="mb-0 h4 d-flex d-sm-none">{{ $product->name }}</h1>
                    @if (count($product->reviews))
                    <div class="mark-container d-flex">
                        <span class="fixed-rating" data-mark='{{ $product->globalMark }}'></span>
                        <p class="mb-0 ml-2">{{ round($product->globalMark, 1) }} / 5</p>
                    </div>
                    @endif
                    <div class="d-flex">
                        <h2 class="h4 mb-0 d-flex flex-column justify-content-center">{{ \App\NumberConvertor::doubleToPrice($product->price) }}</h2>
                        @admin
                        <a class="btn btn-outline-dark py-0 ml-3" href="{{ route('admin.product.edit', ['product' => $product]) }}" role="button">Editer</a>
                        @endadmin
                    </div>
                    <div class="d-flex my-2">
                        <input type="number" class="form-control input-spinner quantity-spinner" name="quantity" id="quantity" aria-describedby="helpQuantity" min="1" max="{{ $product->stock }}" value="1">
                        <button type="button" class="btn btn-primary add-to-cart rounded-0 ml-3" data-id="{{ $product->id }}" data-toggle="modal" data-quantity="1" data-cart_id="{{ session()->get('shopping_cart')->id }}" data-target="#product-added-modal">
                            Ajouter au panier</button>
                    </div>

                    <div class="text-justify mt-3">
                        {!! $product->description !!}
                    </div>
                </div>

                <div class="rating-container d-flex d-sm-none flex-column">
                    @include('components.utils.products.ratings')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    quantitySpinner = $('.quantity-spinner');
    quantitySpinner.on("change", function(event) {
        $('button.add-to-cart').data('quantity', $(this).val());
        $('button.add-to-cart').attr('data-quantity', $(this).val());
    })
</script>
@endsection
