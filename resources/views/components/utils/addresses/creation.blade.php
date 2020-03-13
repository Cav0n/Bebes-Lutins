<div class="form-group">
    <label for="civility">Civilité</label>
    @if (isset($deliveryPrefix))
        <select id="civility" class="form-control {{ $errors->has($deliveryPrefix . '.civility') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[civility]">
    @else
        <select id="civility" class="form-control {{ $errors->has('civility') ? 'is-invalid' : '' }}" name="civility">
    @endif
        <option>Choisissez une civilité</option>
        <option>Madame</option>
        <option>Monsieur</option>
        <option>Non précisé</option>
    </select>
</div>

<div class="row">
    <div class="form-group col-lg-6">
        <label for="firstname">Prénom</label>
        @if (isset($deliveryPrefix))
            <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.firstname') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[firstname]" id="firstname" aria-describedby="helpFirstname">
        @else
            <input type="text" class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" name="firstname" id="firstname" aria-describedby="helpFirstname">
        @endif
        <small id="helpFirstname" class="form-text text-muted">Votre prénom</small>
    </div>
    <div class="form-group col-lg-6">
        <label for="lastname">Nom de famille</label>
        @if (isset($deliveryPrefix))
            <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.lastname') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[lastname]" id="lastname" aria-describedby="helpLastname">
        @else
            <input type="text" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" name="lastname" id="lastname" aria-describedby="helpLastname">
        @endif
        <small id="helpLastname" class="form-text text-muted">Votre nom de famille</small>
    </div>
</div>

<div class="form-group">
    <label for="street">Rue</label>
    @if (isset($deliveryPrefix))
        <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.street') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[street]" id="street" aria-describedby="helpStreet">
    @else
        <input type="text" class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" name="street" id="street" aria-describedby="helpStreet">
    @endif
    <small id="helpStreet" class="form-text text-muted">Le numéro et la rue de votre logement.</small>
</div>

<div class="form-group">
    <label for="complements">Compléments</label>
    @if (isset($deliveryPrefix))
        <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.complements') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[complements]" id="complements" aria-describedby="helpComplements">
    @else
        <input type="text" class="form-control {{ $errors->has('complements') ? 'is-invalid' : '' }}" name="complements" id="complements" aria-describedby="helpComplements">
    @endif
    <small id="helpComplements" class="form-text text-muted">Compléments d'adresse (numéro d'appartement, résidence...)</small>
</div>

<div class="row">
    <div class="form-group col-lg-4">
        <label for="zipCode">Code postal</label>
        @if (isset($deliveryPrefix))
            <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.zipCode') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[zipCode]" id="zipCode" aria-describedby="helpZipCode" maxlength="5">
        @else
            <input type="text" class="form-control {{ $errors->has('zipCode') ? 'is-invalid' : '' }}" name="zipCode" id="zipCode" aria-describedby="helpZipCode" maxlength="5">
        @endif
        <small id="helpZipCode" class="form-text text-muted">Le code postal</small>
    </div>
    <div class="form-group col-lg-8">
        <label for="city">Ville</label>
        @if (isset($deliveryPrefix))
            <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.city') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[city]" id="city" aria-describedby="helpCity">
        @else
            <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city" id="city" aria-describedby="helpCity">
        @endif
        <small id="helpCity" class="form-text text-muted">La ville</small>
    </div>
</div>

<div class="form-group">
    <label for="company">Entreprise</label>
    @if (isset($deliveryPrefix))
        <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.company') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[company]" id="company" aria-describedby="helpCompany">
    @else
        <input type="text" class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company" id="company" aria-describedby="helpCompany">
    @endif
    <small id="helpCompany" class="form-text text-muted">Le nom de l'entreprise à laquelle livrer</small>
</div>

@if (isset($deliveryPrefix))
    <input type='hidden' name="{{ $deliveryPrefix }}[user_id]" value="@auth{{ Auth::user()->id }}@endauth">
@else
    <input type='hidden' name="user_id" value="@auth{{ Auth::user()->id }}@endauth">
@endif

