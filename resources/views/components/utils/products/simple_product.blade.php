<div class='product-container col-6 col-md-4 col-lg-3 my-2'>
    <div class="product card rounded-0 border-0 shadow-sm">
        <img class="card-img-top rounded-0" src="{{ $product->images()->count() ? $product->images()->first()->url : null }}" alt="{{ $product->images()->count() ? $product->images()->first()->name : null  }}">
        <div class="card-body p-0">
            <p class="card-text mb-0 product-name p-3">
                <a href="{{ route('product', ['product' => $product->id]) }}">
                {{ $product->name }}</a></p>
            <p class="card-text mb-0 product-price border-top py-2 px-3 text-center font-weight-bold">
                {{ App\NumberConvertor::doubleToPrice($product->price) }}</p>
                <button type="button" class="btn btn-primary add-to-cart w-100 rounded-0" data-id="{{ $product->id }}" data-toggle="modal" data-quantity="1" data-cart_id="{{ session()->get('shopping_cart')->id }}" data-target="#product-added-modal">
                    Ajouter au panier</button>
        </div>
    </div>
</div>
