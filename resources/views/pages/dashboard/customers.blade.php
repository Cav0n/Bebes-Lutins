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
        {{$users->links()}}
        <table class="table" style=''>
            <thead>
                <tr class='d-flex'>
                    <th class='border-top-0 col-3'>Nom</th>
                    <th class='border-top-0 col-6'>Email</th>
                    <th class='border-top-0 col-3'>Téléphone</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class='d-flex' onclick='load_url("/dashboard/clients/fiche/{{$user->id}}")'>
                    <td class='col-3'><b>{{$user->firstname}} {{$user->lastname}}</b></td>
                    <td class='col-6'>{{$user->email}}</td>
                    <td class='col-3'>{{$user->phone}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection