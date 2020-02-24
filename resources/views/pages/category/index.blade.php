@extends('templates.default')

@section('title', $category->name . " - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <p>{!! $category->breadcrumb !!}</p>
            <h1>{{$category->name}}</h1>
            <p>{{$category->description}}</p>

            <div id="child-container" class="row">
                @foreach ($category->childs as $child)
                <div class="col-xl-3">
                    <div class="card sub-category">
                        <img src="{{ asset('images/utils/question-mark.png') }}" alt="" class="card-img-top">
                        <div class="card-body">
                            <a href="{{ route('category', ['category' => $child->id]) }}" class="card-text">{{$child->name}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div id="product-container" class="row">
                @foreach ($category->products as $product)
                    @include('components.utils.products.simple_product')
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
