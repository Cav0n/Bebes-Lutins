<div id='orders-container'>
<div class="row">
    <div class="col-12 d-flex flex-row flex-wrap">
        <p class="status-selector py-1 px-3 mr-2 bg-light border rounded @if(session()->has('selected_order_status' . $oldStatus)) @if(session()->get('selected_order_status' . $oldStatus) == 3) selected @endif @endif" onclick='select_status_to_display($(this), 3)'>
            Livrées</p>
        <p class="status-selector py-1 px-3 mr-2 bg-light border rounded @if(session()->has('selected_order_status' . $oldStatus)) @if(session()->get('selected_order_status' . $oldStatus) == 33) selected @endif @endif" onclick='select_status_to_display($(this), 33)'>
            Participations enregistrées</p>
        <p class="status-selector py-1 px-3 mr-2 bg-light border rounded @if(session()->has('selected_order_status' . $oldStatus)) @if(session()->get('selected_order_status' . $oldStatus) == -1) selected @endif @endif" onclick='select_status_to_display($(this), -1)'>
            Annulées</p>
    </div>
</div>
{{ $orders->links() }}
<table class="table">
    <thead>
        <tr class='d-flex'>
            <th class='border-top-0 col-2 text-center'>Date</th>
            <th class='border-top-0 col-4'>Client</th>
            <th class='border-top-0 col-2 text-center'>Prix</th>
            <th class='border-top-0 col-4 text-center'>Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr class='d-flex' style='color:{{App\OrderStatus::statusToRGBColor($order->status)}}'>
            
            <td class='col-2 small text-center mb-0 d-none d-md-table-cell' scope="row" onclick='load_in_new_tab("/dashboard/commandes/fiche/{{$order->id}}")'>
                {{$order->created_at->format('j / n / Y')}} <br>
                {{$order->created_at->format('h:i:s')}} <br>
            </td>
            
            <td class='col-4' onclick='load_in_new_tab("/dashboard/commandes/fiche/{{$order->id}}")'>
                <p class='font-weight-bold mb-0'>{{$order->user->firstname}} {{$order->user->lastname}}</p>
            </td>
            
            <td class='col-4 col-md-2 text-center' onclick='load_in_new_tab("/dashboard/commandes/fiche/{{$order->id}}")'>
                <p class='mb-0'>{{number_format($order->productsPrice + $order->shippingPrice, 2)}}€</p> 
                @if($order->shippingPrice != 0) <p class='small mb-0'>(dont {{$order->shippingPrice}} € de fdp)</p> @endif 
            </td>

            <td class='col-4'>
                @include('pages.dashboard.orders.status-selector')
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

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