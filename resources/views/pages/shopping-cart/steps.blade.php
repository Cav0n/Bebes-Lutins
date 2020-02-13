<?php $nextStep = 1;?>

<div class="row m-0 mb-4">
    <div class="col-12 d-flex justify-content-center">

        <div class="step shopping-cart @if($step > 0){{'passed'}}@endif" @if($step > 0) onclick='load_url("/panier")' @endif>
            <div class="number rounded-circle bg-white text-center d-flex flex-column justify-content-center" style='height:4rem; width:4rem;'>
                @if($step > 0)<img class='svg' src='{{asset("images/icons/check-circle.svg")}}'>
                @else <p class='mb-0 font-weight-bold'>{{$nextStep}}</p>
                @endif
            </div>
            <div class="text text-center mt-2 text-dark font-weight-bold">Panier</div>
            <?php $nextStep++; ?>
        </div>

        {{-- OPTIONAL CONNECTION STEP --}}
        @if(!Auth::check())
        <div class='mt-4 px-3 text-muted'> - </div>

        <div class="step shopping-cart @if($step > 1){{'passed'}}@endif" @if($step > 1) onclick='load_url("/panier")' @endif>
            <div class="number rounded-circle bg-white text-center d-flex flex-column justify-content-center mx-auto" style='height:4rem; width:4rem;'>
                @if($step > 1)<img class='svg' src='{{asset("images/icons/check-circle.svg")}}'>
                @else <p class='mb-0 @if($step >= 1) font-weight-bold @endif'>{{$nextStep}}</p>
                @endif
            </div>
            <div class="text text-center mt-2 text-dark @if($step >= 1) font-weight-bold @endif">Connexion</div>
        </div>
        <?php $nextStep++; ?>
        @endif
        {{-- ------ --}}

        <div class='mt-4 px-3 text-muted'> - </div>

        <div class="step delivery @if($step > 1){{'passed'}}@endif" @if($step > 1) onclick='load_url("/panier/livraison")' @endif>
            <div class="number rounded-circle bg-white text-center d-flex flex-column justify-content-center" style='height:4rem; width:4rem;'>
                @if($step > 1)<img class='svg' src='{{asset("images/icons/check-circle.svg")}}'>
                @else <p class='mb-0 @if($step >= 1) font-weight-bold @endif'>{{$nextStep}}</p>
                @endif
            </div>
            <div class="text text-center mt-2 text-dark @if($step >= 1) font-weight-bold @endif">Livraison</div>
            <?php $nextStep++; ?>            
        </div>

        <div class='mt-4 px-3 text-muted'> - </div>

        <div class="step payment">
            <div class="number rounded-circle bg-white text-center d-flex flex-column justify-content-center" style='height:4rem; width:4rem;'>
                @if($step > 2)<img class='svg' src='{{asset("images/icons/check-circle.svg")}}'>
                @else <p class='mb-0 @if($step >= 2) font-weight-bold @endif'>{{$nextStep}}</p>
                @endif
            </div>
            <div class="text text-center mt-2 text-dark @if($step >= 2) font-weight-bold @endif">Paiement</div>
            <?php $nextStep++; ?>
        </div>

    </div>
</div>