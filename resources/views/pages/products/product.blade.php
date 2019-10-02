@extends('templates.template')

@section('head-options')
    <link href="{{asset('css/zoom/zoom.css')}}" rel="stylesheet">
    <script src="{{asset('js/zoom/zoom.js')}}" ></script>
@endsection

@section('content')
<main id='product-main' class='container-fluid my-3'>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="row m-0">
                {{-- Breadcrumb --}}
                <div class="col-lg-12 justify-content-center my-3 d-none d-lg-flex">
                    @include('layouts.public.breadcrumb-product')
                </div>

                {{-- Image, title and buttons --}}
                <div class="col-12 p-0 px-lg-3">
                    <div class="row m-0 px-lg-2">
                        <div class="col-12 col-lg-4 p-0">
                            <div class="row m-0">
                                <div class="col-12 p-0" style='max-height:18rem;'>
                                    <img id='main-image' class='w-100 h-100' src='{{asset("images/products/".$product->mainImage)}}' style='object-fit:cover;'>                                    
                                </div>
                            </div>
                            <div class="row m-0 d-flex flex-nowrap" style='overflow-x:auto'>
                                <div class="p-0 pr-2 pt-2" style="max-height: 4rem;max-width:4rem;">
                                    <img onclick="change_main_image($(this))" class='w-100 h-100' src='{{asset("images/products/".$product->mainImage)}}' style='object-fit:cover;'>                                                                    
                                </div>
                                @foreach ($product->images as $image)
                                <div class="p-0 pr-2 pt-2" style="max-height: 4rem;max-width:4rem;">
                                    <img onclick="change_main_image($(this))" class='w-100 h-100' src='{{asset("images/products/thumbnails/".$image->name)}}' style='object-fit:cover;'>                                                                    
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 mt-3 mt-lg-0">
                            <div class="row m-0 d-flex justify-content-center justify-content-lg-start">
                                <div class="col-12 col-lg-12 p-0">
                                    <h1 class='h2 text-center text-lg-left mb-0'>{{$product->name}}</h1>
                                </div>
                                <div class="col-6 col-lg-4 p-0">
                                    <p id="product-price" class='h4 text-center my-2 p-2'>{{number_format($product->price, 2)}} €</p>
                                    <input id="item-quantity" class="spinner" type="number" name="quantity" value="1" min="1" max="{{$product->stock}}" step="1"/>
                                    <button type="button" class="btn bg-white border-secondary w-100 mt-2 mb-1">Ajouter au panier</button>
                                    <button type="button" class="btn bg-white border-secondary w-100 mt-1 mb-2">Ajouter à ma liste</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Description --}}
                <div class="col-lg-12 p-0 pt-3 mt-3 mt-lg-4 border-top">
                    <div class="card rounded-0 border-0">
                        <div class="card-body p-0 p-lg-3">
                            <h4 class="card-title px-0 px-lg-2 d-none d-lg-flex">Description</h4>
                            <p class="card-text px-0 px-lg-2">{{$product->description}}</p>
                        </div>
                    </div>
                </div>

                {{-- Avis clients --}}
                <div class="col-lg-12 p-0 pt-3 mt-3 mt-lg-4 border-top">
                    <div class="card rounded-0 border-0">
                        <div class="card-body p-0 p-lg-3">
                            <h4 class="card-title px-0 px-lg-2">... avis clients</h4>
                            <div class="col-12 p-0">
                                {{-- Review global mark and create button --}}
                                <div class="row m-0">
                                    <div class="col-12 col-lg-4 p-0 px-lg-2">
                                        <span class='d-flex'>
                                            <p class="h3 mb-0">4,4</p> <p class='d-flex flex-column justify-content-end mb-0'>sur 5</p>
                                        </span>
                                        <button type="button" class="btn btn-primary rounded-0 my-2">Écrire un commentaire</button>
                                    </div>
                                </div>
                                <div class="row m-0 justify-content-lg-between">
                                    <div class="col-12 col-lg-6 p-0 px-lg-2 my-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-title">Le 02 octobre 2019 - Florian B.</p>
                                                <p class="card-text">Cards can be organized into Masonry-like columns with just CSS by wrapping them in .card-columns. Cards are built with CSS column properties instead of flexbox for easier alignment. Cards are ordered from top to bottom and left to right.</p>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- Custom Spinner --}}
<script>
    product_price = {{$product->price}}

    $(".spinner").inputSpinner();

    $(".spinner").on("change", function (event) {
        quantity_to_add = $(this).val();
        new_product_price = product_price * quantity_to_add
        $('#product-price').text(new_product_price.toFixed(2) + ' €');
    })
</script>

{{-- Change main image --}}
<script>
    function change_main_image(img){
        $('#main-image').attr('src', img.attr('src'));
    }
</script>

{{-- Init zoom js --}}
<script>
    MediumLightbox('figure.zoom-effect');
</script>
@endsection