@extends('templates.default')

@section('title', $product->name . " - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5 row">
            <div class="col-6">
                @include('components.utils.carousel.product')
            </div>
            <div class="col-6">
                <p>{!! $product->breadcrumb !!}</p>
                <h1>{{$product->name}}</h1>
                <div class="d-flex my-2">
                    <input type="number" class="form-control input-spinner" name="quantity" id="quantity" aria-describedby="helpQuantity">
                    <button type="button" class="btn btn-primary add-to-cart rounded-0" data-id="{{ $product->id }}" data-toggle="modal" data-quantity="1" data-cart_id="{{ session()->get('shopping_cart')->id }}" data-target="#product-added-modal">
                        Ajouter au panier</button>
                </div>

                <p>{{$product->description}}</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const SPINNER_CONFIG = {
        decrementButton: "<strong>-</strong>", // button text
        incrementButton: "<strong>+</strong>", // ..
        groupClass: "quantity-selector mr-3", // css class of the resulting input-group
        buttonsClass: "btn-outline-dark rounded-0",
        buttonsWidth: "2.5rem",
        textAlign: "center",
        autoDelay: 500, // ms holding before auto value change
        autoInterval: 100, // speed of auto value change
        boostThreshold: 10, // boost after these steps
        boostMultiplier: "auto" // you can also set a constant number as multiplier
    }

    var quantitySpinner = $(".input-spinner").inputSpinner(SPINNER_CONFIG);
    quantitySpinner.on("change", function(event) {
        $('button.add-to-cart').data('quantity', $(this).val());
        $('button.add-to-cart').attr('data-quantity', $(this).val());
        console.log($('button.add-to-cart').data('quantity'));
    })
</script>
@endsection
