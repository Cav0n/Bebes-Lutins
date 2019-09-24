@extends('templates.template')

@section('content')
<main class='container-fluid mt-5 mt-md-0'>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card my-5">
                <div class="card-header">
                    Connexion
                </div>
                <div class="card-body">
                    <form method="POST" action="/espace-client/connexion">
                        @csrf

                        <div class="form-group">
                          <label for="email">Adresse e-mail</label>
                          <input type="email" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpEmail">
                        </div>

                        <div class="form-group">
                          <label for="password">Mot de passe</label>
                          <input type="password" name="password" id="password" class="form-control" placeholder="" aria-describedby="helpPassword">
                          <a href='/espace-client/mot-de-passe-oublie'><small id="helpPassword" class="text-muted">J'ai oublié mon mot de passe</small></a>
                        </div>

                        <button type="submit" class="btn btn-primary">Connexion</button>
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <a href='/espace-client/enregistrement' class="text-muted">Créer mon compte</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection