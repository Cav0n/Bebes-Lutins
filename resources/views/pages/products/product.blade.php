@extends('templates.template')

@section('content')
<main id='product-main' class='container-fluid my-4 px-4'>
    <div class="row">
        <div class="col-12">
            @include('layouts.public.breadcrumb-product')
        </div>
    </div>
    <div class='row'>
        <div class="col">
            <h1>{{$product->name}}</h1>
        </div>
    </div>
</main>
@endsection