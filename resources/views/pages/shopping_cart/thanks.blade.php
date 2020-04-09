@extends('templates.cart')

@section('cart.title', "Merci pour votre commande")

@section('cart.content')
{{-- Thanks --}}
<div class="col-12 p-0">
    <div class="thanks bg-white shadow-sm p-3 row m-0">
        <div class="col-2 col-sm-1 col-lg-1 d-flex flex-column justify-content-center p-0">
            <img src="{{ asset('images/icons/success-color.svg') }}" class="w-100" alt="Success">
        </div>
        <div class="col-10 col-sm-11">
            <p class="mb-0">
                @auth
                Vous pouvez retrouvez les informations de votre commande dans votre espace client, rubrique <a href='{{ route('customer.area.orders') }}'>mes commandes</a>.<BR>
                @endauth

                Vous devriez recevoir une confirmation de votre commande par email avec le numéro de suivi de celle-ci.<br>
                Si vous le souhaitez, vous pouvez suivre l'avancement de votre commande <a href='{{ route('order.tracking.show') }}'>ici</a> (votre numéro de suivi est {{ $order->trackingNumber }}).
            </p>
        </div>
    </div>
</div>

<div class="col-12 p-0">
    @auth
    <div class="knowed-by p-3 mt-2 bg-white shadow-sm">
        <h3>Avez vous une petite minute ?</h3>
        <p class="mb-1">Pour nous aider à progresser, dites nous comment vous nous avez connu :</p>
        <form id='know_thanks_to' class='noselect' action="/know_thanks_to/add" method="post">
            @csrf
            <input type="hidden" name='user_id' value="{{Auth::user()->id}}">

            <label class="custom-control custom-radio">
                <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='word_of_mouth'>
                <span class="custom-control-label pt-1">Bouche à oreille</span>
            </label>
            <label class="custom-control custom-radio">
                <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='google'>
                <span class="custom-control-label pt-1">Google</span>
            </label>
            <label class="custom-control custom-radio">
                <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='social_media'>
                <span class="custom-control-label pt-1">Réseaux sociaux</span>
            </label>
            <label class="custom-control custom-radio">
                <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='health_professional'>
                <span class="custom-control-label pt-1">Professionel de la santé</span>
            </label>
            <label class="custom-control custom-radio">
                <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='fair_and_show'>
                <span class="custom-control-label pt-1">Foire et salon</span>
            </label>
            <label class="custom-control custom-radio">
                <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='media'>
                <span class="custom-control-label pt-1">Médias (télévison, radio...)</span>
            </label>
            <label class="custom-control custom-radio">
                <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='other'>
                <span class="custom-control-label pt-1">Autre</span>
            </label>
            <div class="form-group" id='answer-precision-container'>
                <input type="text" class="form-control" name="answer_precision" id="answer_precision" aria-describedby="helpAnswerPrecision" placeholder="">
            </div>
            <button id='send_answer' type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        @endauth
    </div>
</div>

@endsection
