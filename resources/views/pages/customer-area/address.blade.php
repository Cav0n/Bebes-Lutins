@extends('templates.customer-area')

@section('body')
<div class="row">
    @if(count($addresses) == 0)
    <div class="col-12">
        <p class='h5 font-weight-bold'>Vos adresses</p>
        <p class='mb-0'>Vous n'avez aucune adresse enregistrée.</p>
    </div>
    @else
    <div class='col-12'>
        @foreach ($addresses as $address)
        <div class='address-container my-2 p-2 border row justify-content-lg-between m-0' style='box-shadow: 0 0 9px -6px rgb(100,100,100)'>
            <div class="col-6">
                <p class='mb-0 font-weight-bold'>{{$address->civilityToString()}} {{$address->firstname}} {{$address->lastname}}</p>
                @if($address->complement != null) <small>{{$address->complement}}</small> @endif
                @if($address->company != null) <small>{{$address->company}}</small> @endif
                <p class='mb-0'>{{$address->street}}, {{$address->zipCode}}</p>
                <p class='mb-0'>{{$address->city}}</p>
            </div>
           <div class="col-6 d-flex justify-content-end">
                <div class='d-flex flex-column'>
                    <button type="button" class="btn btn-dark py-1 px-2 ld-ext-right ml-auto max-content mb-2 ">
                        Editer <div class="ld ld-ring ld-spin"></div>
                    </button>
                    <button type="button" class="btn btn-danger py-1 px-2 ld-ext-right ml-auto max-content" onclick='delete_address($(this), "{{$address->id}}")'>
                        Supprimer <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
           </div>
        </div>
        @endforeach 
    </div>
    @endif
    <div class="col-12">
        <button type="button" class="btn btn-secondary mt-2 ld-ext-right" onclick='load_url("/espace-client/adresses/creation")'>
             Nouvelle adresse <div class="ld ld-ring ld-spin"></div>
        </button>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function delete_address(btn, address_id){
        $.ajax({
            url: "/espace-client/adresses/" + address_id,
            type: 'DELETE',
            data: { },
            success: function(data){
                console.log('Adresse supprimée.');
                btn.parent().parent().parent().hide();
            },
            beforeSend: function() {
                btn.parent().addClass('running');
            }
        })
        .done(function( data ) {
            
        }); 
    }
</script>
@endsection