<div class="row m-0 mb-4">
    <div class="col-12 d-flex justify-content-center">
        <div class="step">
            <div class="number rounded-circle bg-white text-center d-flex flex-column justify-content-center" style='height:4rem; width:4rem;'>
                @if($step > 0)<img class='svg' src='{{asset("images/icons/check-circle.svg")}}'>
                @else <p class='mb-0 font-weight-bold'>1</p>
                @endif
            </div>
            <div class="text text-center mt-2 text-dark font-weight-bold">Panier</div>
        </div>
        <div class='mt-4 px-3 text-muted'> - </div>
        <div class="step">
            <div class="number rounded-circle bg-white text-center d-flex flex-column justify-content-center" style='height:4rem; width:4rem;'>
                @if($step > 1)<img class='svg' src='{{asset("images/icons/check-circle.svg")}}'>
                @else <p class='mb-0 @if($step >= 1) font-weight-bold @endif'>2</p>
                @endif
            </div>
            <div class="text text-center mt-2 text-dark @if($step >= 1) font-weight-bold @endif">Livraison</div>
        </div>
        <div class='mt-4 px-3 text-muted'> - </div>
        <div class="step">
            <div class="number rounded-circle bg-white text-center d-flex flex-column justify-content-center" style='height:4rem; width:4rem;'>
                @if($step > 2)<img class='svg' src='{{asset("images/icons/check-circle.svg")}}'>
                @else <p class='mb-0 @if($step >= 2) font-weight-bold @endif'>3</p>
                @endif
            </div>
            <div class="text text-center mt-2 text-dark @if($step >= 2) font-weight-bold @endif">Paiement</div>
        </div>
    </div>
</div>