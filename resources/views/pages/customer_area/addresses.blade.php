@extends('templates.default')

@section('title', "Mes adresses | Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 card p-0 border-0 rounded-0 shadow-sm">

            @include('components.customer_area.title')

            <div class="body p-3">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="h4 font-weight-bold">Mes adresses</h3>
                        <button type="button" class="btn btn-dark" id="add-address-btn">Ajouter une adresse</button>

                        <form id="address-creation" action="{{ route('user.addresses.create') }}" method="POST">
                            @csrf
                            @include("components.utils.addresses.creation")
                            <input type="hidden" name="back" value="1">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>

                        <div class="row">
                            @foreach (Auth::user()->addresses as $address)
                            <div class="col-12 col-sm-6 col-xl-4 col-xxl-3 my-2">
                                <div class="address border shadow-sm bg-light p-3">
                                    @include('components.utils.addresses.address', ['address' => $address])
                                    <div class="d-flex flex-wrap">
                                        <button type="button" class="btn btn-primary edit-address-btn py-0 px-2 mr-2" data-address_id="{{ $address->id }}">
                                            Éditer</button>
                                        <button type="button" class="btn btn-danger delete-address-btn py-0 px-2" data-address_id="{{ $address->id }}">
                                            Supprimer</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer rounded-0 bg-white p-3">
                <a href="{{route('logout')}}" class="mb-0 text-dark">Se déconnecter</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    addAddressBtn = $('#add-address-btn');
    addressCreationForm = $('#address-creation');

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

    @if($errors->any())
        addressCreationForm.show();
        addAddressBtn.addClass('toggled');
        addAddressBtn.text('Annuler');
    @endif
</script>
@endsection
