@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
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
                        <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher une commande" aria-describedby="helpSearch">
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-secondary w-100 border-light">Rechercher</button>
                </div>
            </div>
        </form>
        @switch($status)
            @case('en cours')
                @include('pages.dashboard.orders.being-processed')
                @break
            @case('terminées')
                @include('pages.dashboard.orders.ended')
                @break
            @case('refusées')
                @include('pages.dashboard.orders.refused')
                @break
        @endswitch
    </div>
</div>
@endsection