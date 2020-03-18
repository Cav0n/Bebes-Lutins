<div id="highlighted-products-container" class="row my-3">
    @foreach ($products as $product)
        @if (!$product->isHidden)
            @include('components.utils.products.simple_product')
        @endif
    @endforeach
</div>
