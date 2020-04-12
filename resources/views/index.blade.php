@extends('templates.default')

@section('optional_og')
<meta property="og:title" content="Bébés Lutins" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ URL::to('/') }}" />
<meta property="og:image" content="{{ asset('images/logo.png') }}" />
@endsection

@section('title', "Bébés Lutins | Couches lavables fabriquées en France")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">

            @include('components.utils.carousel.main')

            <h1 class="h1 font-weight-bolder">
                {{ $homepageTitle }}
            </h1>
            <p class="h5 text-justify">
                {{ $homepageDescription }}
            </p>

            @include('components.utils.products.highlighted_products')

            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-center">
                    <a class="btn btn-primary" href="{{ route('products.all') }}" role="button">Voir tous nos produits</a>
                </div>
            </div>

            @include('components.utils.certifications.default')
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.carousel').carousel();
    });
</script>
@endsection
