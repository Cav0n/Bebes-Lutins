<div class="row">
    <div class="col-12 d-flex flex-row flex-wrap">
        <p class="status-selector py-1 px-3 mr-2 bg-light border rounded transition-fast @if(session()->has('selected_order_status' . $oldStatus)) @if(session()->get('selected_order_status' . $oldStatus) == 0) selected @endif @endif" onclick='select_status_to_display($(this), 0)'>
            En attente de paiement</p>
        <p class="status-selector py-1 px-3 mr-2 bg-light border rounded transition-fast @if(session()->has('selected_order_status' . $oldStatus)) @if(session()->get('selected_order_status' . $oldStatus) == 1) selected @endif @endif" onclick='select_status_to_display($(this), 1)'>
            En cours de préparation</p>
        <p class="status-selector py-1 px-3 mr-2 bg-light border rounded transition-fast @if(session()->has('selected_order_status' . $oldStatus)) @if(session()->get('selected_order_status' . $oldStatus) == 2) selected @endif @endif" onclick='select_status_to_display($(this), 2)'>
            En cours de livraison</p>
        <p class="status-selector py-1 px-3 mr-2 bg-light border rounded transition-fast @if(session()->has('selected_order_status' . $oldStatus)) @if(session()->get('selected_order_status' . $oldStatus) == 22) selected @endif @endif" onclick='select_status_to_display($(this), 22)'>
            A retirer à l'atelier</p>
    </div>
</div>
{{ $orders->links() }}
<table class="table">
    <thead>
        <tr class='d-flex'>
            <th class='border-top-0 col-2 text-center'>Date</th>
            <th class='border-top-0 col-4'>Client</th>
            <th class='border-top-0 col-2 text-center'>Prix</th>
            <th class='border-top-0 col-4 text-center'>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr class='d-flex' style='color:{{App\OrderStatus::statusToRGBColor($order->status)}}'>
            <td class='col-2 small text-center mb-0' scope="row">{{$order->created_at}}</td>
            
            <td class='col-4'>
                <p class='font-weight-bold mb-0'>{{$order->user->firstname}} {{$order->user->lastname}}</p>
            </td>
            
            <td class='col-2 text-center'>
                <p class='mb-0'>{{$order->productsPrice}}€</p> 
                @if($order->shippingPrice != 0) <p class='small mb-0'>(+{{$order->shippingPrice}}€)</p> @endif 
            </td>

            <td class='col-4'>
                @include('pages.dashboard.orders.status-selector')
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    old_status = "{{$oldStatus}}"
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function select_status_to_display(selector, status){
        if(!selector.hasClass('selected')){
            url = "/dashboard/commandes/select_order_status";
        }else {
            url = "/dashboard/commandes/unselect_order_status";
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: { status: status, page: old_status },
            success: function(data){
                location.reload();
            },
            beforeSend: function() {
                selector.toggleClass('selected');
            }
        })
        .done(function( data ) {
            
        }); 
    }
</script>