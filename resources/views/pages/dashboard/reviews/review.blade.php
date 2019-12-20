@extends('templates.dashboard')

@section('head-options')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12 pt-3">
        <a href='/dashboard/clients/avis' class='text-muted'>< Tous les avis</a>        
    </div>
</div>
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Avis de {{$review->customerPublicName}}
        </h1>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-12 mb-3 row m-0 p-0">
                <div class='col-lg-2'>
                    <img src='{{asset("images/products/". $review->product->mainImage)}}' class="w-100">
                </div>
                <div class='col-lg-10'>
                    <div class="form-group d-flex flex-column justify-content-center h-100">
                        <a id='product-name' href='/produits/{{$review->product->id}}' target="_blank">{{$review->product->name}}</a>
                        <small id="helpProductName" class="form-text text-muted">Le produit sur lequel figure le commentaire</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="customer-name">Nom du client :</label>
                    <input type="text" class="form-control" name="customer-name" id="customer-name" aria-describedby="helpCustomerName" value="{{$review->customerPublicName}}" disabled>
                    <small id="helpCustomerName" class="form-text text-muted">Le nom publique du client</small>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="customer-mail">Email du client :</label>
                    <input type="text" class="form-control" name="customer-mail" id="customer-mail" aria-describedby="helpCustomerMail" value="{{$review->customerEmail}}" disabled>
                    <small id="helpCustomerMail" class="form-text text-muted">L'email du client</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="admin-reponse">Commentaire :</label>
                    <textarea class="form-control" name="admin-reponse" id="admin-reponse" rows="3" disabled>{{$review->text}}</textarea>
                </div>
            </div>
        </div>
        <form class="row" action='/dashboard/clients/avis/repondre/{{$review->id}}' method="POST">
            @csrf

            {{-- Success --}}
            <div id="success-container" class="col-lg-12 d-none">
                <div class="alert alert-success px-3 mb-0">
                    <p id='success-message' class='text-success font-weight-bold mb-0'>Tout est bon ✅</p>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="admin-response">Réponse au commentaire :</label>
                    <textarea class="form-control @error('admin-response') is-invalid @enderror" name="admin-response" id="admin-response" rows="3">{{old('admin-response', $review->adminResponse)}}</textarea>
                    @error('admin-response')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class='d-flex'>
                    <button id='send-response-btn' type="button" class="btn btn-secondary ld-ext-right" onclick="send_response($(this))">
                        Envoyer la réponse
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                    <button id='delete-response-btn' type="button" class="btn btn-danger ml-3 ld-ext-right" onclick='delete_response($(this))'>
                        Supprimer la réponse
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// prepare AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// prepare page
$(document).ready(function(){
    toggle_buttons();
});
$('#admin-response').on('input', function() {
  toggle_buttons();
});

function toggle_buttons(){
    if($('#admin-response').val().length > 0){
        $('#delete-response-btn').show();
        $('#send-response-btn').attr("disabled", false);
    } else {
        $('#delete-response-btn').hide();
        $('#send-response-btn').attr("disabled", true);
    }
}

function send_response(btn){
    admin_response = $('#admin-response').val();

    $.ajax({
        url: "/dashboard/clients/avis/repondre/{{$review->id}}",
        type: 'post',
        data: { 'admin-response':admin_response },
        success: function(response){
            setTimeout( function(){ $("#success-container").slideUp(300); }, 2000 )

            $("#success-container").slideDown(300);
            $("#success-container").removeClass('d-none');

            btn.removeClass('running');
        },
        beforeSend: function() {
            btn.addClass('running');
        }
    });
}

function delete_response(btn, review_id){
    $('#admin-response').val('');
    send_response(btn);
    toggle_buttons();
}
</script>
@endsection