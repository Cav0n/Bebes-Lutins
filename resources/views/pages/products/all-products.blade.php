@extends('templates.template')

@section('head-options')
    {{--  All products CSS  --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/products/all-products.css')}}">

@endsection

@section('content')
<main id='all-products-container' class='container-fluid mt-5 mt-md-0'>
    <div class='row justify-content-center m-5'>
        <div class="col-lg-10 mt-5 mt-md-0">
            <span id='breadcrumb'>/ <a href='/' class='text-dark'>Accueil</a> / <a href='/produits' class='text-dark'>Tous nos produits</a></span>
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