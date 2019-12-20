<div id='addToCartPopup' class="modal fade" tabindex="-1" role="dialog">
    <input type="hidden" id='product-id' value=''>
    <input type="hidden" id='quantity' value='1'>
    <input type="hidden" id='shopping-cart-id' value='{{ session('shopping_cart')->id }}'>

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Produit ajouté avec succés</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row m-0">
                <div class='modal-image-container col-4'>
                    <img class='modal-product-image w-100' src=''>
                </div>
                <div class='modal-text-container col-8'>
                    <p class='modal-product-name m-0'>Vous venez d'ajouter un produit à votre panier!</p>
                    <p class='modal-product-price m-0'>--,--€</p>
                </div>
            </div>
            <div class="modal-footer flex-wrap">
                <button type="button" class="mr-auto mb-2 mb-sm-0 btn btn-outline-primary rounded-0" onclick='reload_page()'>
                    Continuer mes achats</button>
                <button type="button" class="btn btn-secondary rounded-0 mb-2 mb-sm-0" data-dismiss="modal" onclick='load_url("/panier")'>
                    Voir mon panier</button>
            </div>
        </div>
    </div>
</div>

{{-- Update popup with product infos --}}
<script>
    $('#addToCartPopup').on('show.bs.modal', function (e) {
        productID = $('#addToCartPopup #product-id').val();
        quantity = $('#addToCartPopup #quantity').val();
        shoppingCartID = $('#addToCartPopup #shopping-cart-id').val();

        
        if ($('#characteristics-container').length){
            characteristics = [];
            $('.characteristic').each(function(){
                if ($(this).val().length != 0) {
                    char_name = $('label[for="'+ $(this).attr('name') +'"]').text();

                    characteristics.push(char_name + ': ' + $(this).val());
                }
            });
        } else characteristics = null;
        

        $.ajax({
            url: "/produits2/" + productID,
            type: 'POST',
            data: { },
            success: function(response){
                console.log(response);

                name = response.name;

                if(characteristics != null){
                    characteristics.forEach(function(c){
                        name = name + " - " + c;
                    })
                }

                $("#addToCartPopup .modal-product-image").attr('src', '/images/products/' + response.mainImage );
                $("#addToCartPopup .modal-product-name").html(name.bold());
                $("#addToCartPopup .modal-product-price").text(response.price + ' € x ' + quantity);

                add_to_cart(shoppingCartID, productID, quantity, name);
            }
        }) 
    })
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function reload_page()
    {
        location.reload();
    }

    function add_to_cart(shoppingCartID, productID, quantity, name){
        $.ajax({
            url: "/panier/add_item",
            type: 'POST',
            data: { shopping_cart_id: shoppingCartID, product_id: productID, quantity:quantity, name:name },
            success: function(data){
                console.log('Quantité modifié avec succés.');
            },
            beforeSend: function() {
            }
        }) 
    }
</script>
        