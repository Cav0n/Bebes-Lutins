@if($has_addresses)
<?php $address = Auth::user()->addresses[0]; ?>

{{-- Saved addresses --}}
<div id="savedAddresses" class='delivery-choice savedAddresses @if(session('delivery-type') == 'saved-addresses' || (session('delivery-type') == null) && $has_addresses) @else d-none @endif'>
    <p class='h4'>Vos adresses sauvegardées</p>

    <form id='saved-addresses-form' action="/panier/livraison/validation" method="POST">
        @csrf
        <input type='hidden' name='delivery-type' value='saved-addresses'>
        <div id='saved-billing-address-container'>
            <div id='saved-billing-address' class="form-group">
                <label for="billing-address">Choisissez une adresse de facturation</label>
                <select class="custom-select" name="billing-address" id="billing-address-selector">
                    @foreach (Auth::user()->addresses as $select_address)
                        <option value='{{$select_address->id}}'>{{$select_address->street}}</option>
                    @endforeach
                </select>
            </div>
            <div id='billing-address-summary'>
                <p class='identity mb-0'>{{$address->civilityToString()}} {{$address->firstname}} {{$address->lastname}}</p>
                <small class='complement'>{{$address->complement}}</small>
                <small class='company font-weight-bold'>{{$address->company}}</small>
                <p class='street mb-0'>{{$address->street}}</p>
                <p class='zipcode-city mb-0'>{{$address->zipCode}}, {{$address->city}}</p>
            </div>
        </div>

        <div class="custom-control custom-checkbox max-content mx-auto my-3 pointer">
            <input name='same-shipping-address' type="checkbox" class="custom-control-input pointer same-address-checkbox" id="same-saved-address-checkbox" @if(session('same-shipping-address') == "true"|| session('same-shipping-address') == null) checked @endif>
            <label class="custom-control-label noselect pointer" for="same-saved-address-checkbox">Adresse de livraison identique</label>
        </div>

        <div id='saved-shipping-address-container'>
            <div id='saved-shipping-address' class='form-group'>
                <label for="shipping-address">Choisissez une adresse de livraison</label>
                <select class="custom-select" name="shipping-address" id="shipping-address-selector">
                    @foreach (Auth::user()->addresses as $select_address)
                        <option value='{{$select_address->id}}'>{{$select_address->street}}</option>
                    @endforeach
                </select>
            </div>
            <div id='shipping-address-summary'>
                <p class='identity mb-0'>{{$address->civilityToString()}} {{$address->firstname}} {{$address->lastname}}</p>
                <small class='complement'>{{$address->complement}}</small>
                <small class='company font-weight-bold'>{{$address->company}}</small>
                <p class='street mb-0'>{{$address->street}}</p>
                <p class='zipcode-city mb-0'>{{$address->zipCode}}, {{$address->city}}</p>
            </div>
        </div>
    </form>

</div>
@endif

{{-- New address creation --}}
<div id="newAddress" class='delivery-choice newAddress @if(session('delivery-type') == 'new-address' || (session('delivery-type') == null && !$has_addresses)) @else d-none @endif'>

    <form id='new-address-form' action="/panier/livraison/validation" method="POST">
        @csrf
        <input type='hidden' name='delivery-type' value='new-address'>

        {{-- BILLING ADDRESS --}}
        <div id='billing-address-container'>
            <p class='h4'>Adresse de facturation</p>
            <small>Les champs avec un astérisque (*) sont obligatoires.</small>
            <div class="form-group mb-0 mt-2">
                <label for="civility" class='mb-0'>Civilité *</label>
                <select class="custom-select @error('civility-billing') is-invalid @enderror" name="civility-billing" id="civility">
                    <option value='1'>Monsieur</option>
                    <option value='2'>Madame</option>
                    <option value='3'>Non précisé</option>
                </select>
            </div>
            <div class='row'>
                <div class="form-group mb-0 mt-2 col-6">
                    <label for="firstname" class='mb-0'>Prénom *</label>
                    <input type="text" class="form-control @error('firstname-billing') is-invalid @enderror" name="firstname-billing" id="firstname" aria-describedby="helpFirstname" placeholder="Jean" value='{{old('firstname-billing')}}'>
                </div>
                <div class="form-group mb-0 mt-2 col-6">
                    <label for="lastname" class='mb-0'>Nom de famille *</label>
                    <input type="text" class="form-control @error('lastname-billing') is-invalid @enderror" name="lastname-billing" id="lastname" aria-describedby="helpLastname" placeholder="Dupont" value='{{old('lastname-billing')}}'>
                </div>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="street" class='mb-0'>Rue *</label>
                <input type="text" class="form-control @error('street-billing') is-invalid @enderror" name="street-billing" id="street" aria-describedby="helpStreet" placeholder="" value='{{old('street-billing')}}'>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="zipcode" class='mb-0'>Code postal *</label>
                <input type="text" class="form-control @error('zipcode-billing') is-invalid @enderror" name="zipcode-billing" id="zipcode" aria-describedby="helpZipcode" placeholder="63300" minlength="5" maxlength="5" value='{{old('zipcode-billing')}}'>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="city" class="mb-0">Ville *</label>
                <input type="text" class="form-control @error('city-billing') is-invalid @enderror" name="city-billing" id="city" aria-describedby="helpCity" placeholder="Thiers" value='{{old('city-billing')}}'>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="complements" class="mb-0">Compléments</label>
                <input type="text" class="form-control @error('complements-billing') is-invalid @enderror" name="complements-billing" id="complements" aria-describedby="helpComplements" placeholder="" value='{{old('complements-billing')}}'>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="company" class="mb-0">Entreprise</label>
                <input type="text" class="form-control @error('company-billing') is-invalid @enderror" name="company-billing" id="company" aria-describedby="helpCompany" placeholder="" value='{{old('company-billing')}}'>
            </div>
        </div>

        <div class="custom-control custom-checkbox max-content mx-auto my-3 pointer">
            <input name='same-shipping-address' type="checkbox" class="custom-control-input pointer same-address-checkbox" id="same-address-checkbox" @if(session('same-shipping-address') == "true"|| session('same-shipping-address') == null) checked @endif>
            <label class="custom-control-label noselect pointer" for="same-address-checkbox">Adresse de livraison identique</label>
        </div>

        {{-- SHIPPING ADDRESS --}}
        <div id='shipping-address-container'>
            <p class='h4'>Adresse de livraison</p>
            <small>Les champs avec un astérisque (*) sont obligatoires.</small>
            <div class="form-group mb-0 mt-2">
                <label for="civility" class='mb-0'>Civilité *</label>
                <select class="custom-select @error('civility-shipping') is-invalid @enderror" name="civility-shipping" id="civility">
                    <option value='1'>Monsieur</option>
                    <option value='2'>Madame</option>
                    <option value='3'>Non précisé</option>
                </select>
            </div>
            <div class='row'>
                <div class="form-group mb-0 mt-2 col-6">
                    <label for="firstname" class='mb-0'>Prénom *</label>
                    <input type="text" class="form-control @error('firstname-shipping') is-invalid @enderror" name="firstname-shipping" id="firstname" aria-describedby="helpFirstname" placeholder="Jean" value='{{old('firstname-shipping')}}'>
                </div>
                <div class="form-group mb-0 mt-2 col-6">
                    <label for="lastname" class='mb-0'>Nom de famille *</label>
                    <input type="text" class="form-control @error('lastname-shipping') is-invalid @enderror" name="lastname-shipping" id="lastname" aria-describedby="helpLastname" placeholder="Dupont" value='{{old('lastname-shipping')}}'>
                </div>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="street" class='mb-0'>Rue *</label>
                <input type="text" class="form-control @error('street-shipping') is-invalid @enderror" name="street-shipping" id="street" aria-describedby="helpStreet" placeholder="" value='{{old('street-shipping')}}'>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="zipcode" class='mb-0'>Code postal *</label>
                <input type="text" class="form-control @error('zipcode-shipping') is-invalid @enderror" name="zipcode-shipping" id="zipcode" aria-describedby="helpZipcode" placeholder="63300" minlength="5" maxlength="5" value='{{old('zipcode-shipping')}}'>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="city" class="mb-0">Ville *</label>
                <input type="text" class="form-control @error('city-shipping') is-invalid @enderror" name="city-shipping" id="city" aria-describedby="helpCity" placeholder="Thiers" value='{{old('city-shipping')}}'>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="complements" class="mb-0">Compléments</label>
                <input type="text" class="form-control @error('complements-shipping') is-invalid @enderror" name="complements-shipping" id="complements" aria-describedby="helpComplements" placeholder="" value='{{old('complements-shipping')}}'>
            </div>
            <div class="form-group mb-0 mt-2">
                <label for="company" class="mb-0">Entreprise</label>
                <input type="text" class="form-control @error('company-shipping') is-invalid @enderror" name="company-shipping" id="company" aria-describedby="helpCompany" placeholder="" value='{{old('company-shipping')}}'>
            </div>
        </div>

    </form>

</div>

{{-- Withdrawal shop --}}
<div id="withdrawalShop" class='delivery-choice withdrawalShop @if(session('delivery-type') == 'withdrawal-shop')  @else d-none @endif'>
    <p class='h4'>Retrait à l'atelier</p>
    <small>Les champs avec un astérisque (*) sont obligatoires.</small>
    <p class='small'>
        Une fois votre commande prête, nous vous envoyons un mail (et un SMS si vous 
        indiquez votre numéro de téléphone) pour vous prévenir. Vous pourrez venir retirer 
        votre commande à notre atelier de 9h00 à 12h00 et de 13h30 à 17h00, du lundi au vendredi.
    </p>
    <p class='small'>
        Adresse de l'atelier :<BR>
        ACTYPOLES (Bébés Lutins)<BR>
        Rue du 19 Mars 1962<BR>
        63300 THIERS
    </p>

    <form id='withdrawal-shop-form' action="/panier/livraison/validation" method="POST">
        @csrf
        <input type='hidden' name='delivery-type' value='withdrawal-shop'>
        <div class="form-group mb-0 mt-2">
            <label for="email" class='mb-0'>Adresse email *</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" aria-describedby="helpEmail" placeholder="jeandupont@gmail.com">
            <small id="helpEmail" class="form-text text-muted">Votre adresse email</small>
        </div>
        <div class="form-group mb-0 mt-2">
            <label for="phone" class="mb-0">Numéro de téléphone</label>
            <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" aria-describedby="helpPhone" placeholder="0123456789">
            <small id="helpPhone" class="form-text text-muted">Votre numéro de téléphone</small>
        </div>
        <div class="form-group mb-0 mt-2">
            <label for="civility" class='mb-0'>Civilité *</label>
            <select class="custom-select @error('civility') is-invalid @enderror" name="civility" id="civility">
                <option value='1'>Monsieur</option>
                <option value='2'>Madame</option>
                <option value='3'>Non précisé</option>
            </select>
        </div>
        <div class='row'>
            <div class="form-group mb-0 mt-2 col-6">
                <label for="firstname" class='mb-0'>Prénom *</label>
                <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" id="firstname" aria-describedby="helpFirstname" placeholder="Jean">
            </div>
            <div class="form-group mb-0 mt-2 col-6">
                <label for="lastname" class='mb-0'>Nom de famille *</label>
                <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" id="lastname" aria-describedby="helpLastname" placeholder="Dupont">
            </div>
        </div>
        <p class='h4 mt-4'>Adresse de facturation</p>
        <div class="form-group mb-0 mt-2">
            <label for="street" class='mb-0'>Rue *</label>
            <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" id="street" aria-describedby="helpStreet" placeholder="">
        </div>
        <div class="form-group mb-0 mt-2">
            <label for="zipcode" class='mb-0'>Code postal *</label>
            <input type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" id="zipcode" aria-describedby="helpZipcode" placeholder="63300" minlength="5" maxlength="5">
        </div>
        <div class="form-group mb-0 mt-2">
            <label for="city" class="mb-0">Ville *</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" aria-describedby="helpCity" placeholder="Thiers">
        </div>
        <div class="form-group mb-0 mt-2">
            <label for="complement" class="mb-0">Compléments</label>
            <input type="text" class="form-control @error('complement') is-invalid @enderror" name="complement" id="complement" aria-describedby="helpComplement" placeholder="">
        </div>
        <div class="form-group mb-0 mt-2">
            <label for="company" class="mb-0">Entreprise</label>
            <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" id="company" aria-describedby="helpCompany" placeholder="">
        </div>
    </form>

</div>

{{-- [NEW] - Same shipping address as billing --}}
<script>
    same_address_checkbox = $(".same-address-checkbox");

    if(same_address_checkbox.checked) {
        same_address_checkbox.prop("checked", true());
        $('#shipping-address-container').hide();
        $('#saved-shipping-address-container').hide();
    } else {
        same_address_checkbox.prop("checked", false())
        $('#shipping-address-container').show();
        $('#saved-shipping-address-container').show();
    }

    $('#shipping-address-container').hide();
    $('#saved-shipping-address-container').hide();
    same_address_checkbox.change(function() {
        if(this.checked) {
            same_address_checkbox.prop("checked", true());
            $('#shipping-address-container').hide();
            $('#saved-shipping-address-container').hide();
        } else {
            same_address_checkbox.prop("checked", false())
            $('#shipping-address-container').show();
            $('#saved-shipping-address-container').show();
        }
    });
</script>

@if(Auth::check() && count(Auth::user()->addresses) > 0)
{{-- Choose saved address--}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#billing-address-selector').on('change', function() {
        address_id = this.value;
        billing_address_summary = $('#billing-address-summary');

        $.ajax({
            url: "/addresses/" + address_id,
            type: 'POST',
            data: { },
            success: function(data){
                var json = $.parseJSON(data);
                address = json.address;
                billing_address_summary.children('.identity').text(
                    address.civility + ' ' + address.firstname + ' ' + address.lastname
                );
                billing_address_summary.children('.complement').text(address.complement);
                billing_address_summary.children('.company').text(address.company);
                billing_address_summary.children('.street').text(address.street);
                billing_address_summary.children('.zipcode-city').text(address.zipcode + ' ' + address.city);

            },
            beforeSend: function() {
                //btn.addClass('running');
            }
        })
    });

    $('#shipping-address-selector').on('change', function() {
        address_id = this.value;
        shipping_address_summary = $('#shipping-address-summary');

        $.ajax({
            url: "/addresses/" + address_id,
            type: 'POST',
            data: { },
            success: function(data){
                var json = $.parseJSON(data);
                address = json.address;
                shipping_address_summary.children('.identity').text(
                    address.civility + ' ' + address.firstname + ' ' + address.lastname
                );
                shipping_address_summary.children('.complement').text(address.complement);
                shipping_address_summary.children('.company').text(address.company);
                shipping_address_summary.children('.street').text(address.street);
                shipping_address_summary.children('.zipcode-city').text(address.zipcode + ' ' + address.city);

            },
            beforeSend: function() {
                //btn.addClass('running');
            }
        })
    });
</script>
@endif