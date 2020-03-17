@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Commandes</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.orders') }}" class="input-group" method="GET">
            <input class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}" type="text" name="search" placeholder="Rechercher une commande" value="{{ old('search') }}">
            <div class="input-group-append">
                <button class="input-group-text" id="my-addon">Rechercher</button>
            </div>
            {!! $errors->has('search') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('search')) . "</div>" : '' !!}
        </form>
        <small id="helpSearch" class="form-text text-muted">Vous pouvez rechercher un client ou un numéro de commande</small>

        @if(isset($inSearch))
            <a class="btn btn-dark mt-2" href="{{ route('admin') }}" role="button">Annuler la recherche</a>
        @endif

        @if(!count($orders))
            <p class="mb-0 mt-3">Aucun résultat ne correpond.</p>
        @endif

        @if(count($orders))
        <table class="table table-light mt-2 mb-0 border">
            <thead class="thead-light">
                <tr>
                    <th class="d-none d-md-table-cell">ID</th>
                    <th class='text-center'>Date</th>
                    <th>Client</th>
                    <th>Prix</th>
                    <th class="d-none d-lg-table-cell">Numéro de suivi</th>
                    <th class='text-center d-none d-xl-table-cell'>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td class="d-none d-md-table-cell"> {{ $order->id }} </td>
                    <td class='text-center'>
                        {{ $order->created_at->format('d/m/Y') }}
                        <br> {{ $order->created_at->format('H:i') }}
                    </td>
                    <td>
                        <b>{{ ucfirst($order->billingAddress->minCivilityI18n) . ' ' .
                        $order->billingAddress->firstname . ' ' .
                        $order->billingAddress->lastname }}</b>
                    </td>
                    <td>
                        {{ \App\NumberConvertor::doubleToPrice($order->totalPrice) }}
                        @if(0 < $order->shippingCosts)
                        <br> <small>Dont {{ \App\NumberConvertor::doubleToPrice($order->shippingCosts) }} de fdp</small>
                        @endif
                    </td>
                    <td class="d-none d-lg-table-cell">
                        {{ $order->trackingNumber }}
                    </td>
                    <td class='text-center d-none d-xl-table-cell'>
                        <div class="form-group mb-0">
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
                    </td>
                    <th class='text-right'>
                        <a class="btn btn-outline-dark" href="{{ route('admin.order.show', ['order' => $order]) }}" role="button">Voir</a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection

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
