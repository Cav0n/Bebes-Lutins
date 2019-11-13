@extends('templates.dashboard')

@section('content')
<div class="row h-100">
    <div class="col-12 h-100">

        @if(count($highlightedProducts) == 0)
        
        <div class='d-flex flex-column justify-content-center h-100 pt-5 pt-lg-0'>
            <h1 class='h2 text-center font-weight-bold'>Il n'y a aucun produit mis en avant 😱</h1>
            <button type="button" class="btn btn-primary max-content mx-auto" data-toggle="modal" data-target="#product-selection-popup">
                Mettre des produits en avant</button>
        </div>

        @else

        <div class='card card bg-white my-3'>
            <div class="card-header bg-white d-flex justify-content-between">
                <h1 class='h4 m-0 font-weight-normal d-flex flex-column justify-content-center'>
                    Produits mis en avant
                </h1>
                <button type="button" class="btn btn-primary py-1" data-toggle="modal" data-target="#product-selection-popup">
                    Choisir des produits</button>
            </div>
            <div class='card-body'>
                <table class='table'>
                    <?php $index = 0; ?>
                    @foreach ($highlightedProducts as $product)
                        <tr class='@if($index == 0) border-top-0 @else border-top @endif' onclick='select_product($(this), "{{$product->id}}")'>
                            <td class='border-top-0' style='width:5rem;'>
                                <div class=' mr-0'style='width:5rem;height:5rem;'>
                                    <img class='h-100 w-100' src='{{asset('images/products/'.$product->mainImage)}}' style='object-fit:cover;'>
                                </div>
                            </td>
                            <td class='border-top-0 align-middle'>{{$product->name}}</td>
                            <td class='border-top-0 align-middle'>
                                <button type="button" class="btn btn-danger py-1">
                                    <p class='d-none d-md-flex m-0'>Enlever</p>
                                    <img class='d-flex d-md-none svg pt-1' src='{{asset('images/icons/trash.svg')}}'></button>
                            </td>
                        </tr>
                    <?php $index++; ?> 
                    @endforeach
                </table>
            </div>
        </div>

        @endif

    </div>
</div>

<div id='product-selection-popup' class='modal'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{--  HEADER  --}}
            <div class="modal-header">
                <h5 class="modal-title">Choisissez des produits</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            {{--  BODY  --}}
            <div class="modal-body">
                <table class='table'>
                    <?php $index = 0; ?>
                    @foreach ($products as $product)
                    <tr id='{{$product->id}}' onclick='select_product($(this), "{{$product->id}}")'>
                        <td @if($index == 0) class='border-top-0' @endif>{{$product->name}}</td>
                    </tr>
                    <?php $index++; ?> 
                    @endforeach
                </table>
            </div>

            {{--  FOOTER  --}}
            <div class="modal-footer">
                <p id='product-counter' class='d-flex flex-column justify-content-center m-0 mr-1'>0</p>
                <p class='d-flex flex-column justify-content-center m-0 mr-2'>produits</p>
                <button type="button" class="btn btn-primary ld-over" onclick='validate_selection($(this))'>
                    Valider <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- AJAX SETUP --}}
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

{{-- PRODUCT SELECTION --}}
<script>
function select_product(element, product_id){
    if(element.hasClass('bg-primary')){
        selected_product_id = selected_product_id.filter(item => item !== product_id)
        element.removeClass('bg-primary');
    } else {
        selected_product_id.push(product_id);
        element.addClass('bg-primary'); }

    $('#product-counter').text(selected_product_id.length);

}

function validate_selection(btn){
    $.ajax({
        url: "/dashboard/produits/mis-en-avant",
        type: 'POST',
        data: { selected_products_id:selected_product_id },
        success: function(data){
            console.log('Produits bien mis en avant.');
            document.location.reload();
        },
        beforeSend: function() {
            btn.addClass('running');
        }
    });
}
</script>

{{-- PRODUCT SELECTION INITIALISATION --}}
<script>
selected_product_id = new Array();

@if(count($highlightedProducts) > 0)

@foreach($highlightedProducts as $product)
    selected_product_id.push("{!!$product->id!!}");
    $('#{{$product->id}}').addClass('bg-primary');
@endforeach

$('#product-counter').text(selected_product_id.length);
@endif

</script>

@endsection