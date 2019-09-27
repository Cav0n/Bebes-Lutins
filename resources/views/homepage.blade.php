@extends('templates.template')

@section('head-options')
    {{-- Swiper JS --}}
    <script src="{{asset('js/swiper/swiper.min.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/swiper/swiper.css')}}">
@endsection

@section('content')
<main class='container-fluid mt-3 mt-md-0'>
    @include('layouts.public.main-swiper')

    <div class='row justify-content-center mx-md-5 mt-md-4'>
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
                    @include('components.public.product-display')
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

<div id='add_to_cart_popup_container' class='popup-container row justify-content-center fixed-top d-none'>
    <div id='add_to_cart_popup' class='popup m-auto p-3 bg-light col-6 h-25'>
        <p class='popup_title h3'>.. a été ajouté à votre panier</p>
        <p class='popup_description'>Vous avez ajouté .. à votre panier, souhaitez vous poursuivre vos achats ou accéder à votre panier ?</p>
        <div class='button-container d-flex'>
            <button type="button" class="btn btn-primary rounded-0 ml-auto" onclick='dissmiss_popup()'>Poursuivre mes achats</button>
            <button type="button" class="btn btn-secondary rounded-0">Accéder a mon panier</button>
        </div>
    </div>
</div>

<script>
function add_to_cart(product_id, product_name)
{
    popup_container = $('#add_to_cart_popup_container');
    popup_container.removeClass('d-none');
    popup_container.children('#add_to_cart_popup').children('.popup_title').text(
        product_name + ' a été ajouté à votre panier'
    );
    popup_container.children('#add_to_cart_popup').children('.popup_description').text(
        'Vous avez ajouté '+ product_name +' à votre panier, souhaitez vous poursuivre vos achats ou accéder à votre panier ?'
    );
}

function dissmiss_popup()
{
    popup_container = $('#add_to_cart_popup_container');
    popup_container.addClass('d-none');
}
</script>

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