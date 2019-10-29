@extends('templates.blank-template')

@section('title', "Commande #" . $order->id)

@section('content')
<div class="container-fluid">
    <div class="row py-3">
        <div class="col-12 col-sm-6 col-lg-5">
            <div class='address-container p-2 border border-dark'>
                <h1 class='mb-0 h3'><b>Adresse de livraison</b></h1>
            
                <p class='mb-0'>{{$order->shipping_address->civilityToString()}} {{ucfirst($order->shipping_address->firstname)}} {{mb_strtoupper($order->shipping_address->lastname)}}</p>
                @if($order->shipping_address->complement)<small class='m-0'>{{$order->shipping_address->complement}}</small>@endif
                @if($order->shipping_address->company)<small class='mb-0'>{{$order->shipping_address->company}}</small>@endif
                <p class='mb-0'>{{$order->shipping_address->street}}</p>
                <p class='mb-0'>{{$order->shipping_address->zipCode}}, {{$order->shipping_address->city}}</p>

                <div class='customer-infos border-top border-dark pt-2 mt-2'>
                    <p class='mb-0'><u>E-mail</u> : <a class='text-dark' href='mailto:{{$order->user->email}}'>{{$order->user->email}}</a></p>
                    @if($order->user->phone != null)
                    <p class='mb-0'><u>Téléphone</u> : <a class='text-dark' href='tel:{{$order->user->phone}}'>{{chunk_split($order->user->phone, 2, ' ')}}</a></p>
                    @else
                    <p class='mb-0'><u>Téléphone</u> : Aucun numéro renseigné</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-5 offset-lg-2 mt-3 mt-sm-0">
            <div class='address-container p-2 border border-dark'>
                <h1 class='mb-0 h3'><b>Adresse de facturation</b></h1>
                
                <p class='mb-0'>{{$order->billing_address->civilityToString()}} {{ucfirst($order->billing_address->firstname)}} {{mb_strtoupper($order->billing_address->lastname)}}</p>
                @if($order->billing_address->complement)<small class='m-0'>{{$order->billing_address->complement}}</small>@endif
                @if($order->billing_address->company)<small class='mb-0'>{{$order->billing_address->company}}</small>@endif
                <p class='mb-0'>{{$order->billing_address->street}}</p>
                <p class='mb-0'>{{$order->billing_address->zipCode}}, {{$order->billing_address->city}}</p>
            </div>     
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h1 class='h4 mb-0'><b>Commande passée le {{Carbon\Carbon::parse($order->created_at)->formatLocalized('%e %B %Y')}}</b></h1>
            <p class='mb-2 small'>Payée par {{$order->paymentMethodToString()}}</p>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th class='border-bottom-0'>Produits</th>
                        <th class='border-bottom-0 text-right d-none d-sm-table-cell'>Prix unitaire TTC</th>
                        <th class='border-bottom-0 text-center'>Quantité</th>
                        <th class='border-bottom-0 text-right'>TOTAL TTC</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order_items as $item)
                    <tr>
                        <td><small>{{$item->product->name}}</small></td>
                        <td class='text-right d-none d-sm-table-cell'>{{number_format($item->unitPrice, 2)}} €</td>
                        <td class='text-center'>{{$item->quantity}}</td>
                        <td class='text-right'>{{number_format($item->unitPrice * $item->quantity, 2)}} €</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td><small>Une notice d'entretien</small></td>
                        <td class='text-right d-none d-sm-table-cell'>{{number_format(0, 2)}} €</td>
                        <td class='text-center'>1</td>
                        <td class='text-right'>{{number_format(0, 2)}} €</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class='d-none d-sm-table-cell'></td>
                        <td class='text-right'>Sous total TTC</td>
                        <td class='text-right'>{{number_format($order->productsPrice, 2)}} €</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class='d-none d-sm-table-cell'></td>
                        <td class='text-right'>Frais de port</td>
                        <td class='text-right'>{{number_format($order->shippingPrice, 2)}} €</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class='d-none d-sm-table-cell'></td>
                        <td class='text-right'><b>TOTAL TTC</b></td>
                        <td class='text-right'><b>{{number_format($order->shippingPrice + $order->productsPrice, 2)}} €</b></td>
                    </tr>
                </tbody>
                
            </table>
        </div>
    </div>
</div>
@endsection