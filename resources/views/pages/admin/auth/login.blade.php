@extends('templates.admin')

@section('content')

<div class="container-fluid d-flex flex-column justify-content-center" style="min-height:100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card rounded-0">
                <form class="card-body" method="POST" action="{{ route('admin.login') }}">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Connexion</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
