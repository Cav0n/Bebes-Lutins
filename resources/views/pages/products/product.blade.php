@extends('templates.template')

@section('content')
<main id='product-main' class='container-fluid my-4 px-4' style='min-height:90vh;'>
    <div class="row">
        <div class="col-12">
            <span>
                <a href='/'>Accueil</a>
                @foreach ($category->generateBreadcrumb() as $item)
                    / <a href='/categories/{{$item->id}}'>{{$item->name}}</a>
                @endforeach
                / <a href='/produits/{{$category->id}}/{{$product->id}}'>{{$product->name}}</a>
            </span>
        </div>
    </div>
    <div class='row'>
        <div class="col">
            <h1>{{$product->name}}</h1>
        </div>
    </div>
</main>
@endsection