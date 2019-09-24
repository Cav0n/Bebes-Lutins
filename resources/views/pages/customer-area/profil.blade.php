@extends('templates.customer-area')

@section('body')
<div class="row">
    <div class="col-10">
        <p class='h5 font-weight-bold'>Mes informations personnelles</p>
        <p class='mb-0'>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        <p class='mb-0'>Inscrit depuis le : {{ Auth::user()->created_at }}</p>
        <p class='mb-0'>Date de naissance : PAS ENCORE</p>
        <p class='mb-0'>Téléphone : {{ trim( chunk_split(Auth::user()->phone, 2, ' ')) }} </p>
    </div>
    <div class="col-2">
        <button type="button" class="btn btn-dark border w-100">Modifier</button>
    </div>
</div>
<div class="row mt-4 pt-4 border-top">
    <div class="col-10">
        <p class='h5 font-weight-bold'>Mot de passe</p>
        <p class='mb-0'>Vous pouvez modifier votre mot de passe à tout moment.</p>
    </div>
    <div class="col-2">
        <button type="button" class="btn btn-dark border w-100">Modifier</button>
    </div>
</div>
<div class="row mt-4 pt-4 border-top">
    <div class="col-10">
        <p class='h5 font-weight-bold'>Newsletter</p>
        <p class='mb-0'> Vous avez indiqué vouloir recevoir les actualités Bébés Lutins.</p>
    </div>
    <div class="col-2">
        <button type="button" class="btn btn-dark border w-100">Désactiver</button>
    </div>
</div>
    
@endsection