<div id='add_to_cart_popup_container' class='popup-container row justify-content-center fixed-top d-none'>
    <div id='add_to_cart_popup' class='popup m-auto p-0 bg-white col-sm-10 col-md-8 col-lg-6'>
        <input id='hidden-item-id' type="hidden" name='item-id'>
        <p class='popup_title h4 mb-0 p-3 bg-light'>Un produit à bien été ajouté à votre panier</p>
        <div class='popup_description p-3 row'>
            <div class="product-image col-4" style='max-height:8rem;'>
                <img id='item-image' class='w-100 h-100' src='{{asset("images/products/couche_lavable_te1_et_te2_colombine_évolutive_aubergine.jpg")}}' style='object-fit:cover;'>
            </div>
            <div class="product-definition col-8 d-flex flex-column justify-content-between">
                <p id='item-name' class='mb-0'>Nom du produit</p>
                <p id='product-price' class='mb-0 small'>Prix : 00.00 €</p>
                <p id='shopping-cart-total' class='mb-0 small'>Total du panier : 00.00€</p>
                <input id="item-quantity" class="spinner" type="number" name="quantity" value="1" min="1" max="10" step="1"/>
            </div>
        </div>
        <div class='button-container d-flex p-3'>
            <button id='refresh-button' type="button" class="btn bg-white border border-primary rounded-0" onclick="validate_and_refresh()">Poursuivre mes achats</button>
            <button id='shopping-cart-button' type="button" class="btn btn-secondary rounded-0 ml-auto" onclick="validate_and_go_to_shopping_cart()">Votre panier</button>
        </div>
    </div>
</div>

<?php 
$shopping_cart = session('shopping_cart'); 
$total_price = 0.0;
if(count($shopping_cart->items) > 0){
    foreach ($shopping_cart->items as $item) {
        $total_price += $item->product->price * $item->quantity;
    }
}
?>

{{--  Add to cart JS  --}}
<script>
    product_price_to_change = 0.0;
    shopping_cart_total = {{$total_price}};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    function add_to_cart(product_id, product_name, product_price, product_image, product_stock, shopping_cart_id)
    {
        $.ajax({
            url: "/panier/add_item",
            type: 'POST',
            data: { product_id: product_id, shopping_cart_id : shopping_cart_id, quantity: 1, },
            success: function(data){
                response = JSON.parse(data);
                item_id = response.item_id;
                new_shopping_cart_total = shopping_cart_total + product_price;
                product_price_to_change = product_price;
                popup_container = $('#add_to_cart_popup_container');
                popup_container.removeClass('d-none');

                $('#item-name').text(product_name);
                $('#item-image').attr('src', '/images/products/'+product_image);
                $('#product-price').text('Prix : ' + product_price.toFixed(2) + ' €');
                $('#shopping-cart-total').text('Total du panier : ' + new_shopping_cart_total.toFixed(2) + ' €');
                $('#item-quantity').attr('max', product_stock);
                $('#hidden-item-id').val(item_id);
            },
            beforeSend: function() {
    
            }
        })
        .done(function( data ) {
            
        });    
    }

    function validate_and_refresh(){
        update_quantity($('#refresh-button'), $('#hidden-item-id').val(), $('.spinner').val());
        location.reload();
    }

    function validate_and_go_to_shopping_cart(){
        update_quantity($('#shopping-cart-button'), $('#hidden-item-id').val(), $('.spinner').val());
        load_url("/panier");
    }

    function update_quantity(view, item_id, quantity){
        quantity = $('#item-quantity').val() - 1;
        $.ajax({
            url: "/panier/change_quantity/" + item_id,
            type: 'POST',
            data: { quantity:quantity, add:'true', },
            success: function(data){
                console.log('Quantité modifié avec succés.');
            },
            beforeSend: function() {
                view.addClass('running');
            }
        })
    }
</script>

{{-- Custom Spinner --}}
<script>
    $(".spinner").inputSpinner();

    $(".spinner").on("change", function (event) {
        quantity_to_add = $(this).val();
        new_price = product_price_to_change * quantity_to_add;
        new_shopping_cart_total = shopping_cart_total + new_price
        $('#product-price').text('Prix : ' + new_price.toFixed(2) + ' €');
        $('#shopping-cart-total').text('Total du panier : ' + new_shopping_cart_total.toFixed(2) + ' €');
    })
</script>