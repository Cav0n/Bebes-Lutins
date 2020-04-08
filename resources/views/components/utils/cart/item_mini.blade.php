<div class="cart-product-container bg-white row mx-0 pt-2">
    <div class="col-3 p-0">
        <img src="{{ $item->product->images()->count() ? $item->product->images()->first()->url : null }}" class="w-100" style="object-fit:cover">
    </div>
    <div class="col-9 d-flex flex-column">
        <a class="mb-0 font-weight-bold" href={{ route('product', ['product' => $item->product->id]) }}>{{ $item->product->name }}</a>
        <small class="mb-0">Quantité : {{ $item->quantity }}</small>
        <small class="mb-0">Prix unitaire : {{ \App\NumberConvertor::doubleToPrice($item->product->price) }}</small>
        <small class="mb-0">Prix total : {{ \App\NumberConvertor::doubleToPrice($item->product->price * $item->quantity) }}</small>
    </div>
</div>
