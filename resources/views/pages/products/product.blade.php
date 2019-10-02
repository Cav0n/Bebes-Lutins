@extends('templates.template')

@section('head-options')
    {{--  Rate Yo  --}}
    <script src="{{asset('js/rateyo/rateyo.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/rateyo/rateyo.css')}}">
@endsection

@section('content')
<main id='product-main' class='container-fluid my-3'>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="row m-0">
                {{-- Breadcrumb --}}
                <div class="col-lg-12 p-0 my-3 d-none d-lg-flex justify-content-center">
                    @include('layouts.public.breadcrumb-product')
                </div>

                {{-- Image, title and buttons --}}
                <div class="col-lg-12 p-0">
                    <div class="row m-0">

                        {{--  Thumbnails  --}}
                        <div class="col-lg-1 p-0 d-flex flex-column pr-3">
                            <div class='thumbnail-container'>
                                <img class='w-100 h-100 border' onclick="change_main_image($(this))" src="{{asset('images/products/' . $product->mainImage)}}" style='object-fit;cursor:pointer;'>
                            </div>
                            @foreach ($product->images as $image)
                            <div class='thumbnail-container pt-2'>
                                <img class='w-100 h-100 border' onclick="change_main_image($(this))" src="{{asset('images/products/thumbnails/' . $image->name)}}" style='object-fit;cursor:pointer;'>
                            </div>
                            @endforeach
                        </div>

                        {{--  Product infos  --}}
                        <div class="col-lg-11 p-0 border" style='height:intrinsic'>
                            <div class="row m-0">
                                <div class="col-lg-4 p-0">
                                    <img id='main-image' class="w-100 h-100" src="{{asset('images/products/' . $product->mainImage)}}" style='object-fit:cover'>
                                </div>
                                <div class="col-lg-8 p-0 p-lg-3 d-flex flex-column justify-content-between">
                                    <div class="row m-0">
                                        {{--  Title  --}}
                                        <div class="col-lg-12 p-0">
                                            <h1 class="h3 mb-0">{{$product->name}}</h1>
                                        </div>
                                        {{--  Price  --}}
                                        <div class="col-lg-12 p-0 mt-2">
                                            <div class="row m-0">
                                                <div class="col-5 p-0 pr-2">
                                                    <p id='product-price' class="text-left mb-0">Prix : {{number_format($product->price, 2)}} €</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        {{--  Quantity selector  --}}
                                        <div class="col-lg-12 p-0 my-2">
                                            <div class="row m-0">
                                                <div class="col-5 p-0 pr-2">
                                                    <input id="item-quantity" class="spinner" type="number" name="quantity" value="1" min="1" max="{{$product->stock}}" step="1" @if($product->stock <= 1) disabled @endif />                                            
                                                </div>
                                                <div class="col-7 p-0 d-flex flex-column justify-content-center">
                                                    <p id='total-product-price' class="text-left mb-0 d-none">Prix total : {{number_format($product->price, 2)}} €</p>
                                                </div>
                                            </div>
                                        </div>
                                        {{--  Buttons  --}}
                                        <div class="col-lg-12 p-0 mt-2">
                                            <div class="row m-0">
                                                <div class="col-5 p-0 pr-2">
                                                    <button type="button" class="btn bg-white border-primary rounded-0 w-100">Ajouter au panier</button>
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
                <div class="col-lg-12 p-0 border mt-4">
                    <div class="card rounded-0 border-0">
                        <div class="card-body p-0 p-lg-3">
                            <h4 class="card-title px-0 px-lg-2 d-none d-lg-flex">Description</h4>
                            <p class="card-text px-0 px-lg-2">{{$product->description}}</p>
                        </div>
                    </div>
                </div>

                {{-- Avis clients --}}
                <div class="col-lg-12 p-0 border mt-4">
                    <div class="card rounded-0 border-0">
                        <div class="card-body p-0 p-lg-3">
                            <h4 class="card-title px-0 px-lg-2">{{count($product->reviews)}} avis clients</h4>

                            
                            <div class="col-12 p-0">
                                {{-- Review global mark and create button --}}
                                <div class="row m-0">
                                    <div class="col-12 col-lg-4 p-0 px-lg-2">
                                        @if (count($product->reviews) > 0)
                                        <span class='d-flex'>
                                            <p class="h3 mb-0">4,4</p> <p class='d-flex flex-column justify-content-end mb-0'>sur 5</p>
                                        </span>
                                        @endif
                                        <button type="button" class="btn btn-primary rounded-0 my-2" onclick='toggle_review_creation($(this))'>Écrire un commentaire</button>
                                    </div>
                                </div>
                                {{--  Review creation (hidded by default)  --}}
                                <div id='review-creation' class="row m-0">
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="col-12 col-lg-8 p-3 border">
                                        <form action="/nouveau_commentaire/{{$product->id}}" method="POST">
                                        @csrf
                                        <div class="col-12 d-flex p-0">
                                            <div class="form-group pr-4 @error('firstname') is-invalid @enderror">
                                                <label for="firstname">Votre prénom</label>
                                                <input type="text" value='{{old('firstname', '')}}' class="form-control" name="firstname" id="firstname" aria-describedby="helpfirstname" placeholder="Jean" required>
                                                <small id="helpfirstname" class="form-text text-muted">Votre prénom sera affiché dans la liste des commentaires.</small>
                                                @error('firstname')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group" @error('lastname') is-invalid @enderror>
                                                <label for="lastname">Votre nom de famille</label>
                                                <input type="text" value='{{old('lastname', '')}}' class="form-control" name="lastname" id="lastname" aria-describedby="helplastname" placeholder="Dupont">
                                                <small id="helplastname" class="form-text text-muted">Uniquement la première lettre de votre nom sera affiché.</small>
                                                @error('lastname')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group @error('email') is-invalid @enderror">
                                            <label for="email">Votre adresse mail</label>
                                            <input type="email" value='{{old('email', '')}}' class="form-control" name="email" id="email" aria-describedby="helpemail" placeholder="jeandupont@gmail.com" required>
                                            <small id="helpemail" class="form-text text-muted">Votre adresse mail ne sera PAS affiché publiquement.</small>
                                            @error('email')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        {{--  Rating stars  --}}
                                        <div class="form-group @error('mark') is-invalid @enderror">
                                            <label for="email">Votre note</label>
                                            <div id="rateYo"></div>
                                            @error('mark')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        
                                        
                                        
                                        <div class="form-group @error('text') is-invalid @enderror">
                                        <label for="text">Votre commentaire</label>
                                        <textarea class="form-control" name="text" id="text" rows="3" placeholder="Écrivez votre petit commentaire 💚" required>{{old('text', '')}}</textarea>
                                        @error('message')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary rounded-0">Envoyer</button>
                                        </form>
                                    </div>
                                </div>
                                @if (count($product->reviews) > 0)
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
                                @else
                                <p class="card-text p-0 px-lg-2 mt-2">Aucun client n'a posté d'avis pour le moment... 😢</p>
                                @endif
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{--  Review creation show / hide  --}}
<script>
    //Rating stars
    $(function () {
 
        $("#rateYo").rateYo({
            starWidth: "30px",
            precision: "1.5",
            halfStar: true,
        });

    });

    // -----------

    $("#review-creation").hide();

    function toggle_review_creation(btn){
        console.log(btn.text())

        if(btn.text() == "Écrire un commentaire"){
            btn.text("Fermer");
        } else btn.text("Écrire un commentaire");

        $("#review-creation").fadeToggle();
    }
</script>

{{-- Custom Spinner --}}
<script>
    product_price = {{$product->price}}

    $(".spinner").inputSpinner();

    $(".spinner").on("change", function (event) {
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

@endsection