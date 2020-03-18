@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Clients</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.customers') }}" class="input-group" method="GET">
            <input class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}" type="text" name="search" placeholder="Rechercher un client" value="{{ old('search') }}">
            <div class="input-group-append">
                <button class="input-group-text" id="my-addon">Rechercher</button>
            </div>
            {!! $errors->has('search') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('search')) . "</div>" : '' !!}
        </form>
        <small id="helpSearch" class="form-text text-muted">Vous pouvez rechercher un prénom, un nom de famille, une adresse mail ou un numéro de téléphone</small>

        @if(isset($inSearch))
            <a class="btn btn-dark mt-2" href="{{ route('admin.customers') }}" role="button">Annuler la recherche</a>
        @endif

        @if(!count($customers))
            <p class="mb-0 mt-3">Aucun résultat ne correpond.</p>
        @endif

        @if(count($customers))
        <table class="table table-light mt-2 mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Identité</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th class='text-right'></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->firstname }} {{ $customer->lastname  }}</td>
                    <td>{{ $customer->email}}</td>
                    <td>{{ $customer->phone}}</td>
                    <td class='text-right'><a class="btn btn-outline-dark" href="{{ route('admin.customer.edit', ['user' => $customer]) }}" role="button">Voir</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection