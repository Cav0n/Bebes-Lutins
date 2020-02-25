@php
    $products = App\Product::all();
@endphp

@extends('templates.default')

@section('title', "Accueil - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5">

            <!-- Slider main container -->
            <div class="swiper-container d-none d-lg-flex">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide"><img src="{{ asset('images/caroussel/1.jpg') }}" alt="Caroussel"></div>
                    <div class="swiper-slide"><img src="{{ asset('images/caroussel/2.jpg') }}" alt="Caroussel"></div>
                    <div class="swiper-slide"><img src="{{ asset('images/caroussel/3.jpg') }}" alt="Caroussel"></div>
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar"></div>
            </div>

            <h1 class="h1 font-weight-bold">
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
<script src='{{asset('js/swiper.js')}}'></script>
<script>
    $(document).ready(function () {
        //initialize swiper when document ready
        var mySwiper = new Swiper.default('.swiper-container', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            observer: true,
            observeParents: true
        })
    });
</script>
@endsection
