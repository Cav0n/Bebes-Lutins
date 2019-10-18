<div id='add_to_cart_popup_container' class='popup-container row justify-content-center fixed-top d-none'>
    <div id='add_to_cart_popup' class='popup m-auto p-0 bg-white col-sm-10 col-md-8 col-lg-6'>
        <input id='popup-hidden-item-id' type="hidden" name='item-id'>
        <p class='popup_title h4 mb-0 p-3 bg-light'>Un produit à bien été ajouté à votre panier</p>
        <div class='popup_description p-3 row'>
            <div class="product-image col-4" style='max-height:11rem;'>
                <img id='popup-item-image' class='w-100 h-100' src='{{asset("images/utils/question-mark.png")}}' style='object-fit:cover;'>
            </div>
            <div class="product-definition col-8">
                <div class="row m-0 d-flex flex-column justify-content-between h-100">
                    <div class="p-0">
                        <p id='popup-item-name' class='mb-0 h4'>Nom du produit</p>
                        <p id='popup-product-unit-price' class='mb-0'>Prix unitaire : 00.00 €</p>
                    </div>
                    <div class="p-0 d-flex flex-column justify-content-end">
                        <div class="col-lg-5 p-0">
                            <p id='popup-product-price' class='mb-0 small'>Prix : 00.00 €</p>
                            <p id='popup-shopping-cart-total' class='mb-0 small'>Total du panier : 00.00€</p>
                            <input id="popup-item-quantity" class="spinnerProductPopup" type="number" name="quantity" value="1" min="1" max="10" step="1"/>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class='button-container d-flex p-3'>
            <button id='refresh-button' type="button" class="btn btn-outline-primary rounded-0" onclick="validate_and_refresh()">Poursuivre mes achats</button>
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
    
    function add_to_cart(product_id, product_name, product_price, product_image, product_stock, shopping_cart_id, choosen_quantity = 1)
    {
        $.ajax({
            url: "/panier/add_item",
            type: 'POST',
            data: { product_id: product_id, shopping_cart_id : shopping_cart_id, quantity: choosen_quantity, },
            success: function(data){
                response = JSON.parse(data);
                item_id = response.item_id;
                new_shopping_cart_total = shopping_cart_total + product_price;
                product_price_to_change = product_price;
                updated_price = product_price * choosen_quantity;
                popup_container = $('#add_to_cart_popup_container');
                popup_container.removeClass('d-none');
                
                $('#popup-item-name').text(product_name);
                $('#popup-item-image').attr('src', '/images/products/'+product_image);
                $('#popup-product-unit-price').text('Prix unitaire : ' + product_price.toFixed(2) + ' €');
                $('#popup-product-price').text('Prix : ' + updated_price.toFixed(2) + ' €');
                $('#popup-shopping-cart-total').text('Total du panier : ' + new_shopping_cart_total.toFixed(2) + ' €');
                $('#popup-item-quantity').val(choosen_quantity);
                $('#popup-item-quantity').attr('max', product_stock);
                $('#popup-hidden-item-id').val(item_id);
            },
            beforeSend: function() {
    
            }
        })
        .done(function( data ) {
            
        });    
    }

    function validate_and_refresh(){
        update_quantity($('#refresh-button'), $('#popup-hidden-item-id').val(), $('#popup-item-quantity').val());
        location.reload();
    }

    function validate_and_go_to_shopping_cart(){
        update_quantity($('#shopping-cart-button'), $('#popup-hidden-item-id').val(), $('#popup-item-quantity').val());
        load_url("/panier");
    }

    function update_quantity(view, item_id, quantity){
        quantity = quantity;
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
    $(".spinnerProductPopup").inputSpinner();

    $(".spinnerProductPopup").on("change", function (event) {
        quantity_to_add = $(this).val();
        new_price = product_price_to_change * quantity_to_add;
        new_shopping_cart_total = shopping_cart_total + new_price
        $('#popup-product-price').text('Prix : ' + new_price.toFixed(2) + ' €');
        $('#popup-shopping-cart-total').text('Total du panier : ' + new_shopping_cart_total.toFixed(2) + ' €');
    })
</script>