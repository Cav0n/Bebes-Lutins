@extends('templates.default')

@section('title', "Mes adresses | Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 card p-0">

            @include('components.customer_area.title')

            <div class="body p-3">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="h4 font-weight-bold">Mes adresses</h3>
                        <button type="button" class="btn btn-outline-primary" id="add-address-btn">Ajouter une adresse</button>

                        <form id="address-creation" action="{{ route('user.addresses.create') }}" method="POST">
                            @csrf
                            @include("components.utils.addresses.creation")
                            <input type="hidden" name="back" value="1">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>

                        @foreach (Auth::user()->addresses as $address)
                            @include('components.utils.addresses.address', ['address' => $address])
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
