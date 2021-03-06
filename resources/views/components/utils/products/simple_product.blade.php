<div class='product-container col-6 col-md-4 col-lg-3 my-2 {{ $product->stock <= 0 ? 'no-stock' : null }}'>
    <div class="product card rounded-0 border-0 shadow-sm h-100">
        <img class="card-img-top rounded-0" src="{{ $product->images()->count() ? $product->images()->first()->url : null }}" alt="{{ $product->images()->count() ? $product->images()->first()->name : null  }}">
        <div class="card-body p-0 d-flex flex-column justify-content-between">
            <p class="card-text mb-0 product-name p-3">
                <a href="{{ route('product', ['product' => $product->id]) }}">
                {{ $product->name }}</a></p>

            <div class="mb-0 border-top text-center">
                @if($product->globalMark > 0)
                <div class="mb-0 product-mark d-flex justify-content-center">
                    <span class="fixed-rating mr-2" data-mark='{{ $product->globalMark }}'></span>
                    <p class="mb-0 d-none d-sm-flex">{{ round($product->globalMark, 1) }} / 5</p></div>
                @endif
                <p class="text-center mb-0 font-weight-bold">
                    {{ App\NumberConvertor::doubleToPrice($product->price) }} @if ($product->isInPromo)<del class="font-weight-normal">{{ App\NumberConvertor::doubleToPrice($product->priceWithoutPromo) }}</del>@endif </p>
            <button type="button" class="btn btn-primary {{ $product->stock > 0 ? 'add-to-cart' : null }} w-100 rounded-0" data-id="{{ $product->id }}" {!! $product->stock > 0 ? 'data-toggle="modal"' : null !!} data-quantity="1" data-cart_id="{{ session()->get('shopping_cart')->id }}" data-target="#product-added-modal">
                {{ $product->stock > 0 ? 'Ajouter au panier' : 'Rupture de stock' }}</button>
            </div>

        </div>
    </div>
</div>
