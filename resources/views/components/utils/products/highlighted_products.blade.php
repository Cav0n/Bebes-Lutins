<div id="highlighted-products-container" class="row my-3">
    @foreach ($products as $product)
        @include('components.utils.products.simple_product')
    @endforeach
</div>