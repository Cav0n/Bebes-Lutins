<?php $orders = App\Order::where('status', '=', -3)->paginate(15); ?>

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