@extends('templates.template')

@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/shopping-cart/index.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading-btn.css')}}">
@endsection

@section('content')
<main>
    <div class="row justify-content-center py-5 dim-background m-0">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="col-12 p-3 bg-white border">
                <h1 class='d-flex'>
                    <div class='svg-container mr-2 mt-1 d-none d-md-block' style="max-height:2rem;max-width:2rem;">
                        <img src="{{asset('images/icons/error.svg')}}" alt="" class='svg h-100 w-100' style=''>
                    </div>
                    Une erreur s'est produite. 
                </h1>
                <p class='mb-0'>Une erreur s'est produite lors du paiement de votre commande.</p>
                <p>Nous vous invitons à repasser votre commande ou à nous contacter.</p>
                <div class="col-12 p-0 d-flex justify-content-center">
                    <a class='btn btn-primary rounded-0' href='/contact'>Contactez-nous</a>                    
                </div>
            </div>
        </div>
    </div>
</main>
@endsection