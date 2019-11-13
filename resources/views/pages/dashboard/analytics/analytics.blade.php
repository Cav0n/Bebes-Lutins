@extends('templates.dashboard')

@section('head-options')
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/datepicker/jquery.datetimepicker.min.css')}}">
    <script src="{{asset('js/datepicker/jquery.datetimepicker.full.min.js')}}"></script>
@endsection

@section('content')
{{--  CUSTOM TURNOVER  --}}
<div class="row border-bottom">
    <div class="col-12">
        <div class="row">
            <div class='col-12 col-sm-6 col-lg-4'>
                <h1 id='turnover-custom' class='h1 m-0 font-weight-bold text-primary text-center mt-3 mb-0'>--,-- €</h1>
                <p class='text-center mb-0'>Chiffre d'affaire</p>
            </div>
            <div class='col-12 col-sm-6 col-lg-4'>
                <h1 id='shipping-price-custom' class='h1 m-0 font-weight-bold text-primary text-center mt-3 mb-0'>--,-- €</h1>
                <p class='text-center mb-0'>Frais de port</p>
            </div>
            <div class='col-12 col-sm-6 col-lg-2'>
                <h1 id='order-count-custom' class='h1 m-0 text-primary text-center mt-3 mb-0'>--</h1>
                <p class='text-center mb-0'>Commandes</p>
            </div>
            <div class='col-12 col-sm-6 col-lg-2'>
                <h1 id='items-count-custom' class='h1 m-0 text-primary text-center mt-3 mb-0'>--</h1>
                <p class='text-center mb-0'>Produits commandés</p>
            </div>
        </div>

        {{--  Date selection  --}}
        <div class='row justify-content-center my-2'>
            <div class="col-12 col-sm-6 d-flex my-2">
                <div class="col-1 p-0 d-flex flex-column justify-content-center">
                    <p class='ml-auto m-0'>Du</p>
                </div>
                <div class="col-11">
                    <input type="text" class="form-control datepicker w-100" name="first-date" id="first-date" aria-describedby="helpFirstDate" placeholder=""> 
                </div>
            </div>
            <div class="col-12 col-sm-6 d-flex my-2">
                <div class="col-1 p-0 d-flex flex-column justify-content-center">
                    <p class='ml-auto m-0'>Au</p>  
                </div>
                <div class="col-11">
                    <input type="text" class="form-control datepicker w-100" name="last-date" id="last-date" aria-describedby="helpFirstDate" placeholder="">                    
                </div>
            </div>
        </div>
    </div>
</div>
{{-- TOTAL TURNOVER --}}
<div class="row border-bottom">
    <div class="col-12 col-sm-6">
        <h1 id='turnover-total' class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>--,-- €</h1>
        <p class='text-center'>Chiffre d'affaire total</p>
    </div>
    <div class="col-12 col-sm-6">
        <h1 id='shipping-price-total' class='h1 m-0 text-secondary text-center mt-3 mb-0'>--,-- €</h1>
        <p class='text-center'>Frais de port totaux</p>
    </div>
</div>
{{-- THIS YEAR TURNOVER --}}
<div class="row border-bottom">
    <div class="col-12 col-sm-6">
        <h1 id='turnover-year' class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>--,-- €</h1>
        <p class='text-center'>Chiffre d'affaire de l'année</p>
    </div>
    <div class="col-12 col-sm-6">
        <h1 id='shipping-price-year' class='h1 m-0 text-secondary text-center mt-3 mb-0'>--,-- €</h1>
        <p class='text-center'>Frais de port de l'année</p>
    </div>
</div>
{{-- THIS MONTH TURNOVER --}}
<div class="row border-bottom">
    <div class="col-12 col-sm-6">
        <h1 id='turnover-month' class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>--,-- €</h1>
        <p class='text-center'>Chiffre d'affaire du mois</p>
    </div>
    <div class="col-12 col-sm-6">
        <h1 id='shipping-price-month' class='h1 m-0 text-secondary text-center mt-3 mb-0'>--,-- €</h1>
        <p class='text-center'>Frais de port du mois</p>
    </div>
</div>

<div class="row border-bottom">
    <div class="col-12 col-sm-6 col-lg-4">
        <h1 id='order-count-total' class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>--</h1>
        <p class='text-center'>Commandes depuit le début</p>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
        <h1 id='order-count-year' class='h1 m-0 text-secondary text-center mt-3 mb-0'>--</h1>
        <p class='text-center'>Commandes cette année</p>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
        <h1 id='order-count-month' class='h1 m-0 text-secondary text-center mt-3 mb-0'>--</h1>
        <p class='text-center'>Commandes ce mois</p>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 col-lg-4">
        <h1 id='items-count-total' class='h1 m-0 font-weight-bold text-secondary text-center mt-3 mb-0'>--</h1>
        <p class='text-center'>Produits commandés depuis le début</p>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
        <h1 id='items-count-year' class='h1 m-0 text-secondary text-center mt-3 mb-0'>--</h1>
        <p class='text-center'>Produits commandés cette année</p>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
        <h1 id='items-count-month' class='h1 m-0 text-secondary text-center mt-3 mb-0'>--</h1>
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
                $('#turnover-custom').text('--,-- €');
                $('#shipping-price-custom').text('--,-- €');
                $('#order-count-custom').text('--');
                $('#items-count-custom').text('--');
            },
            success : function(data){
                console.log(data)

                if(data.order_count > 0){
                    $('#turnover-custom').text(data.turnover + ' €');
                    $('#shipping-price-custom').text(data.shipping_price + ' €');
                    $('#order-count-custom').text(data.order_count);
                    $('#items-count-custom').text(data.items_count);
                } else {
                    $('#turnover-custom').text('--,-- €');
                    $('#shipping-price-custom').text('--,-- €');
                    $('#order-count-custom').text('--');
                    $('#items-count-custom').text('--');
                }
            }
        });
    }
});
</script>

{{--  Init page  --}}
<script>
$(document).ready(function(){
    $.ajax({
        url : '/dashboard/analyses/calculate_all', // on appelle le script JSON
        type: "POST",
        dataType : 'json', // on spécifie bien que le type de données est en JSON

        success : function(data){

            console.log(data)

            $('#turnover-total').text(data.total.turnover+' €');
            $('#turnover-year').text(data.year.turnover+' €');
            $('#turnover-month').text(data.month.turnover+' €');

            $('#shipping-price-total').text(data.total.shipping_price+' €');
            $('#shipping-price-year').text(data.year.shipping_price+' €');
            $('#shipping-price-month').text(data.month.shipping_price+' €');
            
            $('#order-count-total').text(data.total.order_count);
            $('#order-count-year').text(data.year.order_count);
            $('#order-count-month').text(data.month.order_count);

            $('#items-count-total').text(data.total.items_count);
            $('#items-count-year').text(data.year.items_count);
            $('#items-count-month').text(data.month.items_count);
        }
    });
});
</script>

{{-- Dates --}}
<script>
jQuery('.datepicker').datetimepicker({
    format:'d/m/Y H:i:00',
});
</script>

@endsection