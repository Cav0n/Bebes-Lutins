@extends('templates.default')

@section('title', "Connexion - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center py-xl-5">
        <div class="col-11 col-md-10 col-lg-6 col-xl-5 col-xxl-4 col-xxxl-3 py-3 border bg-white">
            <h1>Connexion</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="helpEmail">
                    <small id="helpEmail" class="form-text text-muted">
                       <a href="{{route('registration')}}">Vous n'avez pas encore de compte ?</a>
                    </small>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" aria-describedby="helpPassword">
                    <small id="helpPassword" class="form-text text-muted">Vous avez perdu votre mot de passe ?</small>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
        </div>
    </div>
</div>

@endsection
