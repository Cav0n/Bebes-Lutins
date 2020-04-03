<div class='order p-3 my-3 border shadow-sm @if(isset($bgColor)) {{ $bgColor }} @else bg-light @endif'>
    <div class="d-flex">
        <p>{{ $order->created_at->format('\L\e d/m/Y \à H:i') }} |

        @if(session('admin'))
        <div class="form-group mb-0 ml-3">
            <select class="custom-select status-select" name="status" data-orderid="{{ $order->id }}" style='background-color: {{ $order->statusColor }}'>
                <option value='WAITING_PAYMENT' @if('WAITING_PAYMENT' === $order->status) selected @endif>
                    En attente de paiement</option>
                <option value='PROCESSING' @if('PROCESSING' === $order->status) selected @endif>
                    En cours de traitement</option>
                <option value='DELIVERING' @if('DELIVERING' === $order->status) selected @endif>
                    En cours de livraison</option>
                <option value='WITHDRAWAL' @if('WITHDRAWAL' === $order->status) selected @endif>
                    À retirer à l'atelier</option>
                <option value='REGISTERED_PARTICIPATION' @if('REGISTERED_PARTICIPATION' === $order->status) selected @endif>
                    Participation enregistrée</option>
                <option value='DELIVERED' @if('DELIVERED' === $order->status) selected @endif>
                    Livrée</option>
                <option value='CANCELED' @if('CANCELED' === $order->status) selected @endif>
                    Annulée</option>
                <option value='REFUSED_PAYMENT' @if('REFUSED_PAYMENT' === $order->status) selected @endif>
                    Paiement refusé</option>
            </select>
        </div>
        @else
        <span class="badge badge-pill" style="background-color:{{ $order->statusColor }}">{{ ucfirst($order->statusI18n) }}</span></p>
        @endif
    </div>

    <div class="row mb-3">
        <div class="col-12 col-sm-6">
            <p class="h5">Livré à :</p>
            @if ($order->shippingAddress)
            @include('components.utils.addresses.address', ['address' => $order->shippingAddress])
            @else
            @include('components.utils.addresses.address', ['address' => $order->billingAddress])
            @endif
        </div>
        <div class="col-12 mt-2 mt-sm-0 col-sm-6">
            <p class="h5">Facturé à :</p>

            @include('components.utils.addresses.address', ['address' => $order->billingAddress])
        </div>
    </div>

    <p class="h5">Articles :</p>
    @foreach ($order->items as $item)
        <div class="row my-2 mx-0 bg-white p-2 border">
            <div class="col-2 col-lg-1 px-0">
                <img class="w-100" src="{{ $item->product->images()->count() ? $item->product->images()->first()->url : null }}" style="object-fit:cover">
            </div>
            <div class="col-10 px-1 px-lg-3 col-lg-6 d-flex flex-column justify-content-center ">
                <a class='mb-0' href="{{ route('product', ['product' => $item->product->id]) }}">{{ $item->product->name }}</a>
                <p class="mb-0 d-flex d-lg-none">Quantité : {{ $item->quantity }}</p>
                <p class="mb-0 d-flex d-lg-none">Prix unitaire : {{ \App\NumberConvertor::doubleToPrice($item->unitPrice) }}</p>
            </div>
            <div class="col-4 col-lg-2 d-none d-lg-flex flex-column justify-content-center border-left">
                <p class="mb-0 text-center">{{ \App\NumberConvertor::doubleToPrice($item->unitPrice) }}</p>
            </div>
            <div class="col-0 col-lg-1 d-none d-lg-flex flex-lg-column justify-content-center border-left">
                <p class="mb-0 text-center">x{{ $item->quantity }}</p>
            </div>
            <div class="col-0 col-lg-2 d-none d-lg-flex flex-lg-column justify-content-center border-left">
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


@section('scripts')
<script>
    errorFeedbackHtml = "<div class='invalid-feedback'>__error__</div>"

    $('.status-select').change(function(){
        orderId = $(this).data('orderid');
        status = $(this).children('option:selected').val();

        fetch("/api/order/" + orderId + "/status/update", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    order: orderId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(response => {
                if (undefined !== response.errors){
                    throw response.errors;
                }

                $(this).css('background-color', response.color);
            }).catch((errors) => {
                select.addClass('is-invalid');
                errors.status.forEach(message => {
                    select.after(errorFeedbackHtml.replace('__error__', message));
                });
            });
    });
</script>
@endsection
