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
            <div class="col">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="search" name="search" id="search-bar" class="form-control" placeholder="Rechercher un produit" aria-describedby="helpSearch">

                        <div class="input-group-append">
                            <button id='search-button' class="btn btn-secondary d-flex flex-column justify-content-center ld-over" type="button" onclick='search_product()'>
                                <p class='d-none d-sm-flex mb-0'>Rechercher</p>
                                <img class='d-flex d-sm-none svg' style="fill:grey" src='{{asset('images/icons/search.svg')}}'>
                                <div class="ld ld-ring ld-spin"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex flex-row flex-wrap">
                <div class="form-group">
                    <label for="category-select">Catégorie</label>
                    <select class="custom-select" name="category-select" id="category-select">
                        <option value='all' selected>Toutes</option>
                        @foreach (App\Category::where('isDeleted', 0)->orderBy('rank', 'asc')->orderBy('name', 'asc')->get()
                            as $category)

                            <?php $products_count = 0; ?>
                            @foreach($category->products as $product)
                            @if($product->isDeleted == 0) <?php $products_count++; ?> @endif
                            @endforeach
                            @if($products_count > 0)

                            <option value="{{$category->id}}">{{$category->name}}</option>

                            @endif

                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div id="products-container">
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
                    <tr class='@if($product->isHidden){{'hidden'}}@endif'>
                        <td scope="row" onclick="load_url('/dashboard/produits/edition/' + '{{$product->id}}')">
                            @if($product->reference != null) {{$product->reference . ' - '}} @endif{{$product->name}}<BR> 
                            @foreach ($product->categories as $category)
                                <small class='text-muted'>{{$category->name}}</small><BR>
                            @endforeach
                        </td>
                        <td class='align-middle' onclick="load_url('/dashboard/produits/edition/' + '{{$product->id}}')">{{$product->price}}€</td>
                        <td class='text-center align-middle'>
                            <div class="form-group">
                                <input type="checkbox" class="form-check-input m-0" name="" id="" onclick='switch_isHidden($(this), "{{$product->id}}")' @if($product->isHidden) {{'checked'}} @endif>
                            </div>
                        </td>
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
        <div id='sort-container'>
            <h2 id='sort-title' class='h4'>Résulats</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th class='border-top-0'>Nom</th>
                        <th class='border-top-0'>Prix</th>
                        <th class='border-top-0 align-right'>Caché</th>
                    </tr>
                </thead>
                <tbody id='sort-table-body'>

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
    $("#sort-container").hide();

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
                    $("#sort-container").hide();
                    $("#search-container").show();
                    $("#search-table-body").empty();
                    $("#search-possible-table-body").empty();

                    $.each(data.valid_products, function(index, product){
                        product_html = prepare_product_html(product)

                        $("#search-table-body").append(product_html);
                    });

                    $.each(data.possible_products, function(index, product){
                        product_html = prepare_product_html(product)

                        $("#search-possible-table-body").append(product_html);
                    });

                    button.removeClass('running');
                }
            });
        } else {
            $("#products-container").show();
            $("#search-container").hide();
            $("#sort-container").hide();
        }
    }

    function prepare_product_html(product){
        product_html = `
            <tr class='###class'>
                <td scope="row" onclick='load_url("/dashboard/produits/edition/###product_id")'>
                ###product_name <BR>
                    ###categories
                </td>
                <td class='align-middle' onclick='load_url("/dashboard/produits/edition/###product_id")'>
                    ###product_price €
                </td>
                <td class='text-center align-middle'>
                    <div class="form-group">
                        <input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "###product_id")' ###checked>
                    </div>
                </td>
            </tr>
            `;

        if(product.reference != '') reference = product.reference + ' - ';
            else reference = "";

        if(product.isHidden == 1) {
            product_html = product_html.replace('###class', "hidden");
            product_html = product_html.replace('###checked', 'checked');
        } else {
            product_html = product_html.replace('###class', "");
            product_html = product_html.replace('###checked', ''); }

        categories_html = "";
        $.each(product.categories, function(index, category){
            categories_html = categories_html + `<small class='text-muted'>`+category.name+`</small><BR>`;
        });

        product_html = product_html.replace('###categories', categories_html);
        product_html = product_html.replace(/###product_id/g, product.id);
        product_html = product_html.replace('###product_name', reference + product.name);
        product_html = product_html.replace('###product_price', product.price);

        return product_html;
    }
</script>

{{-- CATEGORY SORTING --}}
<script>
$('#category-select').change(function(){
    category_name = $( this ).children('option:selected').text();
    category_id = $( this ).children('option:selected').val();
    
    if(category_id != 'all'){
        $.ajax({
            url : '/dashboard/produits/trier-par-categorie/' + category_id, // on appelle le script JSON
            type: "POST",
            dataType : 'json', // on spécifie bien que le type de données est en JSON
            beforeSend: function(){
                console.log(category_id);
            },
            success : function(data){
                $("#products-container").hide();
                $("#search-container").hide();
                $("#sort-container").show();

                $("#sort-table-body").empty();

                $.each(data.products, function(index, product){
                    if(product.isDeleted == 0){
                        product_html = prepare_product_html(product)

                        $("#sort-table-body").append(product_html);
                    }
                });

                $("#sort-title").text(category_name);
            }
        });
    } else {
        $("#products-container").show();
        $("#sort-container").hide();

        $("#sort-table-body").empty();
    }
});
</script>

{{-- SWITCH HIDDEN PRODUCT --}}
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