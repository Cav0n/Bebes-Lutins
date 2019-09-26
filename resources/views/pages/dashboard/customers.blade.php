@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Clients
        </h1>
    </div>
    <div class="card-body">
        <form action="/dashboard/produits/recherche" method="POST">
            <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher un client" aria-describedby="helpSearch">
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-secondary w-100 border-light">Rechercher</button>
                </div>
            </div>
        </form>
        <table class="table" style='table-layout:fixed'>
            <thead>
                <tr>
                    <th class='border-top-0'>Inscription</th>
                    <th class='border-top-0'>Nom</th>
                    <th class='border-top-0'>Email</th>
                    <th class='border-top-0'>Téléphone</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\User::all() as $user)
                <tr>
                    <td scope="row">{{$user->created_at}}</td>
                    <td>{{$user->firstname}} {{$user->lastname}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection