<div id='add_to_cart_popup_container' class='popup-container row justify-content-center fixed-top d-none'>
    <div id='add_to_cart_popup' class='popup m-auto p-3 bg-light col-6 h-25'>
        <p class='popup_title h3'>.. a été ajouté à votre panier</p>
        <p class='popup_description'>Vous avez ajouté .. à votre panier, souhaitez vous poursuivre vos achats ou accéder à votre panier ?</p>
        <div class='button-container d-flex'>
            <button type="button" class="btn btn-primary rounded-0 ml-auto" onclick='refresh_page()'>Poursuivre mes achats</button>
            <button type="button" class="btn btn-secondary rounded-0" onclick='load_url("/panier")'>Accéder a mon panier</button>
        </div>
    </div>
</div>

{{--  Add to cart JS  --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    function add_to_cart(product_id, product_name, product_price, shopping_cart_id)
    {
        $.ajax({
            url: "/panier/add_item",
            type: 'POST',
            data: { product_id: product_id, shopping_cart_id : shopping_cart_id, quantity: 1, },
            success: function(data){
                popup_container = $('#add_to_cart_popup_container');
                popup_container.removeClass('d-none');
                popup_container.children('#add_to_cart_popup').children('.popup_title').text(
                    product_name + ' a été ajouté à votre panier'
                );
                popup_container.children('#add_to_cart_popup').children('.popup_description').text(
                    'Vous avez ajouté '+ product_name +' à votre panier, souhaitez vous poursuivre vos achats ou accéder à votre panier ?'
                );
            },
            beforeSend: function() {
    
            }
        })
        .done(function( data ) {
            
        });    
    }
    
    function refresh_page(){
        location.reload();
    }
    </script>