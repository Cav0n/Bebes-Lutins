@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Avis clients</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.customers') }}" class="input-group" method="GET">
            <input class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}" type="text" name="search" placeholder="Rechercher un avis" value="{{ old('search') }}">
            <div class="input-group-append">
                <button class="input-group-text" id="my-addon">Rechercher</button>
            </div>
            {!! $errors->has('search') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('search')) . "</div>" : '' !!}
        </form>
        <small id="helpSearch" class="form-text text-muted">Vous pouvez rechercher un nom de produit</small>

        @if(isset($inSearch))
            <a class="btn btn-dark mt-2" href="{{ route('admin.customers') }}" role="button">Annuler la recherche</a>
        @endif

        @if(!count($reviews))
            <p class="mb-0 mt-3">Aucun résultat ne correpond.</p>
        @endif

        @if(count($reviews))
        <table class="table table-light mt-2 mb-0 table-striped border">
            <thead class="thead-light">
                <tr>
                    <th>Titre</th>
                    <th>Commentaire</th>
                    <th>Produit</th>
                    <th class='text-right'></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                <tr>
                    <td class='align-middle'>
                        <b>{{ $review->title }}</b><br>
                        <div class="mark-container d-flex">
                            <span class="fixed-rating" data-mark='{{ $review->mark }}' style="color:{{ $review->color ?? 'green' }}"></span>
                            <p class="mb-0 ml-2">{{ $review->mark }} / 5</p>
                        </div>
                    </td>
                    <td class='align-middle'>{{ $review->text }}</td>
                    <td class='align-middle'>{{ $review->product->name }}</td>
                    <td class='text-right align-middle'><a class="btn btn-outline-dark" href="{{ route('admin.customer.edit', ['user' => $review]) }}" role="button">Voir</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container d-flex justify-content-center">
            {{-- TODO: Create custom pagination view --}}
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
