@extends('templates.simple')

@section('title', 'Facture ' . $order->trackingNumber . ' | Bébés Lutins')

@section('content')

    <div class="row p-3">
        <div class="col-5 border border-dark p-2">
            <h1 class="h2 mb-0"><b>Adresse de livraison</b></h1>
            <div>
                @if(null !== $order->shippingAddress)
                    <p class="mb-0">
                        {{ $order->shippingAddress->minCivilityI18n }}
                        {{ $order->shippingAddress->firstname }}
                        {{ $order->shippingAddress->lastname }}
                    </p>
                    <p class="mb-0">
                        {{ $order->shippingAddress->street }}
                    </p>
                    <p class="mb-0">
                        {{ $order->shippingAddress->zipCode }},
                        {{ $order->shippingAddress->city }}
                    </p>
                @else
                    <p>Retrait à l'atelier</p>
                @endif

            </div>
            <div>
                <p class="mb-0">
                    <u>Email</u> : {{ strtolower($order->email) }}
                </p>
                <p class="mb-0">
                    <u>Téléphone</u> : {{ chunk_split($order->phone, 2, ' ') }}
                </p>
            </div>
        </div>
        <div class="col-5 offset-2 border border-dark  p-2">
            <h1 class="h2 mb-0"><b>Adresse de facturation</b></h1>
            <div>
                <p class="mb-0">
                    {{ $order->billingAddress->minCivilityI18n }}
                    {{ $order->billingAddress->firstname }}
                    {{ $order->billingAddress->lastname }}
                </p>
                <p class="mb-0">
                    {{ $order->billingAddress->street }}
                </p>
                <p class="mb-0">
                    {{ $order->billingAddress->zipCode }},
                    {{ $order->billingAddress->city }}
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h1 class="h4 mb-0">
                <b>Commande passée le {{ $order->created_at->format('d / m / Y à H:i') }}</b>
            </h1>
            <p class="mb-0">Payée par {{ $order->paymentMethodI18n }}.</p>
            @if ($order->comment)
                <p class="mb-0"><u>Message du client</u> : {{ $order->comment }}</p>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <table class="table table-striped border">
                <thead>
                    <tr>
                        <th scope="col">Produit</th>
                        <th scope="col" class="text-center">Quantité</th>
                        <th scope="col" class="text-right">Prix unitaire T.T.C.</th>
                        <th scope="col" class="text-right">Total T.T.C.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td>{{ '#'.$item->product->reference }} - {{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ \App\NumberConvertor::doubleToPrice($item->unitPrice) }}</td>
                        <th class="text-right">{{ \App\NumberConvertor::doubleToPrice($item->quantity * $item->unitPrice) }}</td>
                    </tr>
                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right">Sous-total T.T.C. :</td>
                        <th class="text-right">{{ \App\NumberConvertor::doubleToPrice($order->totalPrice) }}</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right">Frais de port :</td>
                        <th class="text-right">{{ \App\NumberConvertor::doubleToPrice($order->shippingCosts) }}</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right">Total T.T.C. :</td>
                        <th class="text-right">{{ \App\NumberConvertor::doubleToPrice($order->totalPrice + $order->shippingCosts) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
