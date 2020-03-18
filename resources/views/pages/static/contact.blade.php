@extends('templates.default')

@section('title', 'Contactez-nous | Bébés Lutins')

@section('content')

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 card p-0">
                <div class="card-header bg-white">
                    <h1 class="mb-0"><b>Contactez-nous</b></h1>
                </div>
                <div class="card-body row">
                    <div class="col-lg-6 col-xxxl-5 order-1 order-lg-0 mt-3 mt-lg-0">
                        <h2 class="card-title">Moyens de contact</h2>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <h3 class="h4 mb-0">Mail</h3>
                                <a href="mailto:contact@bebes-lutins.fr">contact@bebes-lutins.fr</a>
                            </li>
                            <li class="mb-3">
                                <h3 class="h4 mb-0">Courrier</h3>
                                <p class="mb-0">
                                    <b>ACTYPOLES</b> (Bébés Lutins)<br>
                                    Rue du 19 Mars 1962<br>
                                    63300, THIERS<br>
                                    <em>Nous vous recevons avec plaisir sur rendez-vous.</em><br>
                                </p>
                            </li>
                            <li class="mb-3">
                                <h3 class="h4 mb-0">Téléphone au service client</h3>
                                <a href="tel:0641569165">06 41 56 91 65</a>
                                <p class="mb-0"><em>Katia répondra avec plaisir à vos questions.</em></p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-xxxl-7 order-0 order-lg-0">
                        @if(session()->has('success_message'))
                            <div class="alert alert-success">
                                {{ session()->get('success_message') }}
                            </div>
                        @endif
                        <h2 class="card-title">Formulaire de contact</h2>
                        <form action="/contact" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 col-lg-12 col-xxxl-6">
                                    <label for="firstname">Votre prénom</label>
                                    <input type="text" class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" name="firstname" id="firstname" value="{{ old('firstname') }}">
                                    {!! $errors->has('firstname') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('firstname')) . "</div>" : '' !!}
                                </div>
                                <div class="form-group col-md-6 col-lg-12 col-xxxl-6">
                                    <label for="lastname">Votre nom de famille</label>
                                    <input type="text" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" name="lastname" id="lastname" value="{{ old('lastname') }}">
                                    {!! $errors->has('lastname') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('lastname')) . "</div>" : '' !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Votre email</label>
                                <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" aria-describedby="helpEmail" placeholder="" value="{{ old('email') }}">
                                {!! $errors->has('email') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('email')) . "</div>" : '' !!}
                                <small id="helpEmail" class="form-text text-muted">Nous avons besoin de connaitre votre email pour vous répondre.</small>
                            </div>
                            <div class="form-group">
                                <label for="message">Votre message</label>
                                <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message" rows="5">{{ old('message') }}</textarea>
                                {!! $errors->has('message') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('message')) . "</div>" : '' !!}
                            </div>
                            <button type="submit" class="btn btn-primary">Envoyer mon message</button>
                        </form>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <a href="/">Retour à la boutique</a>
                </div>
            </div>
        </div>
    </div>
@endsection
