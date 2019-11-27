@extends('templates.template')

@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<main id='category-main' class='container-fluid my-4 px-4'>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-12">
                    <p>
                        <a href='/'>Accueil</a>
                        @foreach ($category->generateBreadcrumb() as $item)
                            / <a href='/categories/{{$item->id}}'>{{$item->name}}</a>
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-10 col-md-8 col-lg-7">
                    <h1 class='w-100 font-weight-bold'>{{$category->name}}</h1>
                </div>
                <div class="col-12 col-sm-10 col-md-8 col-lg-7">
                    <p class='w-100 text-justify small'>{{$category->description}}</p>
                </div>
            </div>
            
            <div class='row'>
                @foreach (App\Category::where('parent_id', $category->id)->where('isHidden', 0)->where('isDeleted',0)->get() as $child)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0">
                    <div class="card m-2" style="cursor:pointer" onclick='load_url("/categories/{{$child->id}}")'>
                        <img src="{{asset('images/categories/'. $child->mainImage)}}" class="card-img-top" alt="catégorie">
                        <div class="card-body p-3">
                            <a class="card-text text-dark" href='/categories/{{$child->id}}'>{{$child->name}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        
            @if ($category->products != null)
                <div id='products' class='row'>
                    <div class="col-12 d-flex flex-wrap">
                        @foreach ($category->products as $product)
                            @if($product->isHidden == 0 && $product->isDeleted == 0)
                            @include('components.public.product-display')
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

</main>

@include('components.public.popups.add-to-cart')

@endsection