<div class='row order p-3 mx-0 my-3 border shadow-sm bg-light'>
    <div class="col-md-6">
        <p class="mb-0">
            Commande du {{ $order->created_at->format('d/m/Y à H:i') }} | 
            <span class="badge" style="background-color: {{ $order->statusColor }}">{{ ucfirst($order->statusI18n) }}</span></p>
        <p class="mb-0">Prix total : {{ \App\NumberConvertor::doubleToPrice($order->totalPrice) }}</p>
        <p class="mb-0">Frais de ports : {{ \App\NumberConvertor::doubleToPrice($order->shippingCosts) }}</p>
        <p class="mb-0"><b>Prix T.T.C. : {{ \App\NumberConvertor::doubleToPrice($order->totalPrice + $order->shippingCosts) }}</b></p>
    </div>

    <div class="col-md-6 d-flex flex-column">
        <a class="btn btn-outline-dark mr-auto mr-md-0 ml-md-auto mb-2" href="{{ route('order.bill', ['order'=>$order]) }}" role="button">
            Voir la facture</a>
    </div>

</div>
