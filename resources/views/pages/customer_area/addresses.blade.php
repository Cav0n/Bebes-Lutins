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

                        {{--//@todo: Create method for form --}}
                        <form id="address-creation" action="" method="POST">
                            @csrf
                            @include('components.utils.addresses.creation', ['billing' => false, 'submitBtn' => true, 'action' => route('user.addresses.create')])
                        </form>

                        @foreach (Auth::user()->addresses as $address)
                            <p class="company">{{ $address->company }}</p>
                            <p class="identity">{{ $address->identity }}</p>
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
</script>
@endsection
