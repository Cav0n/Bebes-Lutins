@extends('templates.customer-area')

@section('body')
<div class="row">
    <div class="col-10 col-md-9 col-xl-10">
        <p class='h5 font-weight-bold'>Mes informations personnelles</p>
        <p class='mb-0'>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        <p class='mb-0'>Inscrit depuis le : {{ Auth::user()->created_at }}</p>
        <p class='mb-0'>Date de naissance : PAS ENCORE</p>
        <p class='mb-0'>Téléphone : {{ trim( chunk_split(Auth::user()->phone, 2, ' ')) }} </p>
    </div>
    <div class="col-2 col-md-3 col-xl-2">
        <button id='desktop-button' type="button" class="btn btn-dark border w-100 d-none d-md-flex"><p class='text-center mb-0 mx-auto'>Modifier</p></button>
        <button id='desktop-button' type="button" class="btn btn-dark border w-100 d-flex d-md-none"><img class='svg' src="{{asset('images/icons/edit.svg')}}" style='height:1.4rem; width:1.4rem;'></button>
    </div>
</div>
<div class="row mt-4 pt-4 border-top">
    <div class="col-10 col-md-9 col-xl-10">
        <p class='h5 font-weight-bold'>Mot de passe</p>
        <p class='mb-0'>Vous pouvez modifier votre mot de passe à tout moment.</p>
    </div>
    <div class="col-2 col-md-3 col-xl-2">
        <button id='desktop-button' type="button" class="btn btn-dark border w-100 d-none d-md-flex"><p class='text-center mb-0 mx-auto'>Modifier</p></button>
        <button id='desktop-button' type="button" class="btn btn-dark border w-100 d-flex d-md-none"><img class='svg' src="{{asset('images/icons/edit.svg')}}" style='height:1.4rem; width:1.4rem;'></button>
    </div>
</div>
<div class="row mt-4 pt-4 border-top">
    <div class="col-10 col-md-9 col-xl-10">
        <p class='h5 font-weight-bold'>Newsletter</p>
        <p class='mb-0'> Vous avez indiqué vouloir recevoir les actualités Bébés Lutins.</p>
    </div>
    <div class="col-2 col-md-3 col-xl-2">
        <button id='desktop-button' type="button" class="btn btn-dark border w-100 d-none d-md-flex"><p class='text-center mb-0 mx-auto'>Modifier</p></button>
        <button id='desktop-button' type="button" class="btn btn-dark border w-100 d-flex d-md-none"><img class='svg' src="{{asset('images/icons/edit.svg')}}" style='height:1.4rem; width:1.4rem;'></button>
    </div>
</div>
    
@endsection