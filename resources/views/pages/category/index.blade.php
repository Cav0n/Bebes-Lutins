@extends('templates.default')

@section('optional_og')
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $category->name }}" />
<meta property="og:description" content="{{ $category->description }}" />
<meta property="og:image" content="{{ asset('images/utils/categories_cover.jpg') }}" />
<meta property="og:url" content="{{ route('category', ['category' => $category]) }}" />
<meta property="og:site_name" content="Bébés Lutins" />
@endsection

@section('title', $category->name . " - Bébés Lutins")

@section('content')

<div class="container-fluid pt-3 pb-5 py-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">

            <div id="category-cover" class="w-100 p-3 text-white">
                <p id="category-breadcrumb" class="col-12 mb-0">{!! $category->breadcrumb !!}</p>
                <h1 class="col-md-6">{{$category->name}}</h1>
                <p class="col-md-6 text-justify">{{$category->description}}</p>
            </div>

            <div id="category-inner-container" class="px-3">
                @if($category->products->count())
                    <div id="product-container" class="row mb-3">
                        @foreach ($category->products()->where('isDeleted', 0)->where('isHidden', 0)->get() as $product)
                            @include('components.utils.products.simple_product')
                        @endforeach
                    </div>
                @endif

                @if($category->childs->count())
                    <div id="child-container" class="row">
                        @foreach ($category->childs()->where('isDeleted', 0)->where('isHidden', 0)->get() as $child)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card sub-category">
                                <img src="{{ asset($child->images()->exists() ? $child->images()->first()->url : null) }}" alt="" class="card-img-top">
                                <div class="card-body">
                                    <a href="{{ route('category', ['category' => $child->id]) }}" class="card-text">{{$child->name}}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
