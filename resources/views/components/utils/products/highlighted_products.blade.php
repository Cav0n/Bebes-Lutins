<div id="highlighted-products-container" class="row my-3">
    @foreach ($products->where('isHighlighted', 1)->get() as $product)
        @if (!$product->isHidden)
            @include('components.utils.products.simple_product')
        @endif
    @endforeach
</div>
