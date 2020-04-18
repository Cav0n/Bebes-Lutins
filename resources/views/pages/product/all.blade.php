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
                <div class="form-group col-12 col-sm-5 col-md-4 col-lg-3">
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
                <div class="col-12 col-sm-7 col-md-8 col-lg-9 form-group mb-0">
                    <label for="search">Rechercher</label>
                    <input type="text" class="form-control" name="search" id="search" value="{{ Request::get('search') }}">
                    <small>La recherche ce lancera automatiquement en appuyant sur Entrée.</small>
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

            window.location.href = updateQueryString(url, 'sorting', sorting);
        });

        $('#search').change(function(e) {
            let url = window.location.href;
            let search = $(this).val();

            console.log(search);

            window.location.href = updateQueryString(url, 'search', search);
        });

        function updateQueryString(url, key, value) {
            if (!url) url = window.location.href;
            var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
                hash;

            if (re.test(url)) {
                if (typeof value !== 'undefined' && value !== null) {
                    return url.replace(re, '$1' + key + "=" + value + '$2$3');
                }
                else {
                    hash = url.split('#');
                    url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                    if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
                        url += '#' + hash[1];
                    }
                    return url;
                }
            }
            else {
                if (typeof value !== 'undefined' && value !== null) {
                    var separator = url.indexOf('?') !== -1 ? '&' : '?';
                    hash = url.split('#');
                    url = hash[0] + separator + key + '=' + value;
                    if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
                        url += '#' + hash[1];
                    }
                    return url;
                }
                else {
                    return url;
                }
            }
        }
    });
</script>
@endsection
