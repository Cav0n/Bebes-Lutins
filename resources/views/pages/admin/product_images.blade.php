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
