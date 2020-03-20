@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Catégories</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.categories') }}" class="input-group" method="GET">
            <input class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}" type="text" name="search" placeholder="Rechercher un produit" value="{{ old('search') }}">
            <div class="input-group-append">
                <button class="input-group-text" id="my-addon">Rechercher</button>
            </div>
            {!! $errors->has('search') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('search')) . "</div>" : '' !!}
        </form>
        <small id="helpSearch" class="form-text text-muted">Vous pouvez rechercher un nom de catégorie</small>

        @if(isset($inSearch))
            <a class="btn btn-dark mt-2" href="{{ route('admin.categories') }}" role="button">Annuler la recherche</a>
        @endif

        @if(!count($categories))
            <p class="mb-0 mt-3">Aucun résultat ne correpond.</p>
        @endif

        @if(count($categories))
        <table class="table table-light mt-2 mb-0 table-striped">
            <thead class="thead-light">
                <tr>
                    <th class='text-center' style='width:2rem;'>Position</th>
                    <th>Nom</th>
                    <th class='text-right' style='width:4rem;'></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr @if($category->isHidden) style="opacity:0.5" @endif>
                    <td class='text-center align-middle' style='width:2rem;'> {{ $category->rank }} </td>
                    <td class='align-middle'> {{ $category->name }} @if($category->isHidden) <span class="badge badge-pill badge-dark">Caché</span> @endif </td>
                    <td class='text-right align-middle' style='width:4rem;'>
                        <a class="btn btn-outline-dark" href="{{ route('admin.category.edit', ['category' => $category]) }}">Voir</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container d-flex justify-content-center">
            {{-- TODO: Create custom pagination view --}}
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
