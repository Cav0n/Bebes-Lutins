@extends('templates.template')

@section('title', 'Contact - Bébés Lutins')

@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row justify-content-center m-0 bg-light">
    <div class="col-lg-6 m-3 p-0">
        <div class="card">
            <div class='card-header'>
                <h2 class='mb-0'>Contactez-nous</h2>
            </div>
            
            <div class='card-body'>
                <form action="/contact/envoie-message">
                    <div class="form-group">
                        <label for="name">Votre nom</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="" aria-describedby="helpName">
                        <small id="helpName" class="text-muted">Votre nom et prénom</small>
                    </div>
                    <div class="form-group">
                        <label for="email">Votre adresse mail</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpEmail">
                        <small id="helpEmail" class="text-muted">Nous avons besoin de votre adresse pour vous répondre</small>
                    </div>
                    <div class="form-group">
                        <label for="message">Votre message</label>
                        <textarea name="message" id="message" class="form-control" cols="30" rows="7"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary">Envoyer</button>
                </form>
                <div class='border-top mt-3 pt-3'>
                    <p>Vous pouvez aussi nous contacter par :</p>

                    <h3 class='h4 mb-0'>Mail</h3>
                    <p>À l'adresse <a class='text-dark' href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a></p>

                    <h3 class='h4 mb-0'>Courrier</h3>
                    <p>
                        <b>ACTYPOLES</b> (Bébés Lutins)<BR>
                        Rue du 19 Mars 1962<BR>
                        63300 THIERS<BR>
                        <i>Nous vous recevons avec plaisir sur rendez-vous.</i></p>

                    <h3 class='h4 mb-0'>Téléphone au service client</h3>
                    <p class='mb-0'>
                        <a class='text-dark' href='tel:0641569165'>06 41 56 91 65</a><BR>
                        <i>Katia répondra avec plaisir à vos questions.</i>
                    </p>
                </div>
            </div>
            
        </form>
    </div>
</div>
@endsection