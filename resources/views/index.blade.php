@php
    $products = App\Product::all();
@endphp

@extends('templates.default')

@section('title', "Accueil - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5">

            <div id="mainCarousel" class="carousel slide text-dark" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    @php
                        $index = 0;
                    @endphp
                    @foreach (\App\CarouselItem::all() as $item)
                    <div class="carousel-item @if(0==$index) active @endif">
                        <img src="{{$item->image->url}}" alt="{{$item->image->name}}">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="text-dark">{{$item->title}}</h5>
                            <p class="text-dark">{{$item->description}}</p>
                        </div>
                    </div>
                    @php
                        $index++;
                    @endphp
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#mainCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#mainCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
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
        $('.carousel').carousel();
    });
</script>
@endsection
