<div class='order p-3 border bg-white'>
    <p>{{ $order->created_at->format('\L\e d/m/Y \à H:i') }} | <span class="badge badge-pill badge-warning"> {{ $order->statusI18n }} </span></p>
    @foreach ($order->items as $item)
        <div class="item d-flex">
            <img src='{{ asset($item->product->images->first()->url) }}' style='width:5rem;'>
            <div>
                <a class='mb-0' href="{{ route('product', ['product' => $item->product->id]) }}">{{ $item->product->name }}</a>
                <p class='mb-0'>Quantité : {{ $item->quantity }}</p>
                <p class='mb-0'>Total : {{ number_format($item->unitPrice * $item->quantity, 2) }} €</p>
            </div>
        </div>
    @endforeach
    <p class="mb-0">Prix total : {{ number_format($order->totalPrice, 2) }} €</p>
    <p class="mb-0">Frais de ports : {{ number_format($order->shippingCosts, 2) }} €</p>
    <p class=""><b>Prix total T.T.C. : {{ number_format($order->totalPrice + $order->shippingCosts, 2) }} €</b></p>
    <p class="mb-0">Payé par {{ $order->paymentMethodI18n }}.</p>
</div>
