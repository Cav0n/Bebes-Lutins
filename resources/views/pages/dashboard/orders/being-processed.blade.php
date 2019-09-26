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
        <tr>
            <th class='border-top-0'>Date</th>
            <th class='border-top-0'>Client</th>
            <th class='border-top-0'>Prix</th>
            <th class='border-top-0 text-center'>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr style='color:{{App\OrderStatus::statusToRGBColor($order->status)}}'>
            <td scope="row">{{$order->created_at}}</td>
            <td>{{$order->user->firstname}} {{$order->user->lastname}}</td>
            <td>{{$order->productsPrice}}€ (+{{$order->shippingPrice}}€)</td>
            <td>
                @include('pages.dashboard.orders.status-selector')
            </td>
        </tr>
        @endforeach
    </tbody>
</table>