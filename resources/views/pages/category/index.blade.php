@extends('templates.default')

@section('title', $category->name . " - Bébés Lutins")

@section('content')

<div class="container-fluid pt-3 pb-5 py-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">

            <div id="category-cover" class="w-100 p-3 text-white">
                <p class="col-md-6 mb-0 pt-5 pt-lg-0">{!! $category->breadcrumb !!}</p>
                <h1 class="col-md-6">{{$category->name}}</h1>
                <p class="col-md-6 text-justify">{{$category->description}}</p>
            </div>

            <div id="category-inner-container" class="px-3">
                @if($category->products->count())
                    <div id="product-container" class="row mb-3">
                        @foreach ($category->products as $product)
                            @include('components.utils.products.simple_product')
                        @endforeach
                    </div>
                @endif

                @if($category->childs->count())
                    <h2>Sous catégories</h2>
                    <div id="child-container" class="row">
                        @foreach ($category->childs as $child)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card sub-category">
                                <img src="{{ asset('images/utils/question-mark.png') }}" alt="" class="card-img-top">
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
