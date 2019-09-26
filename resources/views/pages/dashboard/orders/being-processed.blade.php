<?php $orders = App\Order::where('status', '>', 0)->where('status', '!=', 3)->where('status', '!=', '33')->orderBy('created_at', 'desc')->paginate(15); ?>

<div class="row">
    <div class="col-12 d-flex flex-row flex-wrap">
        <p class="py-1 px-3 mr-2 bg-light border rounded">En attente de paiement</p>
        <p class="py-1 px-3 mr-2 bg-light border rounded">En cours de préparation</p>
        <p class="py-1 px-3 mr-2 bg-light border rounded">En cours de livraison</p>
        <p class="py-1 px-3 mr-2 bg-light border rounded">A retirer à l'atelier</p>
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