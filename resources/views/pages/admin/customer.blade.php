@extends('templates.admin')

@section('content')

<div class="row justify-content-between mx-0">
    <a class="btn btn-dark mb-3" href="{{ route('admin.customers') }}" role="button">
        < Clients</a>
</div>

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">{{ $customer->firstname }} {{ $customer->lastname }}</h2>
    </div>
    <form class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="helpName" value='{{ $customer->lastname }}'>
                    <small id="helpName" class="form-text text-muted">Le nom de famille du client</small>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="helpFirstname" value='{{ $customer->firstname }}'>
                    <small id="helpFirstname" class="form-text text-muted">Le prénom du client</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="helpEmail" value='{{ strtolower($customer->email) }}'>
                    <small id="helpEmail" class="form-text text-muted">L'adresse email du client</small>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="phone">Numéro de téléphone</label>
                    <input type="text" class="form-control" name="phone" id="phone" aria-describedby="helpPhone"  value='{{ $customer->phone }}'>
                    <small id="helpPhone" class="form-text text-muted">Le numéro de téléphone du client</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter" {{ $customer->wantNewsletter ? 'checked' : null}}> Le client souhaite recevoir la newsletter ?
                    </label>
                </div>
            </div>
        </div>

        <div class="row m-0 mt-2">
        <button type="submit" class="btn btn-success">Modifier</button>
        <button type="button" class="btn btn-danger ml-3">Regenérer le mot de passe</button>

        </div>
    </form>
</div>

@endsection
