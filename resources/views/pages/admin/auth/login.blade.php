@extends('templates.admin_login')

@section('content')

<div class="container-fluid d-flex flex-column justify-content-center" style="min-height:100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="logo-container d-flex justify-content-center">
                <img id="auth-logo" class="svg w-50 h-100" src="{{ asset('images/logo-mini.svg') }}" alt="Logo Bébés lutins">
            </div>
            @if(!empty($errors->any()))
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                <p class="mb-0">{{ ucfirst($error) }}</p>
                @endforeach
            </div>
            @endif
            <div class="card rounded-0 shadow-sm border">
                <form class="card-body" method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a class="mb-0 mt-auto" href="{{ route('homepage') }}">Retour à la boutique</a>
                        <button type="submit" class="btn btn-primary">Connexion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
