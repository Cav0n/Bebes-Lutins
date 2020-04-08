@extends('templates.cart')

@section('cart.title', 'Livraison')

@section('cart.content')
<div class="col-md-8 pl-0 pr-0 pr-md-2 my-2">
    <form id="address-selection" action="{{ route("cart.delivery.validation") }}" method="POST">
        @csrf

        <div class="bg-white border p-3">
            <div id="delivery-contact-container" class="row">
                <div class="form-group col-lg-8">
                    <label for="email">Email de contact</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" aria-describedby="helpEmail" @auth value="{{ old('email', Auth::user()->email) }}" @endauth @guest value="{{ old('email') }}" @endguest>
                    {!! $errors->has('email') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('email')) . "</div>" : '' !!}
                    <small id="helpEmail" class="form-text text-muted">Vous pouvez indiquer un email avec lequel nous pourrions vous contacter.</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="phone">Téléphone</label>
                    <input type="text" class="form-control" name="phone" id="phone" aria-describedby="helpPhone" maxlength="10" @auth value="{{ Auth::user()->phone }}" @endauth @guest value="{{ old('phone') }}" @endguest>
                    <small id="helpPhone" class="form-text text-muted">Vous pouvez indiquer un numéro de téléphone avec lequel nous pourrions vous contacter.</small>
                </div>
            </div>
        </div>

        @auth
            @if (0 < Auth::user()->addresses->count())
            {{-- AUTH HAS AT LEAST 1 ADDRESS --}}
                <div id="billing" class="bg-white border p-3 mt-3">
                    <h2>Facturation</h2>
                    <div id="billing-address-select" class="form-group">
                        <label for="billing-address-select">Choisissez une de vos adresses</label>
                        <select class="custom-select" name="billing-address-id" id="billing-address-select">
                            @foreach (Auth::user()->addresses as $address)
                                <option value="{{ $address->id }}"> {{ $address->street }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button id="new-billing-address-btn" type="button" class="btn btn-secondary">
                            Ou créez en une nouvelle</button>
                        <input id="is-new-billing-address" type="hidden" name="is-new-billing-address" value="0">
                    </div>

                    <div id="new-billing-address">
                        @include("components.utils.addresses.creation", ['deliveryPrefix' => 'billing'])
                    </div>

                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="sameAddresses" id="sameAddresses" onclick="$('#shipping').toggle()"
                            @if(old('sameAddresses') || (!old('shipping.civility') && !old('shipping.firstname') && !old('shipping.lastname') && !old('shipping.street') && !old('shipping.zipCode') && !old('shipping.city'))) checked="checked" @endif >
                                Adresse de livraison identique
                        </label>
                    </div>
                </div>


                <div id="shipping" class="bg-white border p-3 mt-3">
                    <h2>Livraison</h2>
                    <div id="shipping-address-select" class="form-group">
                        <label for="shipping-address-select">Choisissez une de vos adresses</label>
                        <select class="custom-select" name="shipping-address-id" id="shipping-address-select">
                            @foreach (Auth::user()->addresses as $address)
                                <option value="{{ $address->id }}"> {{ $address->street }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button id="new-shipping-address-btn" type="button" class="btn btn-secondary">
                            Ou créez en une nouvelle</button>
                        <input id="is-new-shipping-address" type="hidden" name="is-new-shipping-address" value="0">
                    </div>

                    <div id="new-shipping-address">
                        @include("components.utils.addresses.creation", ['deliveryPrefix' => 'shipping'])
                    </div>
                </div>

            @else
            {{-- AUTH HAS NO ADDRESS --}}
                <div id="billing" class="bg-white border p-3 mt-3">
                    <h2>Facturation</h2>
                    <div id="new-billing-address">
                        @include("components.utils.addresses.creation", ['deliveryPrefix' => 'billing'])
                        <input id="is-new-billing-address" type="hidden" name="is-new-billing-address" value="1">
                    </div>

                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="sameAddresses" id="sameAddresses" onclick="$('#new-shipping-address').toggle()"
                            @if(old('sameAddresses') || (!old('shipping.civility') && !old('shipping.firstname') && !old('shipping.lastname') && !old('shipping.street') && !old('shipping.zipCode') && !old('shipping.city'))) checked="checked" @endif >
                                Adresse de livraison identique
                        </label>
                    </div>
                </div>

                <div id="new-shipping-address" class="bg-white border p-3 mt-3">
                    <h2>Livraison</h2>
                    @include("components.utils.addresses.creation", ['deliveryPrefix' => 'shipping'])
                    <input id="is-new-shipping-address" type="hidden" name="is-new-shipping-address" value="1">
                </div>
            @endif
        @endauth

        {{-- GUEST --}}
        @guest
            <div id="billing" class="bg-white border p-3 mt-3">
                <h2>Facturation</h2>
                <div id="new-billing-address">
                    @include("components.utils.addresses.creation", ['deliveryPrefix' => 'billing'])
                    <input id="is-new-billing-address" type="hidden" name="is-new-billing-address" value="1">
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="sameAddresses" id="sameAddresses" onclick="$('#new-shipping-address').toggle()"
                        @if(old('sameAddresses') || (!old('shipping.civility') && !old('shipping.firstname') && !old('shipping.lastname') && !old('shipping.street') && !old('shipping.zipCode') && !old('shipping.city'))) checked="checked" @endif >
                            Adresse de livraison identique
                    </label>
                </div>
            </div>

            <div id="new-shipping-address" class="bg-white border p-3 mt-3">
                <h2>Livraison</h2>
                @include("components.utils.addresses.creation", ['deliveryPrefix' => 'shipping'])
                <input id="is-new-shipping-address" type="hidden" name="is-new-shipping-address" value="1">
            </div>
        @endguest
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#new-shipping-address').show();

        if ($('#sameAddresses').attr('checked')) {
            $('#new-shipping-address').hide();
            $('#shipping').hide();
        } else {
            $('#new-shipping-address').show();
            $('#shipping').show();
        }

        @auth
        @if (0 < Auth::user()->addresses->count())
            $('#new-billing-address').hide();
        @endif
        @endauth

        newBillingAddressBtn = $('#new-billing-address-btn');

        newBillingAddressBtn.on('click', function(){
            $('#billing-address-select').toggle();
            $('#new-billing-address').toggle();

            if ( newBillingAddressBtn.hasClass('activated') ){
                newBillingAddressBtn.text('Ou créez en une nouvelle');
                newBillingAddressBtn.removeClass('activated')
                $('#is-new-billing-address').val('0');
            } else {
                newBillingAddressBtn.text('Selectionner une de vos adresses');
                newBillingAddressBtn.addClass('activated')
                $('#is-new-billing-address').val('1');
            }
        });

        newShippingAddressBtn = $('#new-shipping-address-btn');

        newShippingAddressBtn.on('click', function(){
            $('#shipping-address-select').toggle();
            $('#new-shipping-address').toggle();

            if ( newShippingAddressBtn.hasClass('activated') ){
                newShippingAddressBtn.text('Ou créez en une nouvelle');
                newShippingAddressBtn.removeClass('activated')
                $('#is-new-shipping-address').val('0');
            } else {
                newShippingAddressBtn.text('Selectionner une de vos adresses');
                newShippingAddressBtn.addClass('activated')
                $('#is-new-shipping-address').val('1');
            }
        });
    });
</script>>
@endsection
