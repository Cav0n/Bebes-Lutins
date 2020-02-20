@extends('templates.default')

@section('title', $category->name . " - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <p>{!! $category->breadcrumb !!}</p>
            <h1>{{$category->name}}</h1>
            <p>{{$category->description}}</p>

            <div id="product-container" class="row">
                @foreach ($category->products as $product)
                    @include('components.utils.products.simple_product')
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
