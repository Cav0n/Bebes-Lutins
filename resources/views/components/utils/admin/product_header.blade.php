<div class="d-flex justify-content-between">
    <h2 class="h4 mb-0 d-flex flex-column justify-content-center">{{ isset($product) ? $product->name : 'Création d\'un produit' }}</h2>
</div>

@if (isset($product))
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
@endif
