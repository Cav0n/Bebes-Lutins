@php
    $products = App\Product::all();
@endphp

@extends('templates.default')

@section('title', "Accueil - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5">
            <h1 class="h1 font-weight-bold">
                Bébés Lutins, le spécialiste de la couche lavable écologique et écocitoyenne pour bébé.
            </h1>
            <p class="h5">
                Bébés Lutins vous propose sa gamme de couches lavables pour bébé et accessoires,
                confectionnés en France par nos couturières. Nous sélectionnons soigneusement les tissus
                certifiés Oeko-Tex pour offrir une couche lavable écologique qui respecte la peau de bébé.
                Nos modèles sont conçus pour s'adapter à la morphologie de bébé, tout en lui offrant confort
                et bien-être.
            </p>

            @include('components.utils.products.highlighted_products')
            @include('components.modal.product_added_to_cart')

            @include('components.utils.certifications.default')
        </div>
    </div>
</div>

@endsection
