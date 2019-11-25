<div id='addToCartPopup' class="modal fade" tabindex="-1" role="dialog">
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
                <button type="button" class="mr-auto mb-2 mb-sm-0 btn btn-outline-primary rounded-0">
                    Continuer mes achats</button>
                <button type="button" class="btn btn-secondary rounded-0 mb-2 mb-sm-0" data-dismiss="modal" onclick='load_url("/panier")'>
                    Voir mon panier</button>
            </div>
        </div>
    </div>
</div>

{{-- Update popup with product infos --}}
<script>
    $('.open-product-added-dialog').on('click', function(){
        var productID = $(this).data('product_id');
        var productName = $(this).data('product_name');
        var productImage = $(this).data('product_image');
        var productPrice = $(this).data('product_price');
        var productQuantity = $(this).data('product_quantity');
        var shoppingCartID = '{{ session('shopping_cart')->id }}'
    
        $("#addToCartPopup .modal-product-image").attr('src', productImage );
        $("#addToCartPopup .modal-product-name").html(productName.bold());
        $("#addToCartPopup .modal-product-price").text(productPrice + ' € x ' + productQuantity);
        
        add_to_cart(shoppingCartID, productID, productQuantity);
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function add_to_cart(shoppingCartID, productID, quantity){
        $.ajax({
            url: "/panier/add_item",
            type: 'POST',
            data: { shopping_cart_id: shoppingCartID, product_id: productID, quantity:quantity },
            success: function(data){
                console.log('Quantité modifié avec succés.');
            },
            beforeSend: function() {
            }
        }) 
    }
</script>
        