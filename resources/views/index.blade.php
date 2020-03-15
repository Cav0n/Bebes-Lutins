@php
    $products = App\Product::all();
    $carouselItems = \App\CarouselItem::all();
@endphp

@extends('templates.default')

@section('title', "Accueil - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">

            @include('components.utils.carousel.main')

            <h1 class="h1 font-weight-bolder">
                Bébés Lutins, le spécialiste de la couche lavable écologique et écocitoyenne pour bébé.
            </h1>
            <p class="h5 text-justify">
                Bébés Lutins vous propose sa gamme de couches lavables pour bébé et accessoires,
                confectionnés en France par nos couturières. Nous sélectionnons soigneusement les tissus
                certifiés Oeko-Tex pour offrir une couche lavable écologique qui respecte la peau de bébé.
                Nos modèles sont conçus pour s'adapter à la morphologie de bébé, tout en lui offrant confort
                et bien-être.
            </p>

            @include('components.utils.products.highlighted_products')

            @include('components.utils.certifications.default')
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.carousel').carousel();
    });
</script>
@endsection
