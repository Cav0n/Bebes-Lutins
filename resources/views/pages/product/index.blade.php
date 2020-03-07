@extends('templates.default')

@section('title', $product->name . " - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5 row">
            <div class="col-6">
                @include('components.utils.carousel.product')
            </div>
            <div class="col-6">
                <p>{!! $product->breadcrumb !!}</p>
                <h1>{{$product->name}}</h1>
                <p>{{$product->description}}</p>
            </div>
        </div>
    </div>
</div>

@endsection
