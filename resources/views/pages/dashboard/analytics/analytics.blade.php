@extends('templates.dashboard')

<?php
$turnover_from_beginning = \App\TurnoverCalculator::total($orders);
$turnover_year = \App\TurnoverCalculator::currentYear($orders);
$turnover_month = \App\TurnoverCalculator::currentMonth($orders);

$turnover_total = $turnover_from_beginning['turnover_total'];
$turnover_of_the_year = $turnover_year['turnover_of_the_year'];
$turnover_of_the_month = $turnover_month['turnover_of_the_month'];

$shipping_price_total = $turnover_from_beginning['shipping_price_total'];
$shipping_price_of_the_year = $turnover_year['shipping_price_of_the_year']; 
$shipping_price_of_the_month = $turnover_month['shipping_price_of_the_month'];;

$order_count_total = $turnover_from_beginning['order_count_total'];
$order_count_year = $turnover_year['order_count_year'];
$order_count_month = $turnover_month['order_count_month'];;

$items_count_total = $turnover_from_beginning['items_count_total'];
$items_count_year = $turnover_year['items_count_year'];
$items_count_month = $turnover_month['items_count_month'];;
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

{{--  Calculate Custom turnover  --}}
<script>
$('.datepicker').on('change', function(){
    firstdate = $('#first-date').val();
    lastdate = $('#last-date').val()
    if(firstdate != '' && lastdate != ''){
        $.ajax({
                url : '/dashboard/analyses/calculate_turnover', // on appelle le script JSON
                type: "POST",
                dataType : 'json', // on spécifie bien que le type de données est en JSON
                data : {
                    firstdate: firstdate,
                    lastdate: lastdate
                },
                beforeSend: function(){
                    //button.addClass('running');
                },
                success : function(data){

                    console.log(data)

                    //button.removeClass('running');
                }
            });
    }
});
</script>

{{-- Dates --}}
<script>
jQuery('.datepicker').datetimepicker({
    format:'d/m/Y H:i:00',
});
</script>

@endsection