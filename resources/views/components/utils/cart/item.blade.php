<div class="cart-product-container border bg-white row my-2 mx-0">
    <div class="col-3 col-md-2 col-lg-3 p-0">
        <img src='{{asset($item->product->images->first()->url)}}' class="w-100 h-100" style="object-fit:cover">
    </div>
    <div class="col-6 col-sm-7 col-md-8 col-lg-7 col-xxl-9 d-flex flex-column justify-content-between my-2 px-2">
        <div>
            <a class="mb-0 font-weight-bold" href={{ route('product', ['product' => $item->product->id]) }}>{{ $item->product->name }}</a>
            <p class="mb-0">Prix unitaire : {{ \App\NumberConvertor::doubleToPrice($item->product->price) }}</p>
        </div>

        <input type="number" class="form-control input-spinner modal-product-quantity" name="quantity" id="quantity" aria-describedby="helpQuantity" value="{{ $item->quantity }}">

        <a class="btn btn-danger p-0 px-2 mt-2" href="{{ route('cart.item.delete', ['cartItem'=>$item->id]) }}" role="button" style="width: fit-content">
            Supprimer</a>
    </div>
    <div class="col-3 col-sm-2 col-xxl-1 d-flex flex-column justify-content-center border-left my-2 px-1">
        <p class="mb-0 text-center">{{ \App\NumberConvertor::doubleToPrice($item->product->price * $item->quantity) }}</p>
    </div>
</div>
