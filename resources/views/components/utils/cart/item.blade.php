<div class="cart-product-container shadow-sm bg-white row my-2 mx-0">
    <div class="col-3 col-md-2 col-lg-3 p-0">
        <img src="{{ $item->product->images()->count() ? $item->product->images()->first()->url : null }}" class="w-100 h-100" style="object-fit:cover">
    </div>
    <div class="col-6 col-sm-7 col-md-8 col-lg-7 col-xxl-7 d-flex flex-column justify-content-between my-2 px-2">
        <div>
            <a class="mb-0 font-weight-bold" href={{ route('product', ['product' => $item->product->id]) }}>{{ $item->product->name }}</a>
            <p class="mb-0">Prix unitaire : {{ \App\NumberConvertor::doubleToPrice($item->product->price) }}</p>
        </div>

        <div class="d-flex flex-wrap">
            <div class='spinner-container ld-over' data-itemId='{{ $item->id }}' data-oldquantity='{{ $item->quantity }}' data-price='{{$item->product->price}}' style="width:fit-content">
                <input
                type="number"
                class="form-control input-spinner cart-item-quantity"
                name="quantity"
                id="quantity"
                aria-describedby="helpQuantity"
                value="{{ $item->quantity }}"
                max="20"
                min="0">
                <div class="ld ld-ring ld-spin"></div>
            </div>
            <a class="d-none d-md-flex flex-column justify-content-center ml-2" href="{{ route('cart.item.delete', ['cartItem'=>$item->id]) }}" role="button" style="width: fit-content">
                <img style="width: 1.4rem;height:1.4rem;" src="{{ asset('images/icons/trash.svg') }}" alt="Supprimer"></a>
        </div>
    </div>
    <div class="col-3 col-sm-2 col-xxl-2 d-flex flex-column justify-content-center border-left my-2 px-1">
        <p class="d-flex flex-column justify-content-center mb-0 text-center item-total-price h-100">{{ \App\NumberConvertor::doubleToPrice($item->product->price * $item->quantity) }}</p>
        <a class="d-flex d-md-none justify-content-center mb-2 w-100" href="{{ route('cart.item.delete', ['cartItem'=>$item->id]) }}" role="button" style="width: fit-content">
            <img style="width: 1.4rem;height:1.4rem;" src="{{ asset('images/icons/trash.svg') }}" alt="Supprimer"></a>
    </div>
</div>
