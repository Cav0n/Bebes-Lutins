@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Commandes</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.order') }}" class="input-group" method="GET">
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
        <table class="table table-light mt-2 mb-0">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th class='text-center'>Date</th>
                    <th>Client</th>
                    <th>Prix</th>
                    <th>Numéro de suivi</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td> {{ $order->id }} </td>
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
                    <td>
                        {{ $order->trackingNumber }}
                    </td>
                    <td>
                        <span class="badge" style='background-color: {{ $order->statusColor }}'>{{ ucfirst($order->statusI18n) }}</span>
                    </td>
                    <th><a class="btn btn-outline-dark" href="{{ route('admin.order.show', ['order' => $order]) }}" role="button">Voir</a></th>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection
