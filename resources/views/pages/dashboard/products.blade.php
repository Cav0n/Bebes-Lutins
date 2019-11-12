@extends('templates.dashboard')

@section('content')

@if(count($productsWithMissingMainImage) > 0)
<div class="card bg-warning my-3">
    <div class="card-header bg-warning d-flex">
        <h1 class='h4 m-0 my-auto font-weight-normal'>
            Certains produits n'ont pas d'images !
        </h1>
    </div>
    <div class="card-body">
        <ul>
            @foreach ($productsWithMissingMainImage as $product)
            <li class='text-muted'>
                <a href='/dashboard/produits/edition/{{$product->id}}' class='text-muted'>
                    {{$product->name}}</a></li>
            @endforeach
        </ul>
        <a href='/dashboard/produits/correction-images' class='btn btn-danger'>Tenter de corriger le problème</a>
    </div>
</div>
@endif

@if(count($productsWithMissingThumbnails) > 0)
<div class="card bg-warning my-3">
    <div class="card-header bg-warning d-flex">
        <h1 class='h4 m-0 my-auto font-weight-normal'>
            Certains produits ont des miniatures incorrectes !
        </h1>
    </div>
    <div class="card-body">
        <ul>
            @foreach ($productsWithMissingThumbnails as $product)
            <li class='text-muted'>
                <a href='/dashboard/produits/edition/{{$product->id}}' class='text-muted'>
                    {{$product->name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="card bg-white my-3">
    <div class="card-header bg-white d-flex">
        <h1 class='h4 m-0 my-auto font-weight-normal'>
            Produits
        </h1>
        <a name="btn-creation" id="btn-creation" class="btn btn-outline-secondary border-0 ml-auto" href="/dashboard/produits/nouveau" role="button">Nouveau</a>
     </div>
    <div class="card-body">
        <div class="row">
            <div class="col-9">
                <div class="form-group">
                    <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher un produit" aria-describedby="helpSearch">
                </div>
            </div>
            <div class="col-3">
                <button type="button" id='search-button' class="btn btn-secondary w-100 border-light ld-over" onclick='search_product()'>
                    Rechercher <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
        </div>
        <div id="products-container">
            <div class="row">
                <div class="col-12 d-flex flex-row flex-wrap">
                    @foreach (App\Category::where('isDeleted', '!=', '1')->orderBy('rank', 'asc')->orderBy('name', 'asc')->get() as $category)
                        <p class="py-1 px-3 mr-2 bg-light border rounded">{{$category->name}}</p>
                    @endforeach
                </div>
            </div>
            {{$products->links()}}
            <table class="table">
                <thead>
                    <tr>
                        <th class='border-top-0'>Nom</th>
                        <th class='border-top-0'>Prix</th>
                        <th class='border-top-0 align-right'>Caché</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr class='@if($product->isHidden){{'hidden'}}@endif' onclick="load_url('/dashboard/produits/edition/' + '{{$product->id}}')">
                        <td scope="row">{{$product->name}}<BR> 
                            @foreach ($product->categories as $category)
                                <small class='text-muted'>{{$category->name}}</small><BR>
                            @endforeach
                        </td>
                        <td>{{$product->price}}€</td>
                        <td><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "{{$product->id}}")' @if($product->isHidden) {{'checked'}} @endif></div></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id='search-container'>
            <h2 class='h4'>Résultats</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th class='border-top-0'>Nom</th>
                        <th class='border-top-0'>Prix</th>
                        <th class='border-top-0 align-right'>Caché</th>
                    </tr>
                </thead>
                <tbody id='search-table-body'>

                </tbody>
            </table>
            <h2 class='h4 mt-3'>Autres résultats</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th class='border-top-0'>Nom</th>
                        <th class='border-top-0'>Prix</th>
                        <th class='border-top-0 align-right'>Caché</th>
                    </tr>
                </thead>
                <tbody id='search-possible-table-body'>

                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- PREPARE AJAX --}}
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

{{-- SEARCH PRODUCT AJAX --}}
<script>

    $("#products-container").show();
    $("#search-container").hide();

    $("#search-bar").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#search-button").click();
        }
    });
            
    function search_product(){
        search = $("#search-bar").val();
        button = $("#search-button");

        if(search != ""){
            $.ajax({
                url : '/dashboard/produits/recherche', // on appelle le script JSON
                type: "POST",
                dataType : 'json', // on spécifie bien que le type de données est en JSON
                data : {
                    search: search
                },
                beforeSend: function(){
                    button.addClass('running');
                },
                success : function(data){
                    $("#products-container").hide();
                    $("#search-container").show();
                    $("#search-table-body").empty();
                    $("#search-possible-table-body").empty();

                    $.each(data.valid_products, function(index, product){
                        console.log(product);
                        product_html = `
                            <tr `;
                        if(product.isHidden == 1) product_html = product_html + "class='hidden'";
                        product_html = product_html + `onclick="load_url('/dashboard/produits/edition/`+ product.id +`')">
                            <td scope="row">`+ product.name +`<BR>`;

                        $.each(product.categories, function(index, category){
                            console.log()
                            product_html = product_html + `<small class='text-muted'>`+category.name+`</small><BR>`;
                        });

                        product_html = product_html + `
                                </td>
                                <td>`+ product.price +`€</td>
                                <td><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "`+ product.id +`")'`;
                        if(product.isHidden == 1) product_html = product_html + `checked </div></td>`;
                        product_html = product_html +`</tr>`;

                        $("#search-table-body").append(product_html);
                    });

                    $.each(data.possible_products, function(index, product){
                        console.log(product);
                        product_html = `
                            <tr onclick="load_url('/dashboard/produits/edition/`+ product.id +`')">
                                <td scope="row">`+ product.name +`<BR>`;

                        $.each(product.categories, function(index, category){
                            console.log()
                            product_html = product_html + `<small class='text-muted'>`+category.name+`</small><BR>`;
                        });

                        product_html = product_html + `
                                </td>
                                <td>`+ product.price +`€</td>
                                <td><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "`+ product.id +`")'`;
                        if(product.isHidden == 1) product_html = product_html + `checked </div></td>`;
                        product_html = product_html +`</tr>`;

                        $("#search-possible-table-body").append(product_html);
                    });

                    button.removeClass('running');
                }
            });
        } else {
            $("#products-container").show();
            $("#search-container").hide();
        }
    }
</script>

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
        checkbox.parent().parent().parent().toggleClass('hidden');
    });
}
</script>
@endsection