@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h2 class="h4 mb-0 d-flex flex-column justify-content-center">{{ $cardTitle }}</h2>
        <a class="btn btn-dark" href="{{ route('admin.promoCode.create') }}" role="button">Nouveau</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.promoCodes') }}" class="input-group" method="GET">
            <input class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}" type="text" name="search" placeholder="Rechercher un code promo" value="{{ \Request::get('search') }}">
            <div class="input-group-append">
                <button class="input-group-text" id="my-addon">Rechercher</button>
            </div>
            {!! $errors->has('search') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('search')) . "</div>" : '' !!}
        </form>
        <small id="helpSearch" class="form-text text-muted">Vous pouvez rechercher un code promo</small>

        @if(isset($inSearch))
            <a class="btn btn-dark mt-2" href="{{ route('admin.promoCodes') }}" role="button">Annuler la recherche</a>
        @endif

        @if(!count($promoCodes))
            <p class="mb-0 mt-3">Aucun résultat ne correpond.</p>
        @endif

        @if(count($promoCodes))
        <table class="table table-light mt-2 mb-0 table-striped border">
            <thead class="thead-light">
                <tr>
                    <th>Code</th>
                    <th>Date</th>
                    <th>Remise</th>
                    <th>Panier mini</th>
                    <th>Utilisation max</th>
                    <th style="width: 3rem;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promoCodes as $promoCode)
                <tr @if(! $promoCode->isActive) style="opacity:0.5" @endif>
                    <th>{{ $promoCode->code }} {!! $promoCode->statusTag !!}</th>

                    <td>
                        Du {{ $promoCode->minValidDate->format('d/m/Y à H:i') }} <br>
                        Au {{ $promoCode->maxValidDate->format('d/m/Y à H:i') }}
                    </td>
                    <td>{{ $promoCode->discountValue }} {{ $promoCode->discountTypeMin }}</td>
                    <td>{{ $promoCode->minCartPriceFormatted }}</td>
                    <td>{{ $promoCode->maxUsage }}</td>
                    <td style="width: 3rem;" class='text-right align-middle'>
                        <a class="btn btn-outline-dark" href="{{ route('admin.promoCode.edit', ['promoCode' => $promoCode]) }}" role="button">Éditer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container d-flex justify-content-center">
            {{-- TODO: Create custom pagination view --}}
            {{ $promoCodes->appends(['search' => \Request::get('search')])->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
