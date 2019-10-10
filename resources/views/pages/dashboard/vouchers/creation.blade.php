@extends('templates.dashboard')

@section('head-options')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12 pt-3">
        <a href='/dashboard/clients/avis' class='text-muted'>< Toutes les réductions</a>        
    </div>
</div>
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Nouveau code de réduction
        </h1>
    </div>
    <div class="card-body">
        <form action='/dashboard/reductions/nouveau' method="POST">
            @csrf

            {{-- Errors --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class='mb-0'>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            {{-- Success --}}
            @if(session()->has('success-message'))
            <div class="col-lg-12">
                <div class="alert alert-success px-3 mb-0">
                    <p class='text-success font-weight-bold mb-0'>{{session('success-message')}}</p>
                </div>
            </div>
            @endif

            <div class="form-group">
              <label for="code">Code</label>
              <input type="text" class="form-control" name="code" id="code" aria-describedby="helpCode" placeholder="">
            </div>

            <div class="row m-0">
                <div class="col-6 pl-0">
                    <div class="form-group">
                        <label for="type">Type de réduction</label>
                        <select class="custom-select" name="type" id="type">
                            <option selected>Selectionner un type</option>
                            <option value="1">%</option>
                            <option value="2">€</option>
                            <option value="3">Frais de port</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 pr-0">
                    <div class="form-group">
                      <label for="value">Valeur</label>
                      <input type="number" class="form-control" name="value" id="value" aria-describedby="helpValue" placeholder="" min="0" max="100" step='1'>
                      <small id="helpValue" class="form-text text-muted">Le taux de réduction</small>
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-6 pl-0">
                    <div class="form-group">
                      <label for="first-date">Première date de validité</label>
                      <input type="text" class="form-control" name="first-date" id="first-date" aria-describedby="helpFirstDate" placeholder="">
                      <small id="helpFirstDate" class="form-text text-muted">La date à partir de laquelle le coupon est valable</small>
                    </div>
                </div>
                <div class="col-6 pr-0">
                    <div class="form-group">
                      <label for="last-date">Dernière date de validité</label>
                      <input type="text" class="form-control" name="last-date" id="last-date" aria-describedby="helpLastDate" placeholder="">
                      <small id="helpLastDate" class="form-text text-muted">La date à partir de laquelle le coupon n'est plus valable</small>
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-6 pl-0">
                    <div class="form-group">
                    <label for="minimal-price">Prix minimal du panier</label>
                    <input type="text" name="minimal-price" id="minimal-price" class="form-control" placeholder="" aria-describedby="helpMinimalPrice">
                    <small id="helpMinimalPrice" class="text-muted">Combien l'acheteur doit dépenser pour profiter du code coupon</small>
                    </div>
                </div>
                <div class="col-6 pr-0">
                    <div class="form-group">
                      <label for="max-usage">Nombre d'utilisations maximal</label>
                      <input type="text" class="form-control" name="max-usage" id="max-usage" aria-describedby="helpMaxUsage" placeholder="">
                      <small id="helpMaxUsage" class="form-text text-muted">Nombre d'utilisation maximal par personne</small>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="avaibility">Validité</label>
                <select class="custom-select" name="avaibility" id="avaibility">
                    <option selected>Choisissez en un</option>
                    <option value="certainProducts">Sur certains produits</option>
                    <option value="allProducts">Sur tous les produits</option>
                </select>
            </div>

            {{-- SELECT PRODUCTS LIST --}}
            <div class='col-12 p-0'>
                <p id='no-product-selected' class='mb-0'>Aucun produit selectionné</p>
                <p id='products-selected-list' class='mb-0'></p>
            </div>

            <button type="submit" class="btn btn-secondary my-3">Sauvegarder</button>

            {{-- PRODUCTS SELECTOR --}}
            <div class='col-12 p-0'>
                @foreach ($products as $product)
                <div class="row product mb-2 mx-0 p-2 border-bottom">
                    <div class="col-12 p-0">
                        <div class="custom-control custom-checkbox pointer">
                            <input id='checkbox-{{$product->id}}' name='products[]' type="checkbox" class="custom-control-input pointer product-checkbox" value='{{$product->id}}'>
                            <label class="custom-control-label noselect pointer" for="checkbox-{{$product->id}}"><p class='mb-0'>{{$product->name}}</p></label>
                        </div>
                    </div>
                </div>    
                @endforeach
            </div>
        </form>
    </div>
</div>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<script>
    $('#products-selected-list').hide()
    selected_products = new Map();

    $(".product-checkbox").change(function() {
        if(this.checked) {
            product_id = this.value;
            product_name = selected_products.get(product_id)

            if(product_name != null){
                $('#products-selected-list').html($('#products-selected-list').html() + product_name + '<br>');
            } else {
                $.ajax({
                    url: "/produits/" + product_id,
                    type: 'POST',
                    data: { },
                    success: function(data){
                        var json = $.parseJSON(data);
                        product = json.product;

                        $('#products-selected-list').html($('#products-selected-list').html() + product.name + '<br>');
                        selected_products.set(product_id, product.name);
                    },
                    beforeSend: function() {
                        $('#no-product-selected').hide();
                        $('#products-selected-list').show();
                    }
                })
            }
        } else {
            product_id = this.value;
            product_name = selected_products.get(product_id);

            $('#products-selected-list').html($('#products-selected-list').html().replace(product_name + '<br>', ''));
            if($('#products-selected-list').html() == ''){
                $('#no-product-selected').show();
                $('#products-selected-list').hide();
            }
        }
    });
</script>
@endsection