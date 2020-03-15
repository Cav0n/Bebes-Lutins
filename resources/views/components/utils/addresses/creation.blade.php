<div class="form-group">

    {{-- //TODO : Add civility setting in dashboard --}}

    <label for="civility">Civilité</label>
    @if (isset($deliveryPrefix))
        <select id="civility" class="form-control {{ $errors->has($deliveryPrefix . '.civility') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[civility]">
            <option>Choisissez une civilité</option>
            <option value='MISS' @if('MISS' == old($deliveryPrefix.'.civility')) selected @endif>
                Madame</option>
            <option value='MISTER' @if('MISTER' == old($deliveryPrefix.'.civility')) selected @endif>
                Monsieur</option>
            <option value='NOT DEFINED' @if('NOT DEFINED' == old($deliveryPrefix.'.civility')) selected @endif>
                Non précisé</option>
        </select>
        {!! $errors->has($deliveryPrefix . '.civility') ? "<div class='invalid-feedback'>" . ucfirst($errors->first($deliveryPrefix . '.civility')) . "</div>" : '' !!}
    @else
        <select id="civility" class="form-control {{ $errors->has('civility') ? 'is-invalid' : '' }}" name="civility">
            <option>Choisissez une civilité</option>
            <option value='MISS' @if('MISS' == old('civility')) selected @endif>
                Madame</option>
            <option value='MISTER' @if('MISTER' == old('civility')) selected @endif>
                Monsieur</option>
            <option value='NOT DEFINED' @if('NOT DEFINED' == old('civility')) selected @endif>
                Non précisé</option>
        </select>
        {!! $errors->has('civility') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('civility')) . "</div>" : '' !!}
    @endif
</div>

<div class="row">
    <div class="form-group col-lg-6">
        <label for="firstname">Prénom</label>
        @if (isset($deliveryPrefix))
            <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.firstname') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[firstname]" id="firstname" aria-describedby="helpFirstname" value="{{ old($deliveryPrefix.'.firstname') }}">
            {!! $errors->has($deliveryPrefix . '.firstname') ? "<div class='invalid-feedback'>" . ucfirst($errors->first($deliveryPrefix . '.firstname')) . "</div>" : '' !!}
        @else
        <input type="text" class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" name="firstname" id="firstname" aria-describedby="helpFirstname" value="{{ old('firstname') }}">
            {!! $errors->has('firstname') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('firstname')) . "</div>" : '' !!}
        @endif
        <small id="helpFirstname" class="form-text text-muted">Votre prénom</small>
    </div>
    <div class="form-group col-lg-6">
        <label for="lastname">Nom de famille</label>
        @if (isset($deliveryPrefix))
            <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.lastname') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[lastname]" id="lastname" aria-describedby="helpLastname" value="{{ old($deliveryPrefix.'.lastname') }}">
            {!! $errors->has($deliveryPrefix . '.lastname') ? "<div class='invalid-feedback'>" . ucfirst($errors->first($deliveryPrefix . '.lastname')) . "</div>" : '' !!}
        @else
            <input type="text" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" name="lastname" id="lastname" aria-describedby="helpLastname"  value="{{ old('lastname') }}">
            {!! $errors->has('lastname') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('lastname')) . "</div>" : '' !!}
        @endif
        <small id="helpLastname" class="form-text text-muted">Votre nom de famille</small>
    </div>
</div>

<div class="form-group">
    <label for="street">Rue</label>
    @if (isset($deliveryPrefix))
        <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.street') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[street]" id="street" aria-describedby="helpStreet" value="{{ old($deliveryPrefix.'.street') }}">
        {!! $errors->has($deliveryPrefix . '.street') ? "<div class='invalid-feedback'>" . ucfirst($errors->first($deliveryPrefix . '.street')) . "</div>" : '' !!}
    @else
        <input type="text" class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" name="street" id="street" aria-describedby="helpStreet"  value="{{ old('street') }}">
        {!! $errors->has('street') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('street')) . "</div>" : '' !!}
    @endif
    <small id="helpStreet" class="form-text text-muted">Le numéro et la rue de votre logement.</small>
</div>

<div class="form-group">
    <label for="complements">Compléments</label>
    @if (isset($deliveryPrefix))
        <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.complements') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[complements]" id="complements" aria-describedby="helpComplements" value="{{ old($deliveryPrefix.'.complements') }}">
        {!! $errors->has($deliveryPrefix . '.complements') ? "<div class='invalid-feedback'>" . ucfirst($errors->first($deliveryPrefix . '.complements')) . "</div>" : '' !!}
    @else
        <input type="text" class="form-control {{ $errors->has('complements') ? 'is-invalid' : '' }}" name="complements" id="complements" aria-describedby="helpComplements"  value="{{ old('complements') }}">
        {!! $errors->has('complements') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('complements')) . "</div>" : '' !!}
    @endif
    <small id="helpComplements" class="form-text text-muted">Compléments d'adresse (numéro d'appartement, résidence...)</small>
</div>

<div class="row">
    <div class="form-group col-lg-4">
        <label for="zipCode">Code postal</label>
        @if (isset($deliveryPrefix))
            <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.zipCode') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[zipCode]" id="zipCode" aria-describedby="helpZipCode" maxlength="5" value="{{ old($deliveryPrefix.'.zipCode') }}">
            {!! $errors->has($deliveryPrefix . '.zipCode') ? "<div class='invalid-feedback'>" . ucfirst($errors->first($deliveryPrefix . '.zipCode')) . "</div>" : '' !!}
        @else
            <input type="text" class="form-control {{ $errors->has('zipCode') ? 'is-invalid' : '' }}" name="zipCode" id="zipCode" aria-describedby="helpZipCode" maxlength="5"  value="{{ old('zipCode') }}">
            {!! $errors->has('zipCode') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('zipCode')) . "</div>" : '' !!}
        @endif
        <small id="helpZipCode" class="form-text text-muted">Le code postal</small>
    </div>
    <div class="form-group col-lg-8">
        <label for="city">Ville</label>
        @if (isset($deliveryPrefix))
            <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.city') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[city]" id="city" aria-describedby="helpCity" value="{{ old($deliveryPrefix.'.city') }}">
            {!! $errors->has($deliveryPrefix . '.city') ? "<div class='invalid-feedback'>" . ucfirst($errors->first($deliveryPrefix . '.city')) . "</div>" : '' !!}
        @else
            <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city" id="city" aria-describedby="helpCity"  value="{{ old('city') }}">
            {!! $errors->has('city') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('city')) . "</div>" : '' !!}
        @endif
        <small id="helpCity" class="form-text text-muted">La ville</small>
    </div>
</div>

<div class="form-group">
    <label for="company">Entreprise</label>
    @if (isset($deliveryPrefix))
        <input type="text" class="form-control {{ $errors->has($deliveryPrefix . '.company') ? 'is-invalid' : '' }}" name="{{ $deliveryPrefix }}[company]" id="company" aria-describedby="helpCompany" value="{{ old($deliveryPrefix.'.company') }}">
        {!! $errors->has($deliveryPrefix . '.company') ? "<div class='invalid-feedback'>" . ucfirst($errors->first($deliveryPrefix . '.company')) . "</div>" : '' !!}
    @else
        <input type="text" class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company" id="company" aria-describedby="helpCompany"  value="{{ old('company') }}">
        {!! $errors->has('company') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('company')) . "</div>" : '' !!}
    @endif
    <small id="helpCompany" class="form-text text-muted">Le nom de l'entreprise à laquelle livrer</small>
</div>

@if (isset($deliveryPrefix))
    <input type='hidden' name="{{ $deliveryPrefix }}[user_id]" value="@auth{{ Auth::user()->id }}@endauth">
@else
    <input type='hidden' name="user_id" value="@auth{{ Auth::user()->id }}@endauth">
@endif

