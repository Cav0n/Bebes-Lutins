@extends('templates.admin')

@section('content')

{!! isset($parent) ? "<p>".$parent->adminBreadcrumb."</p>" : null !!}

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">{{ isset($parent) ? $parent->name : 'Catégories' }}</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.search.categories') }}" class="input-group" method="GET">
            <input class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}" type="text" name="search" placeholder="Rechercher un produit" value="{{ \Request::get('search') }}">
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
        <table class="table table-light mt-2 mb-0 table-striped border">
            <thead class="thead-light">
                <tr>
                    <th class='text-center' style='width:2rem;'>Position</th>
                    <th>Nom</th>
                    <th class='text-right'></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr @if($category->isHidden) style="opacity:0.5" @endif>
                    <td class='text-center align-middle' style='width:2rem;'>
                        <input type="number" class="form-control category-rank" name="rank" placeholder="0"
                            id="rank-{{ $category->id }}" value="{{ $category->rank }}" data-category-id="{{ $category->id }}">
                    </td>
                    <td class='align-middle'> {{ $category->name }} @if($category->isHidden) <span class="badge badge-pill badge-dark">Caché</span> @endif </td>
                    <td class='text-right align-middle'>
                        <a class="btn btn-outline-dark mt-2 mt-md-0" href="{{ route('admin.category.edit', ['category' => $category]) }}">Éditer</a>

                        @if (count($category->childs) > 0)
                        <a class="btn btn-outline-dark mt-2 mt-md-0" href="{{ route('admin.categories', ['parent' => $category->id]) }}">Parcourir</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container d-flex justify-content-center">
            {{-- TODO: Create custom pagination view --}}
            {{ $categories->appends(['search' => \Request::get('search')])->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
    <script>
        $('.category-rank').on('change', function() {
            updateCategoryRank($(this).data('category-id'), $(this).val(), $(this));
        })

        function updateCategoryRank(categoryId, rank, input) {
            fetch("/api/category/" + categoryId + "/rank/update", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    rank: rank
                })
            })
            .then(response => response.json())
            .then(response => {
                if (undefined !== response.errors){
                    throw response.errors;
                }

                location.reload();
            }).catch((errors) => {
                input.addClass('is-invalid');
                errors.status.forEach(message => {
                    input.after(errorFeedbackHtml.replace('__error__', message));
                });
            });
        }
    </script>
@endsection
