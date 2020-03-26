@extends('templates.default')

@section('title', "Créer mon compte - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center py-xl-5">
        <div class="col-11 col-md-10 col-lg-6 col-xl-5 col-xxl-4 col-xxxl-3 py-3 shadow-sm bg-white">
            <h1>Je crée mon compte</h1>
            <form action="{{route('registration')}}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" name="firstname" id="firstname" value="{{ old('firstname') }}">
                    {!! $errors->has('firstname') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('firstname')) . "</div>" : '' !!}
                </div>

                <div class="form-group">
                    <label for="lastname">Nom de famille</label>
                    <input type="text" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" name="lastname" id="lastname" value="{{ old('lastname') }}">
                    {!! $errors->has('lastname') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('lastname')) . "</div>" : '' !!}
                </div>

                <div class="form-group">
                  <label for="phone">Téléphone</label>
                  <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" id="phone" value="{{ old('phone') }}">
                  {!! $errors->has('phone') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('phone')) . "</div>" : '' !!}
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" aria-describedby="helpEmail" value="{{ old('email') }}">
                    {!! $errors->has('email') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('email')) . "</div>" : '' !!}
                    <small id="helpEmail" class="form-text text-muted">Si vous perdez votre mot de passe, nous vour enverrons un lien de récupération à votre adresse mail.</small>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" id="password" aria-describedby="helpPassword">
                    {!! $errors->has('password') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('password')) . "</div>" : '' !!}
                    <small id="helpPassword" class="form-text text-muted">Utilisez un mot de passe avec au moins 8 caractères et une majuscule.</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmez le mot de passe</label>
                    <input type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation" id="password_confirmation" aria-describedby="helpPasswordConfirmation" placeholder="">
                    {!! $errors->has('password_confirmation') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('password_confirmation')) . "</div>" : '' !!}
                    <small id="helpPasswordConfirmation" class="form-text text-muted">Retapez votre mot de passe pour être sûr.</small>
                </div>

                <div class="form-check form-check-inline w-100 d-flex justify-content-center">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter" checked="checked"> Je souhaite recevoir la Newsletter Bébés Lutins
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Créer mon compte</button>

            </form>
        </div>
    </div>
</div>

@endsection
