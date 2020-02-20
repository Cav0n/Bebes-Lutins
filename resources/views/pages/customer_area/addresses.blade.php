@extends('templates.default')

@section('title', "Mes adresses | Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 card p-0">

            @include('components.customer_area.title')

            <div class="body p-3">
                <div class="row py-3">
                    <div class="col-lg-12">
                        <h3 class="h4 font-weight-bold">Mes adresses</h3>
                        <button type="button" class="btn btn-outline-primary" id="add-address-btn">Ajouter une adresse</button>

                        <form action="{{ route('user.addresses.create') }}" method="POST" id="address-creation-form">
                            @csrf
                            <div class="form-group">
                                <label for="civility">Civilité du destinataire</label>
                                <select class="custom-select" name="civility" id="civility">
                                    <option>Madame</option>
                                    <option>Monsieur</option>
                                    <option>Non précisé</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="helpFirstname">
                                <small id="helpFirstname" class="form-text text-muted">Prénom du destinataire</small>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Nom de famille</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="helpLastname">
                                <small id="helpLastname" class="form-text text-muted">Nom de famille du destinataire</small>
                            </div>
                            <div class="form-group">
                                <label for="street">Rue</label>
                                <input type="text" class="form-control" name="street" id="street" aria-describedby="helpStreet">
                                <small id="helpStreet" class="form-text text-muted">La rue avec le numéro de rue</small>
                            </div>
                            <div class="form-group">
                                <label for="complements">Compléments</label>
                                <input type="text" class="form-control" name="complements" id="complements" aria-describedby="helpComplements">
                                <small id="helpComplements" class="form-text text-muted">Batiment, résidence...</small>
                            </div>
                            <div class="form-group">
                                <label for="zipCode">Code postal</label>
                                <input type="text" class="form-control" name="zipCode" id="zipCode" aria-describedby="helpZipCode" maxlength="5">
                                <small id="helpZipCode" class="form-text text-muted">Le code postal</small>
                            </div>
                            <div class="form-group">
                                <label for="city">Ville</label>
                                <input type="text" class="form-control" name="city" id="city" aria-describedby="helpCity">
                                <small id="helpCity" class="form-text text-muted">Le nom de la ville</small>
                            </div>
                            <div class="form-group">
                                <label for="company">Entreprise</label>
                                <input type="text" class="form-control" name="company" id="company" aria-describedby="helpCompany">
                                <small id="helpCompany" class="form-text text-muted">Le nom de l'entreprise à livrer</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>

                        @foreach (Auth::user()->addresses as $address)
                            <p class="company">{{ $address->company }}</p>
                            <p class="street">{{ $address->street }}</p>
                            <p class="complements">{{ $address->complements }}</p>
                            <p class="zipCode-city">{{ $address->zipCode }}, {{ $address->city }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer border-bottom p-3">
                <a href="{{route('logout')}}" class="mb-0 text-dark">Se déconnecter</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    addAddressBtn = $('#add-address-btn');
    addressCreationForm = $('#address-creation-form');

    addressCreationForm.hide();

    addAddressBtn.on('click', function(){

        if (addAddressBtn.hasClass("toggled")){
            addressCreationForm.hide();
            addAddressBtn.removeClass('toggled');
            addAddressBtn.text('Ajouter une adresse');
        } else {
            addressCreationForm.show();
            addAddressBtn.addClass('toggled');
            addAddressBtn.text('Annuler');
        }
    })
</script>
@endsection
