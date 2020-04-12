@extends('templates.default')

@section('optional_og')
<meta property="og:title" content="Bébés Lutins" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ URL::to('/produits/tous') }}" />
<meta property="og:image" content="{{ asset('images/logo.png') }}" />
@endsection

@section('title', "Bébés Lutins | Couches lavables fabriquées en France")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">

            <p class="mb-0">
                /
                <a href="{{ route('homepage') }}" class='text-muted'> Accueil </a>
                /
                <a href="{{ route('products.all') }}" class='text-muted'> Tous nos produits </a>
            </p>

            <h1 class="h1 font-weight-bolder">
                Tous nos produits
            </h1>

            <div class="row" id="filters-container">
                <div class="form-group col-6 col-md-4 col-lg-3">
                    <label for="sorting">Trier par</label>
                    <select id="sorting" class="custom-select" name="sorting">
                        <option value="1" {{ $sorting == '1' || !isset($sorting) ? 'selected' : null }}>
                            Ordre alphabétique</option>
                        <option value="2" {{ $sorting == '2' ? 'selected' : null }}>
                            Ordre alphabétique inversé</option>
                        <option value="3" {{ $sorting == '3' ? 'selected' : null }}>
                            Du - cher au + cher</option>
                        <option value="4" {{ $sorting == '4' ? 'selected' : null }}>
                            Du + cher au - cher</option>
                    </select>
                </div>
                <div class="col-6 col-md-8 col-lg-9">
                    <div class="form-group">
                        <label for="search">Rechercher</label>
                        <input type="text" class="form-control" name="search" id="search" value="{{ Request::get('search') }}">
                    </div>
                </div>
            </div>

            <div class="row my-3">
                @if (count($products) <= 0)
                <div class="col-12 d-flex justify-content-center">
                    <p class='text-muted mb-0'>Aucun produit ne correspond à votre recherche.</p>
                </div>
                @endif

                @foreach ($products as $product)
                    @include('components.utils.products.simple_product')
                @endforeach
            </div>

            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-center">
                    {{ $products->appends([
                        'search' => \Request::get('search'),
                        'sorting' => \Request::get('sorting')])
                        ->links() }}
                </div>
            </div>

            @include('components.utils.certifications.default')
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#sorting').change(function(e){
            let url = window.location.href;
            let sorting = $(this).val();
            const regex = /sorting=[\d]*/gi;

            console.log(url);

            if (url.indexOf('?') > -1){
                if (url.indexOf('?sorting') > -1) {
                    url = url.replace(regex, 'sorting=' + sorting);
                } else {
                    url += '&sorting=' + sorting;
                }
            }else{
                url += '?sorting=' + sorting;
            }

            window.location.href = url;
        });

        $('#search').change(function(e) {
            let url = window.location.href;
            let search = $(this).val();
            const regex = /search=([a-zA-Z]+(%20)?)*[^&?]/gi;

            console.log(url);

            if (url.indexOf('?') > -1) {
                if (url.indexOf('?search') > -1) {
                    url = url.replace(regex, 'search=' + search);
                } else if (url.indexOf('&search') > -1) {
                    url = url.replace(regex, 'search=' + search);
                } else {
                    url += '&search=' + search;
                }
            } else {
                url += '?search=' + search;
            }

            window.location.href = url;
        });
    });
</script>
@endsection
