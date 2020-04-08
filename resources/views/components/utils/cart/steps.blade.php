<div class="steps-container d-flex justify-content-center w-100">

    <div class="step {{ $cartStep >= 1 ? 'active' : null }}">
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto">
            @if ($cartStep >= 2)
            <img src="{{ asset('images/icons/success-bw.svg') }}" alt="success">
            @else
            1
            @endif
        </p>
        <p class="text-center">
            Panier</p>
    </div>

    <div>
        <p class="step-separator mb-0 mx-4"> - </p>
    </div>

    <div class="step {{ $cartStep >= 2 ? 'active' : null }}">
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto text-center">
            @if ($cartStep >= 3)
            <img src="{{ asset('images/icons/success-bw.svg') }}" alt="success">
            @else
            2
            @endif
        </p>
        <p class="text-center">
            Livraison</p>
    </div>

    <div>
        <p class="step-separator mb-0 mx-4"> - </p>
    </div>

    <div class="step {{ $cartStep >= 3 ? 'active' : null }}">
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto">
            @if ($cartStep >= 4)
            <img src="{{ asset('images/icons/success-bw.svg') }}" alt="success">
            @else
            3
            @endif
        </p>
        <p class="text-center">
            Paiement</p>
    </div>

</div>
