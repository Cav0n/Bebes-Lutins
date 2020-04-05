@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h2 class="h4 mb-0 d-flex flex-column justify-content-center">{{ $cardTitle }}</h2>
        <a class="btn btn-dark" href="{{ route('admin.content.create') }}" role="button">Nouveau</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.contents') }}" class="input-group" method="GET">
            <input class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}" type="text" name="search" placeholder="Rechercher un contenu" value="{{ \Request::get('search') }}">
            <div class="input-group-append">
                <button class="input-group-text" id="my-addon">Rechercher</button>
            </div>
            {!! $errors->has('search') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('search')) . "</div>" : '' !!}
        </form>
        <small id="helpSearch" class="form-text text-muted">Vous pouvez rechercher un titre de contenu</small>

        @if(isset($inSearch))
            <a class="btn btn-dark mt-2" href="{{ route('admin.footer_elements') }}" role="button">Annuler la recherche</a>
        @endif

        @if(!count($footerElements))
            <p class="mb-0 mt-3">Aucun résultat ne correpond.</p>
        @endif

        @if(count($footerElements))
        <table class="table table-striped table-light mt-2 mb-0 border">
            <thead class="thead-light">
                <tr>
                    <th>Titre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($footerElements as $footerElement)
                <tr>
                    <td class="align-middle">{{ $footerElement->title }}</td>
                    <td style="width: 3rem;" class='text-right'>
                        <a class="btn btn-outline-dark" href="{{ route('admin.contents', ['footer_element_id' => $footerElement]) }}" role="button">Afficher</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection
