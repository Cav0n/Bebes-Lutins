<div class="steps-container row justify-content-center w-100">

    <div class="step {{ $cartStep >= 1 ? 'active' : null }}">
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto">
            1</p>
        <p class="text-center">
            Panier</p>
    </div>

    <div>
        <p class="step-separator mb-0 mx-2"> - </p>
    </div>

    <div class="step {{ $cartStep >= 2 ? 'active' : null }}">
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto text-center">
            2</p>
        <p class="text-center">
            Livraison</p>
    </div>

    <div>
        <p class="step-separator mb-0 mx-2"> - </p>
    </div>

    <div class="step {{ $cartStep >= 3 ? 'active' : null }}">
        <p class="step-number text-center bg-white rounded-circle d-flex flex-column justify-content-center mb-0 mx-auto">
            3</p>
        <p class="text-center">
            Paiement</p>
    </div>

</div>
