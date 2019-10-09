@extends('templates.template')

@section('content')
<main class='container-fluid mt-md-0 dim-background'>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card my-5 border-0 rounded-0">
                <div class="card-header bg-white">
                    Connexion
                </div>
                <div class="card-body">
                    <form method="POST" action="/espace-client/connexion">
                        @csrf

                        <div class="form-group">
                          <label for="email">Adresse e-mail</label>
                          <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="" aria-describedby="helpEmail" value='{{old('email', '')}}'>
                          @error('email')
                            <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label for="password">Mot de passe</label>
                          <input type="password" name="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="" aria-describedby="helpPassword">
                          @error('password')
                            <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                          <a href='/espace-client/mot-de-passe-oublie'><small id="helpPassword" class="text-muted">J'ai oublié mon mot de passe</small></a>
                        </div>

                        <button type="submit" class="btn btn-primary">Connexion</button>
                    </form>
                </div>
                <div class="card-footer bg-white text-muted">
                    <a href='/espace-client/enregistrement' class="text-muted">Créer mon compte</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection