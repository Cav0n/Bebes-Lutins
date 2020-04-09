@extends('templates.admin')

@section('optional_js')

@endsection

@section('content')

    @if(session('successMessage'))
    <div class="alert alert-success" role="alert">
        {{ session('successMessage') }}
    </div>
    @endif

    <div class="card rounded-0 border shadow-sm">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h2 class="h4 mb-0 d-flex flex-column justify-content-center">{{ isset($product) ? $product->name : 'Création d\'un produit' }}</h2>
                @if(isset($product)) <a class="btn btn-outline-secondary" href="{{ route('product', ['product' => $product]) }}" role="button">Voir le produit</a> @endif
            </div>

            <ul class="nav nav-tabs border-bottom-0 mt-3">
                <li class="nav-item dropdown d-flex d-sm-none">
                    <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Naviguer</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item @if(url()->current() == route('admin.product.edit', ['product' => $product->id])) active @endif" href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                            Informations de base</a>
                        <a class="dropdown-item @if(url()->current() == route('admin.product.images.edit', ['product' => $product->id])) active @endif" href="{{ route('admin.product.images.edit', ['product' => $product->id]) }}">
                            Images</a>
                    </div>
                </li>

                <li class="nav-item d-none d-sm-flex">
                    <a class="nav-link @if(url()->current() == route('admin.product.edit', ['product' => $product->id])) active @endif" href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                        Informations de base</a>
                </li>
                <li class="nav-item d-none d-sm-flex">
                    <a class="nav-link @if(url()->current() == route('admin.product.images.edit', ['product' => $product->id])) active @endif" href="{{ route('admin.product.images.edit', ['product' => $product->id]) }}">
                    Images</a>
                </li>
            </ul>

        </div>
        <div class="card-body">
            <form action="/file-upload"
                class="dropzone border rounded bg-light p-3 d-flex flex-direction-column justify-content-center"
                id="my-awesome-dropzone"></form>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
