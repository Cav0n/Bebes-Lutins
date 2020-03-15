@extends('templates.default')

@section('title', $product->name . " - Bébés Lutins")

@section('description', $product->description)

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5 row">
            <div id="product-image-container" class="col-12 col-sm-5 col-xxl-4 col-xxxl-3">
                @include('components.utils.carousel.product')
            </div>
            <div class="col-12 col-sm-7 col-xxl-8 col-xxxl-9 p-0">
                <p id="product-breadcrumb" class="px-3 pt-3">{!! $product->breadcrumb !!}</p>
                <div class="bg-white p-3">
                    <h1 class="mb-0">{{ $product->name }}</h1>
                    <h2 class="h4">{{ \App\NumberConvertor::doubleToPrice($product->price) }}</h2>
                    <div class="d-flex my-2">
                        <input type="number" class="form-control input-spinner quantity-spinner" name="quantity" id="quantity" aria-describedby="helpQuantity" min="1" max="{{ $product->stock }}" value="1">
                        <button type="button" class="btn btn-primary add-to-cart rounded-0" data-id="{{ $product->id }}" data-toggle="modal" data-quantity="1" data-cart_id="{{ session()->get('shopping_cart')->id }}" data-target="#product-added-modal">
                            Ajouter au panier</button>
                    </div>

                    <p>{{$product->description}}</p>
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
