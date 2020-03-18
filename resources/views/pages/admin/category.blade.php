@php
    $allCategories = \App\Category::orderBy('name', 'asc')->get();

    $whitelistCategories = '';
    $first = true;
    foreach ($allCategories as $otherCategory) {
        if ($otherCategory->name === $category->name) {
            continue;
        }

        if (!$first) {
            $whitelistCategories .= ",";
        }

        $whitelistCategories .= "'" . $otherCategory->name . "'";
        $first = false;
    }
@endphp

@extends('templates.admin')

@section('content')

    @if(session('successMessage'))
    <div class="alert alert-success" role="alert">
        {{ session('successMessage') }}
    </div>
    @endif

    <div class="card rounded-0 border shadow-sm">
        <div class="card-header">
            <h2 class="h4 mb-0">{{ $category->name }}</h2>
        </div>
        <div class="card-body">
            <a href='{{ route('admin.categories') }}' class='text-dark'>< Catégories</a>
            <form action="{{ route('admin.category.edit', ['category' => $category]) }}" method="post">
                @csrf

                <div class="row">
                    <div class="form-group col-lg-2">
                            <label for="rank">Position</label>
                            <input type="number" class="form-control {{ $errors->has('rank') ? 'is-invalid' : '' }}" name="rank" id="rank" aria-describedby="helpRank" value='{{ old('rank', $category->rank) }}'>
                            {!! $errors->has('rank') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('rank')) . "</div>" : '' !!}
                            <small id="helpRank" class="form-text text-muted">Le rang de la catégorie</small>
                    </div>
                    <div class="form-group col-lg-10">
                        <label for="name">Titre de la catégorie</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" aria-describedby="helpName" value='{{ old('name', $category->name) }}'>
                        {!! $errors->has('name') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('name')) . "</div>" : '' !!}
                        <small id="helpName" class="form-text text-muted">Vous pouvez écrire un nom explicite</small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="parent">Catégorie parente</label>
                        <input class="form-control selectMode {{ $errors->has('parent') ? 'is-invalid' : '' }}" name="parent" id="parent" aria-describedby="helpParent" @if($category->parent) value='{!! $category->parent->name !!}' @endif>
                        {!! $errors->has('parent') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('parent')) . "</div>" : '' !!}
                        <small id="helpParent" class="form-text text-muted"><a href="#" onclick="($('#categories-modal').modal('show'))">Cliquez ici pour voir la liste des catégories</a></small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" aria-describedby="helpDescription" placeholder="">{{ old('description', $category->description) }}</textarea>
                    {!! $errors->has('description') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('description')) . "</div>" : '' !!}
                    <small id="helpDescription" class="form-text text-muted">Soyez le plus explicite possible</small>
                </div>

                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="visible" id="visible" @if(!$category->isHidden) checked @endif> Cette catégorie est visible sur le site
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>

    <div id="categories-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Catégories</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($allCategories as $otherCategory)
                    <p>{{ $otherCategory->name }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- TAGIFY (categories selector) --}}
    <script>
        let categories = [ {!! $whitelistCategories !!} ]

        var input = document.querySelector('input[name=parent]'),
        tagify = new Tagify(input, {
            mode : "select",
            whitelist: categories,
            enforceWhitelist: true,
            dropdown: {
            // closeOnSelect: false
            }
        });

        tagify.on('add', onAddTag);
        tagify.DOM.input.addEventListener('focus', onSelectFocus);

        function onAddTag(e){
            console.log(e.detail)
        }

        function onSelectFocus(e){
            console.log(e)
        }
    </script>
@endsection
