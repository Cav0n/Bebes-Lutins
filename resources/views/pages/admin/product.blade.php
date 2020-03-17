@php
    $categories = \App\Category::orderBy('name', 'asc')->get();

    $whitelistCategories = '';
    $first = true;
    foreach ($categories as $category) {
        if (!$first) {
            $whitelistCategories .= ",";
        }
        $whitelistCategories .= "'" . $category->name . "'";
        $first = false;
    }

    $productCategories = "";
    $first = true;
    foreach ($product->categories as $category) {
        if (!$first) {
            $productCategories .= ',';
        }
        $productCategories .= $category->name;
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
            <h2 class="h4 mb-0">{{ $product->name }}</h2>
        </div>
        <div class="card-body">
            <a href='{{ route('admin.products') }}' class='text-dark'>< Produits</a>
            <form action="{{ route('admin.product.edit', ['product' => $product]) }}" method="post">
                @csrf

                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="reference">Référence</label>
                        <input type="text" class="form-control" name="reference" id="reference" aria-describedby="helpReference" value='{{ old('reference', $product->reference) }}'>
                        <small id="helpReference" class="form-text text-muted">Vous pouvez indiquer ou non une référence pour le produit</small>
                    </div>
                    <div class="form-group col-lg-9">
                        <label for="name">Titre du produit</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" aria-describedby="helpName" value='{{ old('name', $product->name) }}'>
                        {!! $errors->has('name') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('name')) . "</div>" : '' !!}
                        <small id="helpName" class="form-text text-muted">Vous pouvez écrire un nom explicite</small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="categories">Catégories</label>
                        <input class="form-control {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories" id="categorie" aria-describedby="helpCategories" value='{!! $productCategories !!}'>
                        <small id="helpCategories" class="form-text text-muted"><a href="#" onclick="($('#categories-modal').modal('show'))">Cliquez ici pour voir la liste des catégories</a></small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="price">Prix</label>
                            <input type="number" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" name="price" id="price" value='{{ old('price', $product->price) }}'>
                            {!! $errors->has('price') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('price')) . "</div>" : '' !!}
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="isInPromo" id="isInPromo"> Ce produit est en promotion
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id='promoPriceContainer' class="col-lg-4">
                        <div class="form-group">
                            <label for="promoPrice">Prix en promotion</label>
                            <input type="number" class="form-control {{ $errors->has('promoPrice') ? 'is-invalid' : '' }}" name="promoPrice" id="promoPrice" aria-describedby="helpPromoPrice" value='{{ old('promoPrice', $product->promoPrice) }}'>
                            {!! $errors->has('promoPrice') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('promoPrice')) . "</div>" : '' !!}
                            <small id="helpPromoPrice" class="form-text text-muted">Indiquez le prix du produit en promotion (le prix normal sera barré sur le site)</small>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" name="stock" id="stock" aria-describedby="helpStock" value='{{ old('stock', $product->stock) }}'>
                            {!! $errors->has('stock') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('stock')) . "</div>" : '' !!}
                            <small id="helpStock" class="form-text text-muted">Le stock en quantité du produit</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" aria-describedby="helpDescription" placeholder="">{{ old('description', $product->description) }}</textarea>
                    {!! $errors->has('description') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('description')) . "</div>" : '' !!}

                    <small id="helpDescription" class="form-text text-muted">Soyez le plus explicite possible</small>
                </div>

                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="visible" id="visible" checked> Ce produit est visible sur le site
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
                    @foreach ($categories as $category)
                    <p>{{ $category->name }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- PROMO PRICE --}}
    <script>
        let promoPriceContainer = $('#promoPriceContainer');
        let isInPromoCheckbox = $('#isInPromo');

        promoPriceContainer.hide();

        isInPromoCheckbox.on('click', function(){
            if (this.checked) {
                promoPriceContainer.show();
                return;
            }

            promoPriceContainer.hide();
        })
    </script>

    {{-- TAGIFY (categories selector) --}}
    <script>
        let categories = [ {!! $whitelistCategories !!} ]

        var input = document.querySelector('input[name=categories]'),
        tagify = new Tagify(input, {
            whitelist: categories,
            enforceWhitelist: true
        });
    </script>
@endsection
