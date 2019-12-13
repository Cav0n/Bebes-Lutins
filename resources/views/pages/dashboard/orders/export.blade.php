@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Exportation de commandes
        </h1>
    </div>

    <div class="card-body">

            <div id='orders-container'>
                <div class="row">
                    <div class="col-12 d-flex flex-row flex-wrap">
                        <button type="button" class="btn btn-secondary" onclick="fnExcelReport();">
                            Exporter vers Excel</button>
                        <button type="button" class="btn btn-secondary ml-3" onclick="javascript:xport.toCSV('Commandes');">
                            Exporter vers Numbers</button>
                    </div>
                </div>
                <table id='Commandes' class="table">
                    <thead>
                        <tr>
                            <th class='border-top-0'>Date</th>
                            <th class='border-top-0'>Nom</th>
                            <th class='border-top-0'>Prénom</th>
                            <th class='border-top-0'>Montant HT</th>
                            <th class='border-top-0'>TVA</th>
                            <th class='border-top-0'>Montant TTC</th>
                            <th class='border-top-0'>Dont frais de port</th>
                            <th class='border-top-0'>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        @php
                        $price_TTC = $order->productsPrice + $order->shippingPrice;
                        $price_HT = $price_TTC / 1.2;
                        $TVA = $price_TTC - $price_HT;
                        @endphp
                        <tr>
                            <td>{{$order->created_at->format('j / n / Y')}}</td>
                            <td>{{mb_strtoupper($order->user->lastname)}}</td>
                            <td>{{ucfirst(mb_strtolower($order->user->firstname))}}</td>
                            <td>{{number_format($price_HT, 2)}}€</td>
                            <td>{{number_format($TVA, 2)}}€</td>
                            <td>{{number_format($price_TTC, 2)}}€</td>
                            <td>{{number_format($order->shippingPrice, 2)}}€</td>
                            <td>{{ucfirst(\App\OrderStatus::statusToString($order->status))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

    </div>
</div>

<script src="{{asset('/js/excel-export.js')}}"></script>
@endsection