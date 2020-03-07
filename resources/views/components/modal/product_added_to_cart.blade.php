<!-- Modal -->
<div class="modal fade" id="product-added-modal" tabindex="-1" role="dialog" aria-labelledby="productAddedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Produit ajouté avec succés !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body row">
                <div class="col-4">
                    <img class="modal-product-image w-100">
                </div>
                <div class="col-8">
                    <p class="modal-product-name font-weight-bold"></p>
                    <p class="modal-product-price"></p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#"class="btn btn-outline-primary" data-dismiss="modal">Continuer mes achats</a>
                <a href="{{ route('cart') }}" class="btn btn-secondary">Voir mon panier</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".add-to-cart", function () {
        var productId = $(this).data('id');
        var cartId = $(this).data('cart_id');
        var quantity = $(this).data('quantity');

        var price = 0;

        let result = ''

        fetch('/api/product/' + productId)
        .then(res => res.json())
        .then(text => {
            price = text.data.price;
            priceFormatted = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(text.data.price);

            $("#product-added-modal .modal-product-name").text(text.data.name);
            $("#product-added-modal .modal-product-image").attr('src', text.data.images[0].url);
            $("#product-added-modal .modal-product-price").text(priceFormatted + ' x ' + quantity);
        }).then(function(){
            fetch('/panier/ajout/' + productId + '/' + cartId, {
                method: 'post',
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({quantity: quantity})
            })
            .then(function() {
                $("body").trigger("productAddedToCart", [price, quantity]);
            });
        });
    });
</script>
