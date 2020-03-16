@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Produits</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.products') }}" class="input-group" method="GET">
            <input class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}" type="text" name="search" placeholder="Rechercher un produit" value="{{ old('search') }}">
            <div class="input-group-append">
                <button class="input-group-text" id="my-addon">Rechercher</button>
            </div>
            {!! $errors->has('search') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('search')) . "</div>" : '' !!}
        </form>
        <small id="helpSearch" class="form-text text-muted">Vous pouvez rechercher un nom de produit</small>

        @if(isset($inSearch))
            <a class="btn btn-dark mt-2" href="{{ route('admin.products') }}" role="button">Annuler la recherche</a>
        @endif

        @if(!count($products))
            <p class="mb-0 mt-3">Aucun résultat ne correpond.</p>
        @endif

        @if(count($products))
        <table class="table table-light mt-2 mb-0">
            <thead class="thead-light">
                <tr>
                    <th style="max-width: 1rem;"></th>
                    <th style="width: 2rem;">Référence</th>
                    <th>Nom</th>
                    <th style="max-width: 3rem;">Prix</th>
                    <th style="width: 1.5rem;">Stock</th>
                    <th style="max-width: 3rem;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td style="max-width: 1rem;"><img src='{{ $product->images()->first()->url }}' class="w-100"></td>
                    <td style="width: 2rem;"> #{{ $product->reference }} </td>
                    <td> {{ $product->name }} </td>
                    <td style="max-width: 3rem;"> {{ \App\NumberConvertor::doubleToPrice($product->price) }} </td>
                    <td style="width: 1.5rem;"> {{ $product->stock }} </td>
                    <td style="max-width: 3rem;" class='text-right'>
                        <a class="btn btn-outline-dark" href="{{ route('admin.product.edit', ['product' => $product]) }}" role="button">Éditer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection
