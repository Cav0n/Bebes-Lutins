<div class='order p-3 my-3 border shadow-sm @if(isset($bgColor)) {{ $bgColor }} @else bg-light @endif'>
    <p>{{ $order->created_at->format('\L\e d/m/Y \à H:i') }} | <span class="badge badge-pill" style="background-color:{{ $order->statusColor }}">{{ ucfirst($order->statusI18n) }}</span></p>

    <div class="row mb-3">
        <div class="col-12 col-sm-6">
            <p class="h5">Livré à :</p>
            @include('components.utils.addresses.address', ['address' => $order->shippingAddress])
        </div>
        <div class="col-12 mt-2 mt-sm-0 col-sm-6">
            <p class="h5">Facturé à :</p>
            @include('components.utils.addresses.address', ['address' => $order->billingAddress])
        </div>
    </div>

    <p class="h5">Articles :</p>
    @foreach ($order->items as $item)
        <div class="row my-2">
            <div class="col-2 px-1 px-lg-3 col-lg-2">
                <img class="w-100" src='{{ asset($item->product->images->first()->url) }}' style="object-fit:cover">
            </div>
            <div class="col-6 px-1 px-lg-3 col-lg-5 d-flex flex-column justify-content-center border-right">
                <a class='mb-0' href="{{ route('product', ['product' => $item->product->id]) }}">{{ $item->product->name }}</a>
            </div>
            <div class="col-4 col-lg-2 d-flex flex-column justify-content-center border-right">
                <p class="mb-0 text-center">{{ \App\NumberConvertor::doubleToPrice($item->unitPrice) }}</p>
            </div>
            <div class="col-0 col-lg-1 d-none d-lg-flex flex-lg-column justify-content-center border-right">
                <p class="mb-0 text-center">x{{ $item->quantity }}</p>
            </div>
            <div class="col-0 col-lg-2 d-none d-lg-flex flex-lg-column justify-content-center">
                <p class="mb-0 text-center">{{ \App\NumberConvertor::doubleToPrice($item->unitPrice * $item->quantity) }}</p>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col-8 col-lg-3 offset-lg-7 text-right">
            <p class="mb-0">Prix total :</p>
            <p class="mb-0">Frais de ports :</p>
            <p class="">Prix total T.T.C. :</p>
        </div>
        <div class="col-4 col-lg-2 text-center">
            <p class="mb-0">{{ number_format($order->totalPrice, 2) }} €</p>
            <p class="mb-0">{{ number_format($order->shippingCosts, 2) }} €</p>
            <p class="">{{ number_format($order->totalPrice + $order->shippingCosts, 2) }} €</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-right">
            <p class="mb-0">Commande payée par {{ $order->paymentMethodI18n }}.</p>
        </div>
    </div>
</div>
