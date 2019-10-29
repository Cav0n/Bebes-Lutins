@extends('templates.blank-template')

@section('title', $customer->firstname . ' ' . $customer->lastname)

@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <h1><b>{{$customer->firstname}} {{$customer->lastname}}</b></h1>
            <p class='mb-0'><a href='mailto:{{$customer->email}}' class='text-dark'>{{$customer->email}}</a></p>
            <p class='mb-0'><a href='tel:{{$customer->phone}}' class='text-dark'>{{chunk_split($customer->phone, 2, ' ')}}</a></p>
            <p class='mb-0'>Inscrit depuis le {{Carbon\Carbon::parse($customer->created_at)->formatLocalized('%e %B %Y')}}</p>  
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <h2 class='m-0'>Commandes</h2>
            <div class="row m-0">   
                @foreach ($customer->orders as $order)
                <div class='order-container col-12 col-sm-6 col-md-4 col-lg-3 p-0'>
                    <div class='order border p-2 m-2'>
                        <a class='h6 m-0' href='/dashboard/commandes/fiche/{{$order->id}}'>#{{$order->id}}</a>
                        <p class='m-0'>Prix total : {{number_format($order->productsPrice, 2)}} €</p>
                        <p class='m-0'>Frais de livraison : {{number_format($order->shippingPrice, 2)}} €</p>
                        <p class='m-0'>Payé par : {{$order->paymentMethodToString()}}</p>
                        <small class='m-0 ml-auto d-flex max-content'>Le {{Carbon\Carbon::parse($order->created_at)->formatLocalized('%e %B %Y')}}</small>
                    </div>
                </div>
                @endforeach 
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <h2 class='m-0'>Adresses</h2>
            <div class="row m-0">
                @foreach ($customer->addresses as $address)
                <div class='address-container col-12 col-sm-6 col-md-4 col-lg-3 p-0'>
                    <div class='address border p-2 m-2'>
                        @if($address->complement != null)<small class='m-0'>{{$address->complement}}</small>@endif
                        @if($address->company != null)<small class='m-0'>{{strtoupper($address->company)}}</small>@endif
                        <p class='m-0'>{{$address->civilityToString()}} {{ucfirst($address->firstname)}} {{mb_strtoupper($order->shipping_address->lastname)}}</p>
                        <p class='m-0'>{{$address->street}}</p>
                        <p class='m-0'>{{$address->zipCode}}, {{$address->city}}</p>
                        <small class='m-0 ml-auto d-flex max-content'>Le {{Carbon\Carbon::parse($order->created_at)->formatLocalized('%e %B %Y')}}</small>
                    </div>
                </div>
                @endforeach 
            </div>
        </div>
    </div>
</div>
@endsection