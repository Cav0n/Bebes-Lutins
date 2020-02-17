@extends('templates.default')

@section('title', $product->name . " - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <p>{!! $product->breadcrumb !!}</p>
            <h1>{{$product->name}}</h1>
            <p>{{$product->description}}</p>
        </div>
    </div>
</div>

@endsection
