@extends('templates.template')

@section('head-options')
    {{--  All products CSS  --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/products/all-products.css')}}">

@endsection

@section('content')
<main id='all-products-container' class='container-fluid'>
    <div class='row justify-content-center'>
        <div class="col-12 col-md-10 mt-2 mt-md-4">
            <span id='breadcrumb' class='small d-none d-md-block'>/ <a href='/' class='text-dark'>Accueil</a> / <a href='/produits' class='text-dark'>Tous nos produits</a></span>
            <a href='/' class='text-muted d-block d-md-none'>< Accueil</a>
            <h1>Tous nos produits</h1>
            <div class="row">
                <div class="col-12 d-inline-flex flex-wrap">
                    @foreach (App\Category::where('isHidden', 0)->where('parent_id', null)->get() as $category)
                        <p class='category-selector transition-fast px-3 py-1 bg-light my-1 mr-2 ml-0 rounded' onclick='switch_category($(this),"{{$category->id}}")'>{{$category->name}}</p>
                    @endforeach
                </div>
            </div>
            {{ $products->links() }}
            <div id='products' class="row">
                @foreach ($products as $product)
                    @include('components.public.product-display')
                @endforeach
            </div>
        </div>
    </div>
</main>

<script>
function switch_category(selector, category){
    selector.toggleClass('selected');
}
</script>
@endsection