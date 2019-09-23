@extends('templates.template')

@section('content')
<main id='product-main' class='container-fluid my-4 px-4' style='min-height:90vh;'>
    <div class='row'>
        <div class="col">
            <h1>{{$product->name}}</h1>
        </div>
    </div>
</main>
@endsection