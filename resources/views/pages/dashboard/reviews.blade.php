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
                    <th class='border-top-0'>Date</th>
                    <th class='border-top-0'>Client</th>
                    <th class='border-top-0'>Produit</th>
                    <th class='border-top-0'>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Review::all() as $review)
                <tr>
                    <td scope="row">{{$review->created_at}}</td>
                    <td>{{$review->user->firstname}} {{$review->user->lastname}}</td>
                    <td>{{$review->product->name}}</td>
                    <td>{{$review->mark}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection