@extends('templates.default')

@section('optional_og')
<meta property="og:type" content="og:product" />
<meta property="og:title" content="{{ $product->name }}" />
<meta property="og:description" content="{{ $product->description }}" />
<meta property="og:image" content="{{ $product->images()->count() ? $product->images()->first()->url : null }}" />
<meta property="og:url" content="{{ route('product', ['product' => $product]) }}" />
<meta property="og:site_name" content="Bébés Lutins" />
<meta property="product:price:amount" content="{{ $product->price }}" />
<meta property="product:price:currency" content="EUR" />
@endsection

@section('title', $product->name . " - Bébés Lutins")

@section('description', $product->description)

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5 row">
            <p id="product-breadcrumb" class="px-3 pt-3">{!! $product->breadcrumb !!}</p>
            <div id="product-image-container" class="col-12 col-sm-5 col-xxl-4 col-xxxl-3">
                @include('components.utils.carousel.product')
                <div id='ratings' class="mt-3 d-none d-sm-flex flex-column">
                    @if(!empty($errors->any()))
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ ucfirst($error) }}</p>
                        @endforeach
                    </div>
                    @endif
                    @if(session()->has('ratingSuccessMessage'))
                    <div class="alert alert-success" role="alert">
                        <p class="mb-0">{{ session()->get('ratingSuccessMessage') }}</p>
                    </div>
                    @endif
                    <form id='new-rating' class="bg-white p-3 shadow-sm w-100" method="POST" action="{{ route('product.reviews.add', ['product' => $product]) }}">
                        @csrf
                        <h2 class="h4">Apposez un commentaire</h2>

                        <label class="mb-0" for="rating">Note</label>
                        <div class="rating mb-2"></div>
                        <input id="mark" type="hidden" name="mark" value="{{ old('mark', 5) }}">

                        <div class="form-group">
                            <label for="title">Titre du commentaire</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" id="title" aria-describedby="helpTitle" value="{{ old('title') }}">
                            {!! $errors->has('title') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('title')) . "</div>" : '' !!}
                            <small id="helpTitle" class="form-text text-muted">Le titre de votre commentaire</small>
                        </div>
                        <div class="form-group">
                            <label for="text">Votre commentaire</label>
                            <textarea class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}" name="text" id="text" aria-describedby="helpText" rows="5">{{ old('text') }}</textarea>
                            {!! $errors->has('text') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('text')) . "</div>" : '' !!}
                            <small id="helpText" class="form-text text-muted">Le texte de votre commentaire</small>
                        </div>
                        <button type="submit" class="btn btn-outline-dark">Envoyer</button>
                    </form>
                    @foreach($product->reviews as $review)
                    <div class="review bg-white p-3 shadow-sm w-100 mt-2">
                        <p class="mb-0"><b>{{ $review->title }}</b></p>
                        <div class="mark-container d-flex">
                            <span class="fixed-rating" data-mark='{{ $review->mark }}'></span>
                            <p class="mb-0 ml-2">{{ $review->mark }} / 5</p>
                        </div>
                        <p class="mb-0">{{ $review->text }}</p>
                        <small>Posté le {{ $review->created_at->format('d/m/Y') }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-sm-7 col-xxl-8 col-xxxl-9 p-0">
                <div class="bg-white p-3 shadow-sm">
                    <h1 class="mb-0">{{ $product->name }}</h1>
                    @if (count($product->reviews))
                    <div class="mark-container d-flex">
                        <span class="fixed-rating" data-mark='{{ $product->globalMark }}'></span>
                        <p class="mb-0 ml-2">{{ round($product->globalMark, 1) }} / 5</p>
                    </div>
                    @endif
                    <div class="d-flex">
                        <h2 class="h4 mb-0 d-flex flex-column justify-content-center">{{ \App\NumberConvertor::doubleToPrice($product->price) }}</h2>
                        @admin
                        <a class="btn btn-outline-dark py-0 ml-3" href="{{ route('admin.product.edit', ['product' => $product]) }}" role="button">Editer</a>
                        @endadmin
                    </div>
                    <div class="d-flex my-2">
                        <input type="number" class="form-control input-spinner quantity-spinner" name="quantity" id="quantity" aria-describedby="helpQuantity" min="1" max="{{ $product->stock }}" value="1">
                        <button type="button" class="btn btn-primary add-to-cart rounded-0 ml-3" data-id="{{ $product->id }}" data-toggle="modal" data-quantity="1" data-cart_id="{{ session()->get('shopping_cart')->id }}" data-target="#product-added-modal">
                            Ajouter au panier</button>
                    </div>

                    <div class="text-justify mt-3">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    quantitySpinner = $('.quantity-spinner');
    quantitySpinner.on("change", function(event) {
        $('button.add-to-cart').data('quantity', $(this).val());
        $('button.add-to-cart').attr('data-quantity', $(this).val());
    })

    var options = {
        max_value: 5,
        step_size: 0.5,
        initial_value: $('#mark').val(),
        selected_symbol_type: 'utf8_star', // Must be a key from symbols
        cursor: 'default',
        readonly: false
    }

    $(".rating").rate(options);

    $(".rating").on("change", function(ev, data){
        $('#mark').val(data.to);
    });
</script>
@endsection
