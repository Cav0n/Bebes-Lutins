@extends('templates.template')

@section('head-options')
    {{-- Swiper JS --}}
    <script src="{{asset('js/swiper/swiper.min.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/swiper/swiper.css')}}">
@endsection

@section('content')
<main class='container-fluid mt-5 mt-md-0'>
    <div id='swiper-container' class="row d-none d-md-flex">
        @include('layouts.public.main-swiper')
    </div>

    <div class='row justify-content-center m-5'>
        <div class="col-lg-10 mt-5 mt-md-0">
            <div class="row">
                <div class='col-12'>
                    <h4>Bébés Lutins, le spécialiste de la couche lavable écologique et écocitoyenne pour bébé.</h4>
                </div>
                <div class="col-12">
                    <p class='text-justify'>Bébés Lutins vous propose sa gamme de couches lavables pour bébé et accessoires, confectionnés en France par nos couturières.
                        Nous sélectionnons soigneusement les tissus certifiés Oeko-Tex pour offrir une couche lavable écologique qui respecte la peau de
                        bébé. Nos modèles sont conçus pour s'adapter à la morphologie de bébé, tout en lui offrant confort et bien-être.</p>
                </div>
                @foreach (App\Product::all()->take(8) as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card my-2">
                            <img class="card-img-top" src="{{asset('images/utils/question-mark.png')}}" alt="question-mark">
                            <div class="card-body">
                                <p class="card-text">{{$product->name}}</p>
                            </div>
                            <div class="card-footer text-muted">
                                {{$product->price}}
                            </div>
                        </div> 
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</main>
@endsection