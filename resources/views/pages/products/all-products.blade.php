@extends('templates.template')

@section('head-options')
    {{--  All products CSS  --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/products/all-products.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<main id='all-products-container' class='container-fluid'>
    <div class='row justify-content-center'>
        <div class="col-12 col-md-10 mt-2 mt-md-4">

            {{-- Breadcrumb --}}
            <span id='breadcrumb' class='small d-none d-md-block'>/ <a href='/' class='text-dark'>Accueil</a> / <a href='/produits' class='text-dark'>Tous nos produits</a></span>

            {{-- Mobile back button --}}
            <a href='/' class='text-muted d-block d-md-none'>< Accueil</a>

            {{-- All products --}}
            <h1>Tous nos produits</h1>
            {{-- Categories selectors --}}
            <div class="row">
                <div class="col-12 d-inline-flex flex-wrap">
                    @foreach (App\Category::where('isHidden', 0)->where('parent_id', null)->get() as $category)
                        <p class='category-selector transition-fast px-3 py-1 bg-light my-1 mr-2 ml-0 rounded @if(session()->has('selected-categories')) @if(in_array($category->id, session('selected-categories'))) selected  @endif @endif' onclick='switch_category($(this),"{{$category->id}}")'>{{$category->name}}</p>
                    @endforeach
                </div>
            </div>
            {{-- Products --}}
            {{ $products->links() }}
            <div id='products' class="row my-3">
                @foreach ($products as $product)
                    
                        @include('components.public.product-display')

                @endforeach
            </div>
        </div>
    </div>
</main>

@include('components.public.popups.add-to-cart')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function switch_category(selector, category){
        if(!selector.hasClass('selected')){
            $.ajax({
            url: "/produits/selectionner_categorie/" + category,
            type: 'POST',
            data: { },
            success: function(data){
                console.log('Produit bien retiré du panier.');
                document.location.href = '/produits'
            },
            beforeSend: function() {
                //selector.addClass('running');
            }
            })
            .done(function( data ) {
                
            }); 
        }
        else {
            $.ajax({
            url: "/produits/deselectionner_categorie/" + category,
            type: 'POST',
            data: { },
            success: function(data){
                console.log('Produit bien retiré du panier.');
                document.location.href = '/produits'
            },
            beforeSend: function() {
                //selector.addClass('running');
            }
            })
            .done(function( data ) {
                
            }); 
        }
        selector.toggleClass('selected');
        
    }
</script>
@endsection