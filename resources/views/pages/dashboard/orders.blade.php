@extends('templates.dashboard')

@section('content')
<div class="card bg-white">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Commandes @if($status != null) {{$status}} @endif
        </h1>
    </div>
    <div class="card-body">
        <form action="/dashboard/produits/recherche" method="POST">
            <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher un produit" aria-describedby="helpSearch">
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-secondary w-100">Rechercher</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12 d-flex flex-row">
                <p class="py-1 px-3 mr-2 bg-light border rounded">En attente de paiement</p>
                <p class="py-1 px-3 mr-2 bg-light border rounded">En cours de préparation</p>
                <p class="py-1 px-3 mr-2 bg-light border rounded">En cours de livraison</p>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th class='border-top-0'>Date</th>
                    <th class='border-top-0'>Client</th>
                    <th class='border-top-0'>Prix</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">02/12/2016<BR>21:00</td>
                    <td>Florian BERNARD</td>
                    <td>13,99 €</td>
                </tr>
                <tr>
                    <td scope="row">13/10/2019<BR>13:54</td>
                    <td>Justine MARTHON</td>
                    <td>25,99 €</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection