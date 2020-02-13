@extends('templates.dashboard')

@section('content')
<div class="row">
    <div class="col-12 pt-3">
        <a href='/dashboard/produits' class='text-muted'>< Tous les produits</a>        
    </div>
</div>
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Produits - Stocks
        </h1>
    </div>
    <div class="card-body">

        @include('components.dashboard.search-bar')

        <div class="row">
            <div class="col-12 d-flex flex-row flex-wrap">
                @foreach (App\Category::where('parent_id', null)->get() as $category)
                    <p class="py-1 px-3 mr-2 bg-light border rounded">{{$category->name}}</p>
                @endforeach
            </div>
        </div>
        {{$products->links()}}
        <table class="table">
            <thead>
                <tr>
                    <th class='border-top-0'>Nom</th>
                    <th class='border-top-0 text-center'>Quantité</th>
                    <th class='border-top-0 text-center'>Mettre à jour la quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td scope="row">{{$product->name}}</td>
                    <td class='text-center'>{{$product->stock}}</td>
                    <td>
                        <form class='d-flex' action="/dashboard/produits/update-stocks" method="POST">
                            <button type="button" class='btn' style="border: 1px solid rgb(220,220,220);border-radius: 2px 0 0 2px;border-right: none;">Ajouter</button>
                            <button type="button" class="btn" style="border: 1px solid rgb(220,220,220);border-radius: 0;border-right:none;">Définir</button>
                            <input type="number" name="quantity" step='1' min="0" style='margin: 0;border: 1px solid rgb(220,220,220);border-right: none; border-radius:0;'>
                            <button type="submit" class="btn btn-primary" style='border-radius: 0 2px 2px 0;'>Modifier</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection