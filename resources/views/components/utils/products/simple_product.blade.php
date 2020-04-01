<div class='product-container col-6 col-md-4 col-lg-3 my-2'>
    <div class="product card rounded-0 border-0 shadow-sm">
        <img class="card-img-top rounded-0" src="{{ $product->images()->count() ? $product->images()->first()->url : null }}" alt="{{ $product->images()->count() ? $product->images()->first()->name : null  }}">
        <div class="card-body p-0">
            <p class="card-text mb-0 product-name p-3">
                <a href="{{ route('product', ['product' => $product->id]) }}">
                {{ $product->name }}</a></p>

            <div class="card-text mb-0 product-price border-top px-3 py-1 text-center">
                @if($product->globalMark > 0)
                <div class="mb-0 product-mark d-flex justify-content-center">
                    <span class="fixed-rating mr-2" data-mark='{{ $product->globalMark }}'></span>
                    <p class="mb-0 d-none d-sm-flex">{{ round($product->globalMark, 1) }} / 5</p></div>
                @endif
                <p class="text-center mb-0 font-weight-bold">
                    {{ App\NumberConvertor::doubleToPrice($product->price) }} @if ($product->isInPromo)<del class="font-weight-normal">{{ App\NumberConvertor::doubleToPrice($product->priceWithoutPromo) }}</del>@endif </p>
            </div>
            <button type="button" class="btn btn-primary add-to-cart w-100 rounded-0" data-id="{{ $product->id }}" data-toggle="modal" data-quantity="1" data-cart_id="{{ session()->get('shopping_cart')->id }}" data-target="#product-added-modal">
                Ajouter au panier</button>
        </div>
    </div>
</div>
