<?php $orders = App\Order::where('status', '=', -3)->paginate(15); ?>

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