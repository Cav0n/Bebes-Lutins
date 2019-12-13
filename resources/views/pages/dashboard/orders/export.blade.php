@extends('templates.dashboard')

@section('content')


<div class="card bg-white my-3">
        <div class="card-header bg-white">
            <h1 class='h4 m-0 font-weight-normal'>
                Exportation spécifique
            </h1>
        </div>
    
        <div class="card-body">

            <form action="/dashboard/commandes/generer-exportation" class='d-flex flex-column' method='post'>
                @csrf
                <h2 class='h4'>Dates</h2>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="first_date">Du</label>
                        <input type="date" class="form-control" name="first_date" id="first_date" aria-describedby="helpFirstDate" placeholder="">
                        <small id="helpFirstDate" class="form-text text-muted">La première date à prendre en compte</small>
                    </div>
                    <div class="form-group col-6">
                        <label for="last_date">Au</label>
                        <input type="date" class="form-control" name="last_date" id="last_date" aria-describedby="helpLastDate" placeholder="">
                        <small id="helpLastDate" class="form-text text-muted">La dernière date à prendre en compte</small>
                    </div>
                </div>
                

                <h2 class='h4'>Status</h2>
                <div class="form-check form-check-inline">
                    <label class="form-check-label noselect">
                        <input class="form-check-input noselect" type="checkbox" name="status[]" value="0"> En attente de paiement
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label noselect">
                        <input class="form-check-input noselect" type="checkbox" name="status[]" value="1"> En cours de traitement
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label noselect">
                        <input class="form-check-input noselect" type="checkbox" name="status[]" value="2"> En cours de livraison
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label noselect">
                        <input class="form-check-input noselect" type="checkbox" name="status[]" value="22"> A retirer à l'atelier
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label noselect">
                        <input class="form-check-input noselect" type="checkbox" name="status[]" value="3"> Livrée
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label noselect">
                        <input class="form-check-input noselect" type="checkbox" name="status[]" value="33"> Participation enregistrée
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label noselect">
                        <input class="form-check-input noselect" type="checkbox" name="status[]" value="-1"> Annulée
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label noselect">
                        <input class="form-check-input noselect" type="checkbox" name="status[]" value="-3"> Paiement refusé
                    </label>
                </div>

                <h2 class='h4 mt-3'>Prix</h2>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="minimum_price">Minimum</label>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="minimum_price" name='minimum_price' step="0.01" min='0' aria-describedby="helpMinimumPrice">
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="maximum_price">Maximum</label>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="maximum_price" name='maximum_price' step="0.01" min='0' aria-describedby="helpMaximumPrice">
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div> 
                </div>

                <h2 class='h4'>Frais de port</h2>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="want_shipping_price" id="want_shipping_price" autocomplete="off" checked value=1> Oui
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="want_shipping_price" id="want_shipping_price" autocomplete="off" value=0> Non
                    </label>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class='btn btn-outline-secondary mt-3'>Générer l'exportation</button>   
                    </div>
                </div>
            </form>
    
        </div>
    </div>







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