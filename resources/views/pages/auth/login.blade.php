@extends('templates.default')

@section('title', "Connexion - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center py-xl-5">
        <div class="col-11 col-md-10 col-lg-6 col-xl-5 col-xxl-4 col-xxxl-3 p-0">
            <div class="p-3 border bg-white">
                <h1>Connexion</h1>

                <form action="{{route('login')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" aria-describedby="helpEmail" value="{{ old('email') }}">
                        {!! $errors->has('email') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('email')) . "</div>" : '' !!}
                        <small id="helpEmail" class="form-text text-muted">
                           <a href="{{route('registration')}}">Vous n'avez pas encore de compte ?</a>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" id="password" aria-describedby="helpPassword">
                        {!! $errors->has('password') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('password')) . "</div>" : '' !!}
                        <small id="helpPassword" class="form-text text-muted">
                            <a href="{{ route('password.lost.form') }}">Vous avez perdu votre mot de passe ?</a>
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
