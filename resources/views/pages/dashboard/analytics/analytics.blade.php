@extends('templates.dashboard')

<?php 
$turnover_total = 0;
$turnover_of_the_year = 0;
$turnover_of_the_month = 0;

$shipping_price_total = 0;
$shipping_price_of_the_year = 0; 
$shipping_price_of_the_month = 0;

$order_count_total = 0;
$order_count_year = 0;
$order_count_month = 0;

$items_count_total = 0;
$items_count_year = 0;
$items_count_month = 0;


foreach($orders as $order){
    $turnover_total += $order->productsPrice + $order->shippingPrice;
    $shipping_price_total += $order->shippingPrice;
    $order_count_total++;
    $items_count = 0;
    foreach ($order->order_items as $item) {
        $items_count += $item->quantity; }
    $items_count_total += $items_count;

    if(Carbon\Carbon::parse($order->created_at)->gte(Carbon\Carbon::create(Carbon\Carbon::now()->year, 1, 1, 0, 0, 0))){
        $turnover_of_the_year += $order->productsPrice + $order->shippingPrice;
        $shipping_price_of_the_year += $order->shippingPrice;
        $order_count_year++;
        $items_count_year += $items_count;

    }

    if(Carbon\Carbon::parse($order->created_at)->gte(Carbon\Carbon::create(Carbon\Carbon::now()->year, Carbon\Carbon::now()->month, 1, 0, 0, 0))){
        $turnover_of_the_month += $order->productsPrice + $order->shippingPrice;
        $shipping_price_of_the_month += $order->shippingPrice;
        $order_count_month++;
        $items_count_month += $items_count;

    }
}
?>

@section('head-options')
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/datepicker/jquery.datetimepicker.min.css')}}">
    <script src="{{asset('js/datepicker/jquery.datetimepicker.full.min.js')}}"></script>
@endsection

@section('content')
{{--  CUSTOM TURNOVER  --}}
<div class="row border-bottom">
    <div class="col-12">
        <h1 class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>{{number_format($turnover_total, 2, '.', ' ')}} €</h1>
        <p class='text-center mb-0'>Chiffre d'affaire</p>
        <div class='d-flex justify-content-center mb-2'>
            <p class='m-0 mr-2 d-flex flex-column justify-content-center'>Du</p>
            <input type="text" class="form-control datepicker w-25 mr-2" name="first-date" id="first-date" aria-describedby="helpFirstDate" placeholder="">
            <p class='m-0 mr-2 d-flex flex-column justify-content-center'>au</p>
            <input type="text" class="form-control datepicker w-25 ml-2" name="last-date" id="last-date" aria-describedby="helpFirstDate" placeholder="">
        </div>
    </div>
</div>
{{-- TOTAL TURNOVER --}}
<div class="row border-bottom">
    <div class="col-12 col-md-6">
        <h1 class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>{{number_format($turnover_total, 2, '.', ' ')}} €</h1>
        <p class='text-center'>Chiffre d'affaire total</p>
    </div>
    <div class="col-12 col-md-6">
        <h1 class='h1 m-0 text-secondary text-center mt-3 mb-0'>{{number_format($shipping_price_total, 2, '.', ' ')}} €</h1>
        <p class='text-center'>Frais de port totaux</p>
    </div>
</div>
{{-- THIS YEAR TURNOVER --}}
<div class="row border-bottom">
    <div class="col-12 col-md-6">
        <h1 class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>{{number_format($turnover_of_the_year, 2, '.', ' ')}} €</h1>
        <p class='text-center'>Chiffre d'affaire de l'année</p>
    </div>
    <div class="col-12 col-md-6">
        <h1 class='h1 m-0 text-secondary text-center mt-3 mb-0'>{{number_format($shipping_price_of_the_year, 2, '.', ' ')}} €</h1>
        <p class='text-center'>Frais de port de l'année</p>
    </div>
</div>
{{-- THIS MONTH TURNOVER --}}
<div class="row border-bottom">
    <div class="col-12 col-md-6">
        <h1 class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>{{number_format($turnover_of_the_month, 2, '.', ' ')}} €</h1>
        <p class='text-center'>Chiffre d'affaire du mois</p>
    </div>
    <div class="col-12 col-md-6">
        <h1 class='h1 m-0 text-secondary text-center mt-3 mb-0'>{{number_format($shipping_price_of_the_month, 2, '.', ' ')}} €</h1>
        <p class='text-center'>Frais de port du mois</p>
    </div>
</div>

<div class="row border-bottom">
    <div class="col-12 col-md-6 col-lg-4">
        <h1 class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>{{$order_count_total}}</h1>
        <p class='text-center'>Commandes depuit le début</p>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <h1 class='h1 m-0 text-secondary text-center mt-3 mb-0'>{{$order_count_year}}</h1>
        <p class='text-center'>Commandes cette année</p>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <h1 class='h1 m-0 text-secondary text-center mt-3 mb-0'>{{$order_count_month}}</h1>
        <p class='text-center'>Commandes ce mois</p>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-4">
        <h1 class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>{{$items_count_total}}</h1>
        <p class='text-center'>Produits commandés depuis le début</p>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <h1 class='h1 m-0 text-secondary text-center mt-3 mb-0'>{{$items_count_year}}</h1>
        <p class='text-center'>Produits commandés cette année</p>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <h1 class='h1 m-0 text-secondary text-center mt-3 mb-0'>{{$items_count_month}}</h1>
        <p class='text-center'>Produits commandés ce mois</p>
    </div>
</div>

{{-- Dates --}}
<script>
jQuery('.datepicker').datetimepicker({
    format:'d/m/Y H:i:00',
});
</script>

@endsection