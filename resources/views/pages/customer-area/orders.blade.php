@extends('templates.customer-area')

@section('body')
<div class="row">
    <div class="col-12">
        <p class='h5 font-weight-bold'>Vos commandes</p>

        @if (count($orders) == 0)
            <p class='mb-0'>Vous n'avez passé aucune commande pour le moment.</p>
        @else
        {{$orders->links()}}  
            @foreach ($orders as $order)
            <?php 
            $shipping_address = $order->shipping_address; 
            $billing_address = $order->billing_address;
            ?>
            <div class="row my-2">
                <div class="col-12">
                    <div class='order-container p-2 border'>
                        <p class='mb-0 font-weight-bold'>Commande passée le {{$order->created_at->formatLocalized('%e %B %Y')}} {!! $order->statusToBadge() !!}</p>
                        <p class='mb-0 mt-2'>Prix total : {{number_format($order->productsPrice + $order->shippingPrice, 2)}} €</p>
                        <p class='mb-2'>Frais de livraison : {{number_format($order->shippingPrice, 2)}} €</p>
                        <div class="row m-0">
                            <div class="col-12 p-0 d-flex justify-content-between">
                                <div class='adress-informations'>
                                    <p class='h5 mb-0'>Adresse de livraison</p>
                                    @if($shipping_address->company != null) <p class='mb-0 small'>{{mb_strtoupper($shipping_address->company)}}</p> @endif
                                    @if($shipping_address->complement != null) <p class='mb-0 small'>{{mb_strtoupper($shipping_address->complement)}}</p> @endif
                                    <p class='mb-0'>{{$shipping_address->civilityToString() . ' ' . ucfirst($shipping_address->firstname) . " " . mb_strtoupper($shipping_address->lastname)}}</p>
                                    <p class='mb-0'>{{$shipping_address->street}}, {{$shipping_address->zipCode}},</p>
                                    <p class='mb-0'>{{mb_strtoupper($shipping_address->city)}}</p>
                                </div>
                                <div class='adress-informations'>
                                    <p class='h5 mb-0'>Adresse de livraison</p>
                                    @if($billing_address->company != null) <p class='mb-0 small'>{{mb_strtoupper($billing_address->company)}}</p> @endif
                                    @if($billing_address->complement != null) <p class='mb-0 small'>{{mb_strtoupper($billing_address->complement)}}</p> @endif
                                    <p class='mb-0'>{{$billing_address->civilityToString() . ' ' . ucfirst($billing_address->firstname) . " " . mb_strtoupper($billing_address->lastname)}}</p>
                                    <p class='mb-0'>{{$billing_address->street}}, {{$billing_address->zipCode}},</p>
                                    <p class='mb-0'>{{mb_strtoupper($billing_address->city)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row m-0">
                        @foreach ($order->order_items as $item)
                            <div class="row w-100 m-0 mt-2 border">
                                <div class="col-12 col-lg-2 p-0" style="max-height: 10rem;">
                                    <img class='w-100 h-100' src='{{asset("images/products/".$item->product->mainImage)}}' style='object-fit:cover;'>
                                </div>
                                <div class="col-6 col-lg-6 d-flex flex-column justify-content-center">
                                    <small>{{$item->productName}}</small>
                                </div>
                                <div class="col-3 col-lg-2 p-0 d-flex flex-column justify-content-center">
                                    <p class='mb-0 text-center'>{{number_format($item->unitPrice, 2)}} €</p>
                                </div>
                                <div class="col-3 col-lg-2 p-0 d-flex flex-column justify-content-center">
                                    <p class='mb-0 text-center'>x {{$item->quantity}}</p>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        
    </div>
</div>
@endsection