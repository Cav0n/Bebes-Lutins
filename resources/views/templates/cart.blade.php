@extends('templates.default')

@section('title', "Mon panier - Bébés Lutins")

@section('optional_css')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css"/>
@endsection

@section('content')

<div id="cart" class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">
            @include('components.utils.cart.steps')
            <h1 class="font-weight-bold">@yield('cart.title', 'Mon panier')</h1>
            @if(!empty($errors->any()))
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                <p class="mb-0">{{ ucfirst($error) }}</p>
                @endforeach
            </div>
            @endif
            <div class="row m-0">

                @yield('cart.content')

                {{-- CART RECAP --}}
                @if (0 < $cartStep)
                <div class="col-md-4 pr-0 pl-0 pl-md-2 my-2">

                    <div id="price-recap" class="border bg-white p-3">
                        <p class="mb-0 total-quantity">{{ $cart->totalQuantity }} produits : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice) }}</p>
                        <p class="mb-0 total-shipping-costs">Frais de ports : {{ \App\NumberConvertor::doubleToPrice($cart->shippingCosts) }}</p>
                        <p class="mb-0 total">TOTAL T.T.C. : {{ \App\NumberConvertor::doubleToPrice($cart->totalPrice + $cart->shippingCosts) }}</p>
                        @if (1 == $cartStep)
                            <a class="btn btn-primary w-100 rounded-0 mt-2" href="/panier/livraison" role="button">Valider mon panier</a>
                        @elseif (2 == $cartStep)
                            <button class="btn btn-primary w-100 rounded-0 mt-2" role="submit" form="address-selection">Passer au paiement</button>
                        @endif
                    </div>

                    @if ($cartStep >= 2)
                    <div id='items-recap' class="border bg-white mt-2 p-3">
                        @foreach ($cart->items as $item)
                        @include('components.utils.cart.item_mini')
                        @endforeach
                    </div>
                    @endif

                    @if ($cartStep >= 3)
                    <div id='delivery-recap' class="border bg-white mt-2 p-3">
                        <p class="mb-0"><b>Livré à :</b></p>
                        @include('components.utils.addresses.address', ['address' => $cart->shippingAddress])

                        <p class='mb-0 mt-2'><b>Facturé à :</b></p>
                        @include('components.utils.addresses.address', ['address' => $cart->billingAddress])
                    </div>
                    @endif

                    @if($cart->priceLeftBeforeFreeShipping > 0)
                    <div id="price-recap" class="border mt-2 bg-white p-3">
                        <p class="mb-0">Plus que {{ \App\NumberConvertor::doubleToPrice($cart->priceLeftBeforeFreeShipping) }} pour profiter de
                            la livraison gratuite.</p>
                    </div>
                    @endif

                    <div id="sharing-container" class="border mt-2 bg-white p-3">
                        <p>Vous pouvez partager votre panier avec ce lien : </p>
                        <p class='mb-0 font-weight-bold'>https://bebes-lutins.fr/panier/{{$cart->id}}</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#cheque-infos-container').hide();

        $('#cheque-infos-display-btn').on('click', function(){
            $('#cheque-infos-container').toggle();
        });
    });
</script>
@endsection
