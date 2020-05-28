<div class="steps-container d-flex justify-content-center w-100">

    <a class="step {{ $cartStep >= 1 ? 'active' : null }}" @if($cartStep > 1) href="{{ route('cart') }}" @endif>
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto">
            @if ($cartStep >= 2)
            <img src="{{ asset('images/icons/success-bw.svg') }}" alt="success">
            @else
            1
            @endif
        </p>
        <p class="text-center text-dark">
            Panier</p>
    </a>

    <div>
        <p class="step-separator mb-0 mx-4"> - </p>
    </div>

    <a class="step {{ $cartStep >= 2 ? 'active' : null }}" @if($cartStep > 2) href="{{ route('cart.delivery') }}" @endif>
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto text-center">
            @if ($cartStep >= 3)
            <img src="{{ asset('images/icons/success-bw.svg') }}" alt="success">
            @else
            2
            @endif
        </p>
        <p class="text-center text-dark">
            Livraison</p>
    </a>

    <div>
        <p class="step-separator mb-0 mx-4"> - </p>
    </div>

    <a class="step {{ $cartStep >= 3 ? 'active' : null }}" @if($cartStep > 3) href="{{ route('cart.payment') }}" @endif>
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto">
            @if ($cartStep >= 4)
            <img src="{{ asset('images/icons/success-bw.svg') }}" alt="success">
            @else
            3
            @endif
        </p>
        <p class="text-center text-dark">
            Paiement</p>
    </a>

</div>
