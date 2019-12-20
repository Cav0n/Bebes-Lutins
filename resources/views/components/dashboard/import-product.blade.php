<div id='product-selection-popup' class='modal'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            {{--  HEADER  --}}
            <div class="modal-header">
                <h5 class="modal-title">Choisissez un produit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            {{--  BODY  --}}
            <div class="modal-body">
                <table class='table'>
                    <?php $index = 0; ?>
                    @foreach (\App\Product::where('isDeleted', 0)->get() as $product)
                    <tr id='{{$product->id}}' onclick='import_product("{{$product->id}}")'>
                        <td @if($index == 0) class='border-top-0' @endif>{{$product->name}}</td>
                    </tr>
                    <?php $index++; ?> 
                    @endforeach
                </table>
            </div>

        </div>
    </div>
</div>