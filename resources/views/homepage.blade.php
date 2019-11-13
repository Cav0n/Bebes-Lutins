@extends('templates.template')

@section('head-options')
    {{-- Swiper JS --}}
    <script src="{{asset('js/swiper/swiper.min.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/swiper/swiper.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<main class='container-fluid mt-3 mt-md-0'>

    {{-- Swiper --}}
    @include('layouts.public.main-swiper')

    <div class='row justify-content-center mx-md-5 mt-md-4'>
        <div class="col-lg-10 mt-md-0">
            <div class="row justify-content-lg-center">

                {{-- Presentation --}}
                <div class='col-12'>
                    <h2 class='h3 font-weight-bold'>Bébés Lutins, le spécialiste de la couche lavable écologique et écocitoyenne pour bébé.</h4>
                </div>
                <div class="col-12">
                    <p class='text-justify'>Bébés Lutins vous propose sa gamme de couches lavables pour bébé et accessoires, confectionnés en France par nos couturières.
                        Nous sélectionnons soigneusement les tissus certifiés Oeko-Tex pour offrir une couche lavable écologique qui respecte la peau de
                        bébé. Nos modèles sont conçus pour s'adapter à la morphologie de bébé, tout en lui offrant confort et bien-être.</p>
                </div>

                {{-- Highlighted Products --}}
                @if(App\Product::where('isHighlighted', 1)->where('isHidden', 0)->where('isDeleted', 0)->exists())

                @foreach (App\Product::where('isHighlighted', 1)->where('isHidden', 0)->where('isDeleted', 0)->get()->take(8) as $product)
                    @include('components.public.product-display')
                @endforeach

                @else

                @foreach (App\Product::where('isHidden', 0)->where('isDeleted', 0)->get()->take(8) as $product)
                    @include('components.public.product-display')
                @endforeach

                @endif
                

                {{-- All products buttons --}}
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col col-sm-4 col-md-4 col-lg-6">
                            <a name="all-products-button" id="all-products-button" class="btn btn-light w-100 border rounded-0" href="/produits" role="button">Tous nos produits ></a>
                        </div>
                    </div>
                </div>

                {{-- Certifications --}}
                <div class="col-12 mt-4 my-md-4 my-lg-4 p-0 bg-light">
                    @include('components.public.certifications')
                </div>

            </div>
        </div>
    </div>
</main>

@include('components.public.popups.add-to-cart')

<script>
    $(document).ready(function(){
        card_product = $('.images-container');

        card_product.children('.main-image').show();
        card_product.children('.thumbnail').hide();

        card_product.mouseenter(function(){
            if(!$(this).hasClass('no-thumbnails')){
                $(this).children('.main-image').hide();
                $(this).children('.thumbnail').removeClass('d-none');
                $(this).children('.thumbnail').show();
            }
        }).mouseleave(function(){
            if(!$(this).hasClass('no-thumbnails')){
                $(this).children('.thumbnail').hide();
                $(this).children('.thumbnail').addClass('d-none');
                $(this).children('.main-image').show();
            }
        });
    });
</script>
@endsection