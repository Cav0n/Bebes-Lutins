@extends('templates.email')

@section('content')
<main class='row justify-content-center m-0 my-5 px-4 px-sm-0'>
    <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <h1 class="text-primary h2">Votre commande à été enregistrée !</h1>
        <p class="text-justify">
            Nous vous remercions d'avoir passé commande sur notre site !
            Nous nous occupons de celle ci dans les plus brefs délais.
            Vous pouvez vérifier son état dans votre <a href='https://www.bebes-lutins.fr/espace-client/commandes'>espace client</a>.<BR>
            L'identifiant de cette commande est : <b>#{{$order->id}}</b><BR>
            <BR>
            Belle journée,<BR>
            L'équipe Bébés Lutins 💚
        </p>

        <div class="row m-0 py-4">
            <?php $shipping_address = $order->shipping_address;?>
            <?php $billing_address = $order->billing_address;?>
            <div class="col-12 p-0 d-flex justify-content-between">
                <div class='adress-informations'>
                    <p class='h5 mb-0'>Adresse de livraison</p>
                    @if($shipping_address != null)
                        @if($shipping_address->company != null) <p class='mb-0 small'>{{mb_strtoupper($shipping_address->company)}}</p> @endif
                        @if($shipping_address->complement != null) <p class='mb-0 small'>{{mb_strtoupper($shipping_address->complement)}}</p> @endif
                        <p class='mb-0'>{{$shipping_address->civilityToString() . ' ' . ucfirst($shipping_address->firstname) . " " . mb_strtoupper($shipping_address->lastname)}}</p>
                        <p class='mb-0'>{{$shipping_address->street}}, {{$shipping_address->zipCode}},</p>
                        <p class='mb-0'>{{mb_strtoupper($shipping_address->city)}}</p>
                    @else
                        <p class='mb-0'>Livraison à l'atelier</p>
                    @endif
                </div>
                <div class='adress-informations'>
                    <p class='h5 mb-0'>Adresse de facturation</p>
                    @if($billing_address != null)
                        @if($billing_address->company != null) <p class='mb-0 small'>{{mb_strtoupper($billing_address->company)}}</p> @endif
                        @if($billing_address->complement != null) <p class='mb-0 small'>{{mb_strtoupper($billing_address->complement)}}</p> @endif
                        <p class='mb-0'>{{$billing_address->civilityToString() . ' ' . ucfirst($billing_address->firstname) . " " . mb_strtoupper($billing_address->lastname)}}</p>
                        <p class='mb-0'>{{$billing_address->street}}, {{$billing_address->zipCode}},</p>
                        <p class='mb-0'>{{mb_strtoupper($billing_address->city)}}</p>
                    @else
                        <p class='mb-0'>Identique à l'adresse de livraison</p>
                    @endif
                </div>
            </div>
        </div>

        <table class='table mb-0'>
            <tbody>
                @foreach($order->order_items as $item)
                <tr>
                    <td class='d-none d-md-table-cell'><img src='{{asset("images/products/".$item->product->mainImage)}}' class='w-100' style='object-fit:cover;max-width:10rem;'></td>
                    <td><small>{{$item->product->name}} @if(count($item->characteristics) > 0) @foreach($item->characteristics as $characteristic) - {{$characteristic->selectedOptionName}} @endforeach @endif</small></td>
                    <td class='d-none d-sm-table-cell text-right'>{{number_format($item->unitPrice, 2)}}€</td>
                    <td>x{{$item->quantity}}</td>
                    <td class="text-right">{{number_format($item->unitPrice * $item->quantity, 2)}}€</td>
                </tr>
                @endforeach
                @if($order->voucher != null)
                <tr>
                    <td class='d-none d-md-table-cell'></td>
                    <td></td>
                    <td class='d-none d-sm-table-cell text-right'></td>
                    <td>CODE COUPON</td>
                    <td class="text-right">{{strtoupper($order->voucher->code)}}</td>
                </tr>
                @endif
                <tr>
                    <td class='d-none d-md-table-cell'></td>
                    <td></td>
                    <td class='d-none d-sm-table-cell text-right'></td>
                    <td>SOUS TOTAL TTC</td>
                    <td class="text-right">{{number_format($order->productsPrice, 2)}}€</td>
                </tr>
                <tr>
                    <td class='d-none d-md-table-cell'></td>
                    <td></td>
                    <td class='d-none d-sm-table-cell text-right'></td>
                    <td >FRAIS DE PORT</td>
                    <td class="text-right">{{number_format($order->shippingPrice, 2)}}€</td>
                </tr>
                <tr>
                    <td class='d-none d-md-table-cell'></td>
                    <td></td>
                    <td class='d-none d-sm-table-cell text-right'></td>
                    <td><b>TOTAL TTC</b></td>
                    <td class="text-right"><b>{{number_format($order->productsPrice + $order->shippingPrice, 2)}}€</b></td>
                </tr>
            </tbody>
        </table>
        <p class='text-right'><small>
            Payé par {{$order->paymentMethodToString()}}
        </small></p>

        <p class="m-0"><small>
            <b>Informations supplémentaires :</b><BR>
            {{$order->customerMessage}}
        </small></p>
    </div>
</main>
@endsection