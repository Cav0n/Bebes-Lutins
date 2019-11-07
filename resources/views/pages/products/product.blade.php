<?php 
if(Auth::check()){
    $has_commented = \App\Review::where('product_id', $product->id)
    ->where('user_id', Auth::user()->id)
    ->exists();
}
if (count($product->reviews) > 0){
    $total_mark = 0;
    $number_of_reviews = 0;
    foreach ($product->reviews as $review) {
        $total_mark += $review->mark;
        $number_of_reviews++;
    }
    $global_mark = number_format($total_mark / $number_of_reviews, 1);
}
?>

@extends('templates.template')

@section('head-options')
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/custom/product.css')}}">
    {{--  Rate Yo  --}}
    <script src="{{asset('js/rateyo/rateyo.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/rateyo/rateyo.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<main id='product-main' class='container-fluid my-0 py-0 py-lg-3 dim-background'>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 px-0 px-lg-3">
            <div class="row m-0">
                {{-- Breadcrumb --}}
                <div class="col-lg-12 p-0 my-3 d-none d-sm-flex justify-content-center">
                    @include('layouts.public.breadcrumb-product')
                </div>

                {{-- Image, title and buttons --}}
                <div class="col-lg-12 p-0">
                    <div class="row m-0 justify-content-center">

                        {{--  Thumbnails  --}}
                        <div class="col-lg-1 p-0 d-none d-lg-flex flex-column pr-3">
                            <div class='thumbnail-container' style='max-width:3rem; max-height:3rem;'>
                                <img class='w-100 h-100 border' onclick="change_main_image($(this))" src="{{asset('images/products/' . $product->mainImage)}}" style='object-fit:cover;cursor:pointer;'>
                            </div>
                            @foreach ($product->images->skip(1) as $image)
                            <div class='thumbnail-container pt-2'style='max-width:3rem; max-height:3rem;'>
                                <img class='w-100 h-100 border' onclick="change_main_image($(this))" src="{{asset('images/products/thumbnails/' . $image->name)}}" style='object-fit;cursor:pointer;'>
                            </div>
                            @endforeach
                        </div>

                        {{--  Product infos  --}}
                        <div class="col-sm-9 col-lg-11 p-0 border bg-white" style='height:intrinsic'>
                            <div class="row m-0">

                                {{-- Main image --}}
                                <div class="col-12 col-sm-5 col-lg-3 p-0">
                                    <img id='main-image' class="w-100 h-100 zoom" src="{{asset('images/products/' . $product->mainImage)}}" style='object-fit:cover' data-magnify-src="{{asset('images/products/' . $product->mainImage)}}">
                                </div>

                                {{-- Texts and buttons --}}
                                <div class="col-sm-7 col-lg-8 p-3 d-flex flex-column justify-content-between">
                                    <div class="row m-0">
                                        {{--  Title  --}}
                                        <div class="col-lg-12 p-0">
                                            <h1 class="h3 mb-0 text-center text-lg-left">{{$product->name}}</h1>
                                        </div>
                                        {{--  Price  --}}
                                        <div class="col-lg-12 p-0 mt-2">
                                            <div class="row m-0">
                                                <div class="col-12 col-lg-5 p-0 pr-2">
                                                    <p id='product-price' class="mb-0 text-center text-lg-left">Prix : {{number_format($product->price, 2)}} €</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0">

                                        {{-- Characteristics --}}
                                        @foreach($product->characteristics as $characteristic)
                                        <div class="col-lg-12 p-0">
                                            <div class="row m-0 justify-content-center justify-content-lg-start">
                                                <div class="col-7 col-lg-4 offset-lg-0 p-0 pr-2">
                                                    <div class="form-group m-0">
                                                        <label for="{{$characteristic->name}}">{{$characteristic->name}}</label>
                                                        <select class="custom-select characteristic" name="{{$characteristic->name}}" id="{{$characteristic->id}}" required>
                                                            <option selected value=>Choisissez</option>
                                                            @foreach ($characteristic->options as $option)
                                                            <option value="{{$option->name}}">{{$option->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        {{--  Quantity selector  --}}
                                        <div class="col-lg-12 p-0 my-2">
                                            <div class="row m-0 justify-content-center justify-content-lg-start">
                                                <div class="col-7 col-lg-4 offset-2 offset-lg-0 p-0 pr-2">
                                                    <input id="item-quantity" class="spinnerProduct" type="number" name="quantity" value="1" min="1" max="{{$product->stock}}" step="1" @if($product->stock <= 1) disabled @endif />                                            
                                                </div>
                                                <div class="col-2 p-0 d-flex flex-column justify-content-center">
                                                    <p id='total-product-price' class="text-left mb-0 d-none">Prix total : {{number_format($product->price, 2)}} €</p>
                                                </div>
                                            </div>
                                        </div>
                                        {{--  Buttons  --}}
                                        <div class="col-lg-12 p-0 mt-2">
                                            <div class="row m-0">
                                                <div class="col-8 col-lg-4 offset-2 offset-lg-0 p-0 pr-lg-2">
                                                    <span class="d-inline-block w-100" data-trigger="hover" data-toggle="popover" data-content="Veuillez fournir les informations manquantes.">
                                                        <button id='add-to-cart' class="btn btn-primary w-100 rounded-0" style="pointer-events: none;" type="button" @if($product->stock > 0) onclick='add_to_cart("{{$product->id}}", "{{$product->name}}", {{$product->price}}, "{{$product->mainImage}}", "{{$product->stock}}", "{{session("shopping_cart")->id}}", $("#item-quantity").val())' @endif @if($product->stock <= 0) disabled @endif>Ajouter au panier</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                
                {{-- Description --}}
                <div class="col-lg-12 p-3 p-lg-0 mt-2 mt-sm-4 border bg-white">
                    <div class="card rounded-0 border-0">
                        <div class="card-body p-0 p-lg-3">
                            <h4 class="card-title px-0 px-lg-2 d-none d-sm-flex">Description</h4>
                            <div id='description'>
                                {!!$product->description!!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Certifications --}}
                <div class="col-12 mt-2 mt-lg-4 p-0 bg-white">
                    @include('components.public.certifications')
                </div>

                {{-- Avis clients --}}
                <div class="col-lg-12 p-3 p-lg-0 my-2 my-sm-4 border bg-white">
                    <div class="card rounded-0 border-0">
                        <div class="card-body p-0 p-lg-3">
                            <h4 class="card-title px-0 px-lg-2">{{count($product->reviews)}} avis clients</h4>

                            
                            <div class="col-12 p-0">
                                {{-- Review global mark and create button --}}
                                <div class="row m-0">
                                    <div class="col-12 col-lg-4 p-0 px-lg-2">
                                        @if (count($product->reviews) > 0)
                                        <div id='global-rate-container' class='d-flex'>
                                            <div class="static-rate"></div>
                                            <p class="h3 mb-0 mark-number">{{$global_mark}}</p>
                                            <p class='mb-0 d-flex flex-column justify-content-end'> sur 5</p>
                                        </div>
                                        @endif
                                        @if(session()->has('review-feedback')) 
                                            <p class='text-success rounded-0 pl-0 mb-0 font-weight-bold'>{{session('review-feedback')}}</p>
                                        @endif
                                        @if (!Auth::check())
                                            <p class='mb-0 mt-2 border p-2 text-center'>Vous devez être connecté pour pouvoir laisser un avis.</p>
                                        @endif
                                        @if(Auth::check() && !$has_commented)
                                            <button type="button" class="btn btn-primary rounded-0 my-2" onclick='toggle_review_creation($(this))'>Écrire un commentaire</button>
                                        @endif
                                    </div>
                                </div>
                                @if(Auth::check() && !$has_commented)
                                {{--  Review creation (hidded by default)  --}}
                                <div id='review-creation' class="row m-0 @if (!$errors->any()) d-none @endif">
                                    <div class="col-12 col-lg-8 p-3 border">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        <form action="/nouveau_commentaire/{{$product->id}}" method="POST">
                                        @csrf
                                        <div class="col-12 d-flex p-0">
                                            <div class="form-group pr-4">
                                                <label for="firstname">Votre prénom</label>
                                                <input type="text" value='{{old('firstname', Auth::user()->firstname)}}' class="form-control @error('firstname') is-invalid @enderror" name="firstname" id="firstname" aria-describedby="helpfirstname" placeholder="{{Auth::user()->firstname}}" required>
                                                <small id="helpfirstname" class="form-text text-muted">Votre prénom sera affiché dans la liste des commentaires.</small>
                                                @error('firstname')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">Votre nom de famille</label>
                                                <input type="text" value='{{old('lastname', Auth::user()->lastname)}}' class="form-control @error('lastname') is-invalid @enderror" name="lastname" id="lastname" aria-describedby="helplastname" placeholder="{{Auth::user()->lastname}}">
                                                <small id="helplastname" class="form-text text-muted">Uniquement la première lettre de votre nom sera affiché.</small>
                                                @error('lastname')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Votre adresse mail</label>
                                            <input type="email" value='{{old('email', Auth::user()->email)}}' class="form-control @error('email') is-invalid @enderror" name="email" id="email" aria-describedby="helpemail" placeholder="{{Auth::user()->email}}" required>
                                            <small id="helpemail" class="form-text text-muted">Votre adresse mail ne sera PAS affiché publiquement.</small>
                                            @error('email')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        {{--  Rating stars  --}}
                                        <div class="form-group">
                                            <label for="email">Votre note</label>
                                            <div class='d-flex'>
                                                <div id="rateYo" class='@error('mark') is-invalid @enderror'></div>
                                                <div class="counter d-flex flex-column justify-content-center h4 mb-0"></div>
                                                <input type="hidden" name="mark" id="mark">
                                            </div>

                                            @error('mark')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        
                                        
                                        
                                        <div class="form-group">
                                        <label for="text">Votre commentaire</label>
                                        <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="text" rows="3" placeholder="Écrivez votre petit commentaire 💚" required>{{old('text', '')}}</textarea>
                                        @error('text')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary rounded-0">Envoyer</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                                @if (count($product->reviews) > 0)
                                <div class="row m-0 justify-content-lg-between">
                                    <?php $rate_index = 0; ?>
                                    @foreach ($product->reviews as $review)
                                    <div class="col-12 col-lg-6 p-0 px-lg-2 my-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <p class="card-title mr-auto mb-0">Le {{$review->created_at->formatLocalized('%e %B %Y')}} - {{$review->customerPublicName}}</p>
                                                    @if (Auth::Check())
                                                        @if (Auth::user()->isAdmin && Auth::user()->privileges > 3)
                                                        <form action="/commentaires/supprimer/{{$review->id}}" method='POST'>
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger py-0">Supprimer</button>
                                                        </form>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div id='rate-{{$rate_index}}' class='rate-container d-flex'>
                                                    <div class="static-rate"></div>
                                                        <p class='mark-number mb-0 font-weight-bold d-flex flex-column justify-content-center'>{{$review->mark}}</p>
                                                        <p class='mb-0 d-flex flex-column justify-content-center'> / 5</p>
                                                    </div>
                                                <p class="card-text mb-0">{{$review->text}}</p>
                                                @if ($review->adminResponse != null)
                                                <div class='mt-2 ml-2 pl-2 border-left'>
                                                    <p class='mb-0 font-weight-bold'>Réponse de Bébés Lutins</p>
                                                    <p class='mb-0'>{{$review->adminResponse}}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div> 
                                    </div>
                                    <?php $rate_index++; ?>
                                    @endforeach 
                                </div>
                                @else
                                <p class="card-text p-0 px-lg-2 mt-2">Aucun client n'a posté d'avis pour le moment...</p>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('components.public.popups.add-to-cart')

{{-- Verify characteristics --}}
<script>

    var empty = false;
    $('.characteristic').each(function(){
        
        if ($(this).val().length == 0) {
            empty = true;
        }
    });

    if (empty) {
        $("[data-toggle=popover]").popover("enable");
        $('#add-to-cart').attr('style', 'pointer-events: none;');
        $('#add-to-cart').attr('disabled', 'disabled');
    } else {
        $("[data-toggle=popover]").popover("disable");
        $('#add-to-cart').removeAttr('style', '');
        $('#add-to-cart').removeAttr('disabled');
    }

    $('.characteristic').on('change', function(){
        var empty = false;
        $('.characteristic').each(function(){
            if ($(this).val().length == 0) {
                empty = true;
            }
        });

        if (empty) {
            $("[data-toggle=popover]").popover("enable");
            $('#add-to-cart').attr('style', 'pointer-events: none;');
            $('#add-to-cart').attr('disabled', 'disabled');
        } else {
            $("[data-toggle=popover]").popover("disable");
            $('#add-to-cart').removeAttr('style', '');
            $('#add-to-cart').removeAttr('disabled');
        }
    });

</script>

{{--  Review creation show / hide  --}}
<script>

    $('.rate-container').each(function () {
        $(this).children('.static-rate').rateYo({
            rating: $(this).children('.mark-number').text(),
            readOnly: true
        });
    });

    $('#global-rate-container').children('.static-rate').rateYo({
        rating: $('#global-rate-container').children('.mark-number').text(),
        readOnly: true
    })

    //Statics rating stars
    
    //Rating stars
    $(function () {
 
        $("#rateYo").rateYo({
            starWidth: "30px",
            precision: "1.5",
            rating: "5",
            halfStar: true,
            onInit: function (rating, rateYoInstance) {
                $(this).next().text("5 / 5");
                $('#mark').val('5');
            },
            onChange: function (rating, rateYoInstance) {
                $(this).next().text(rating + " / 5");
            },
            onSet: function (rating, rateYoInstance) {
                $('#mark').val(rating);
            },
        });
    });

    // -----------

    function toggle_review_creation(btn){
        if(btn.text() == "Écrire un commentaire"){
            btn.text("Fermer");
        } else btn.text("Écrire un commentaire");

        $("#review-creation").fadeToggle();
        $("#review-creation").removeClass('d-none')
    }
</script>

{{-- Custom Spinner --}}
<script>
    product_price = {{$product->price}}

    $(".spinnerProduct").inputSpinner();

    $(".spinnerProduct").on("change", function (event) {
        quantity_to_add = $(this).val();
        new_product_price = product_price * quantity_to_add

        if(quantity_to_add > 1) {
            $('#total-product-price').removeClass('d-none');
        } else {
            if(!$('#total-product-price').hasClass('d-none')){
                $('#total-product-price').toggleClass('d-none');
            }
        }

        $('#total-product-price').text(new_product_price.toFixed(2) + ' €')
    })
</script>

{{-- Change main image --}}
<script>
    function change_main_image(img){
        $('#main-image').attr('src', img.attr('src'));
    }
</script>

{{-- Popover init --}}
<script>
    $("[data-toggle=popover]").popover();
</script>
@endsection