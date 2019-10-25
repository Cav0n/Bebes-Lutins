@extends('templates.template')

@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/shopping-cart/index.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading-btn.css')}}">
@endsection

@section('content')
<main>
    <div class="row justify-content-center py-5 dim-background">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="col-12 p-3 bg-white border">
                <h1 class='d-flex'>
                    Merci pour votre commande. 
                    <div class='svg-container ml-2 mt-1' style="max-height:2rem;max-width:2rem;">
                        <img src="{{asset('images/icons/success.svg')}}" alt="" class='svg h-100 w-100' style=''>
                    </div>
                </h1>
                <p class='mb-0'>Vous allez recevoir une confirmation de commande par mail.</p>
                <p>Retrouvez le suivi de votre commande dans votre espace "mon compte", rubrique "mes commandes". </p>
                <div class="col-12 p-0 d-flex justify-content-center">
                    <button class='btn btn-primary rounded-0'>Voir ma commande</button>                    
                </div>
            </div>
        </div>
    </div>
</main>
@endsection