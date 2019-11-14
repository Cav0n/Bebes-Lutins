<div id='addToCartPopup' class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Produit ajouté au panier !</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row m-0">
                <div class='modal-image-container col-4'>
                    <img class='modal-image w-100' src=''>
                </div>
                <div class='modal-text-container col-8'>
                    <p class='modal-text-confirmation m-0'>Vous venez d'ajouter un produit à votre panier!</p>
                </div>
            </div>
            <div class="modal-footer flex-wrap">
                <button type="button" class="mr-auto btn btn-outline-primary rounded-0">Continuer mes achats</button>
                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Voir mon panier</button>
            </div>
        </div>
    </div>
</div>


{{-- Custom Spinner --}}
<script>
    product_price = {{$product->price}}

    $(".spinnerProductPopup").inputSpinner();
</script>