@extends('templates.admin_login')

@section('content')

<div class="container-fluid d-flex flex-column justify-content-center" style="min-height:100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-4">
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
                    <button type="submit" class="btn btn-primary">Connexion</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
