@extends('templates.template')

@section('head-options')
    {{-- Swiper JS --}}
    <script src="{{asset('js/swiper/swiper.min.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/swiper/swiper.css')}}">
@endsection

@section('content')
<main class='container-fluid mt-3 mt-md-0'>
    @include('layouts.public.main-swiper')

    <div class='row justify-content-center mx-md-5 mt-lg-4'>
        <div class="col-lg-10 mt-md-0">
            <div class="row justify-content-lg-center">
                <div class='col-12'>
                    <h2 class='h3 font-weight-bold'>Bébés Lutins, le spécialiste de la couche lavable écologique et écocitoyenne pour bébé.</h4>
                </div>
                <div class="col-12">
                    <p class='text-justify'>Bébés Lutins vous propose sa gamme de couches lavables pour bébé et accessoires, confectionnés en France par nos couturières.
                        Nous sélectionnons soigneusement les tissus certifiés Oeko-Tex pour offrir une couche lavable écologique qui respecte la peau de
                        bébé. Nos modèles sont conçus pour s'adapter à la morphologie de bébé, tout en lui offrant confort et bien-être.</p>
                </div>
                @foreach (App\Product::all()->take(8) as $product)
                    <div class="col-6 col-sm-4 col-md-4 col-lg-3" onclick='load_url("/produits/{{$product->id}}")'>
                        <div class="card product my-2">
                            <img class="card-img-top main-image" src="{{asset('images/products/'.$product->mainImage)}}" alt="{{$product->name}}" title="{{$product->name}}">
                            <img class='card-img-top thumbnail' src="{{asset('images/utils/question-mark.png')}}">
                            <div class="card-body">
                                <p class="card-text">{{$product->name}}</p>
                            </div>
                            <div class="card-footer text-muted">
                                {{$product->price}}
                            </div>
                        </div> 
                    </div>
                @endforeach
                <div class="col-12 my-4">
                    <div class="row justify-content-center">
                        <div class="col col-md-3">
                            <a name="all-products-button" id="all-products-button" class="btn btn-light w-100" href="/produits" role="button">Tous nos produits</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function(){
        card_product = $('.card.product');

        card_product.children('.main-image').show();
        card_product.children('.thumbnail').hide();

        card_product.hover(function(){
            $(this).children('.main-image').hide();
            $(this).children('.thumbnail').show();
        }).mouseleave(function(){
            $(this).children('.thumbnail').hide();
            $(this).children('.main-image').show();
        });
    });
</script>
@endsection