@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Clients - Avis
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
                    <th class='border-top-0 text-center'>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Review::all() as $review)
                <tr onclick='load_url("/dashboard/clients/avis/{{$review->id}}")'>
                    <td scope="row" class='small'>{{$review->created_at->formatLocalized('%e %B %Y')}}<BR>à {{$review->created_at->formatLocalized('%R')}}</td>
                    <td>{{$review->customerPublicName}}</td>
                    <td class='small'>{{$review->product->name}}</td>
                    <td class='text-center'>{{$review->mark}} / 5</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection