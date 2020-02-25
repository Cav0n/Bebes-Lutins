@extends('templates.default')

@section('title', "Créer mon compte - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center py-xl-5">
        <div class="col-11 col-md-10 col-lg-6 col-xl-5 col-xxl-4 col-xxxl-3 py-3 border bg-white">
            <h1>Je crée mon compte</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('registration')}}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" name="firstname" id="firstname">
                </div>

                <div class="form-group">
                    <label for="lastname">Nom de famille</label>
                    <input type="text" class="form-control" name="lastname" id="lastname">
                </div>

                <div class="form-group">
                  <label for="phone">Téléphone</label>
                  <input type="text" class="form-control" name="phone" id="phone">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="helpEmail">
                    <small id="helpEmail" class="form-text text-muted">Si vous perdez votre mot de passe, nous vour enverrons un lien de récupération à votre adresse mail.</small>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" aria-describedby="helpPassword">
                    <small id="helpPassword" class="form-text text-muted">Utilisez un mot de passe avec au moins 8 caractères et une majuscule.</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmez le mot de passe</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" aria-describedby="helpPasswordConfirmation" placeholder="">
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
