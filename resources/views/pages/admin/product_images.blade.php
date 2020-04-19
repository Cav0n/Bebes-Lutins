@extends('templates.admin')

@section('optional_js')

@endsection

@section('content')

    @if(session('successMessage'))
    <div class="alert alert-success" role="alert">
        {{ session('successMessage') }}
    </div>
    @endif

    <div class="row justify-content-between mx-0">
        <a class="btn btn-dark mb-3" href="{{ route('admin.products') }}" role="button">
            < Produits</a>

        @if(isset($product)) <a class="btn btn-outline-secondary" href="{{ route('product', ['product' => $product]) }}" role="button">Voir le produit</a> @endif
    </div>

    <div class="card rounded-0 border shadow-sm">
        <div class="card-header pb-0">
            @include('components.utils.admin.product_header')
        </div>

        <div class="card-body">
            <form action="{{ route('admin.product.images.add', ['product' => $product]) }}"
                class="dropzone border rounded bg-light p-3 d-flex flex-direction-column justify-content-center"
                id="images-upload" enctype="multipart/form-data" method="POST">
            @csrf
            </form>

            <div class="images-container row">
                @foreach ($product->images as $image)
                    <div class="col-1 mt-3">
                        <img class="w-100" src="{{ asset($image->url) }}" alt="{{ $image->name }}">
                    </div>
                    <div class="col-5 mt-3">
                        <div class="row">
                            <div class="col-3">
                                <input type="number" class="form-control" name="image[{{ $image->id }}]['rank']" id="image[{{ $image->id }}]['rank']" value="{{ $image->pivot->rank }}">
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="image[{{ $image->id }}]['name']" id="image[{{ $image->id }}]['name']" value="{{ $image->name }}">
                            </div>
                        </div>

                        <div class="row mx-0">
                            <a class="btn btn-danger mt-2 py-0 px-2 ml-auto" href="#" role="button">Supprimer</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    dropzone.options.imagesUpload = {
        paramName: "image", // The name that will be used to transfer the file
        accept: function(file, done) {
            done();
        }
    };
</script>
@endsection
