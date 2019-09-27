@extends('templates.template')

@section('content')

<main id='category-main' class='container-fluid my-4 px-4'>
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
        <div class="col-12">
            <h1 class='w-75'>{{$category->name}}</h1>
        </div>
        <div class="col-12">
            <p class='w-75'>{{$category->description}}</p>
        </div>
    </div>
    
    <div class='row'>
        @foreach (App\Category::where('parent_id', $category->id)->get() as $child)
        <div class="card m-2" style="width:12rem;cursor:pointer" onclick='load_url("/categories/{{$child->id}}")'>
            <img src="{{asset('images/categories/'. $child->mainImage)}}" class="card-img-top" alt="catégorie">
            <div class="card-body p-3">
                <a class="card-text text-dark" href='/categories/{{$child->id}}'>{{$child->name}}</a>
            </div>
        </div>
        @endforeach
    </div>

    @if ($category->products != null)
        <div id='products' class='row'>
        @foreach ($category->products as $product)
        @include('components.public.product-display')
        @endforeach
        </div>
    @endif
</main>

@endsection