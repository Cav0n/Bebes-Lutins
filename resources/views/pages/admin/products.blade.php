@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h2 class="h4 mb-0 d-flex flex-column justify-content-center">{{ $cardTitle }}</h2>
        <a class="btn btn-dark" href="{{ route('admin.product.create') }}" role="button">Nouveau</a>
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
        <table class="table table-light mt-2 mb-0 table-striped">
            <thead class="thead-light">
                <tr>
                    <th class="d-none d-lg-table-cell" style="width: 1rem;"></th>
                    <th style="width: 2rem;">Référence</th>
                    <th>Nom</th>
                    <th class="d-none d-md-table-cell text-right" style="width: 5rem;">Prix</th>
                    <th class="d-none d-md-table-cell text-center" style="width: 1.5rem;">Stock</th>
                    <th style="width: 3rem;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr @if($product->isHidden) style="opacity:0.5" @endif>
                    <td class="d-none d-lg-table-cell px-0" style="width: 3rem;"><img src='{{ $product->images()->count() ? $product->images()->first()->url : null }}' class="w-100"></td>
                    <td class="align-middle" style="width: 2rem;"> {{ $product->reference ? '#' . $product->reference : null }} </td>
                    <td class="align-middle">
                        {{ $product->name }}
                        @if($product->isHidden) <span class="badge badge-pill badge-dark">Caché</span> @endif
                        @if($product->isHighlighted) <span class="badge badge-pill badge-secondary">Mis en avant</span> @endif
                        @if(0 >= $product->stock) <span class="badge badge-pill badge-warning">PLUS DE STOCK</span> @endif
                    </td>
                    <td class="d-none d-md-table-cell px-0 text-right align-middle" style="width: 5rem;"> {{ \App\NumberConvertor::doubleToPrice($product->price) }} </td>
                    <td class="d-none d-md-table-cell text-center align-middle" style="width: 1.5rem;"> {{ $product->stock }} </td>
                    <td style="width: 3rem;" class='text-right align-middle'>
                        <a class="btn btn-outline-dark" href="{{ route('admin.product.edit', ['product' => $product]) }}" role="button">Éditer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container d-flex justify-content-center">
            {{-- TODO: Create custom pagination view --}}
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
