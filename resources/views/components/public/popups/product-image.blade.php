<!-- Modal -->
<div class="modal fade" id="productImageModal" tabindex="-1" role="dialog" aria-labelledby="productImageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class='modal-header'>
                <h5 class="modal-title">{{$product->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id='productImageModal-img' class='w-100 h-100' src='{{asset('/images/products/' . $product->mainImage)}}'>
            </div>
        </div>
    </div>
</div>