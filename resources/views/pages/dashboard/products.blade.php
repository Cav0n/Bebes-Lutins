@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white d-flex">
        <h1 class='h4 m-0 my-auto font-weight-normal'>
            Produits
        </h1>
        <a name="btn-creation" id="btn-creation" class="btn btn-primary border-light ml-auto" href="/dashboard/produits/nouveau" role="button">Nouveau</a>
     </div>
    <div class="card-body">
        <form action="/dashboard/produits/recherche" method="POST">
            <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher un produit" aria-describedby="helpSearch">
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-secondary w-100 border-light">Rechercher</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12 d-flex flex-row flex-wrap">
                @foreach (App\Category::where('parent_id', null)->get() as $category)
                    <p class="py-1 px-3 mr-2 bg-light border rounded">{{$category->name}}</p>
                @endforeach
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th class='border-top-0'>Nom</th>
                    <th class='border-top-0'>Prix</th>
                    <th class='border-top-0 align-right'>Caché</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Product::all() as $product)
                <tr class='@if($product->isHidden){{'hidden'}}@endif'>
                    <td scope="row">{{$product->name}}<BR> 
                        @foreach ($product->categories as $category)
                            {{$category->name}}
                        @endforeach
                    </td>
                    <td>{{$product->price}}€</td>
                    <td><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "{{$product->id}}")' @if($product->isHidden) {{'checked'}} @endif></div></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function switch_isHidden(checkbox, product_id){
    $.ajax({
        url: "/dashboard/switch_is_hidden_product/"+product_id,
        beforeSend: function() {
            init_loading();
        }
    })
    .done(function( data ) {
        stop_loading();
        checkbox.parent().parent().toggleClass('hidden');
    });
}
</script>
@endsection