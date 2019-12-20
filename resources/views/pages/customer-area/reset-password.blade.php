@extends('templates.template')

@section('head-options')
{{-- Loading CSS --}}
<link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading.css')}}">
<link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading-btn.css')}}">

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<main class='container-fluid mt-md-0 dim-background'>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card my-5 border-0 rounded-0">
                <div class="card-header bg-white">
                    Réinitialiser mon mot de passe
                </div>
                <div class="card-body">
                    <form method="POST" action="/espace-client/generer-code-reinitialisation">
                        @csrf
                        {{-- EMAIL --}}
                        <div class="form-group mb-2">
                          <label for="email" class='mb-0'>Adresse e-mail</label>
                          <input type="email" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpEmail">
                        </div>

                        <div id='reset-button-container' class="form-group d-flex">
                            <button id='reset-button' type="button" class="btn btn-primary ld-ext-right">
                                Réinitialiser <div class="ld ld-ring ld-spin"></div>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@include('components.public.popups.password-reset')

{{-- PREPARE PAGE --}}
<script>
    $('#reset-button').on('click', function(){
        generate_reset_code($(this));
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

{{-- RESET PASSWORD AJAX --}}
<script>
    function generate_reset_code(btn){
        email = $("#email").val();
        $.ajax({
            url: "/espace-client/generer-code-reinitialisation",
            type: 'POST',
            data: { email:email },
            success: function(response){
                btn.removeClass('running');
                $('#resetPasswordPopup').modal('toggle')
                $('#reset-button-container').append(
                    "<p id='result-message' class='mb-0 ml-2 text-success d-flex flex-column justify-content-center'>"
                        +response.responseJSON.message+
                    "</p>");
            },
            error: function(response){
                btn.removeClass('running');
                $('#reset-button-container').append(
                    "<p id='result-message' class='mb-0 ml-2 text-danger d-flex flex-column justify-content-center'>"
                    +response.responseJSON.message+
                "</p>");
            },
            beforeSend: function() {
                btn.addClass('running');
                $('#result-message').remove();
            }
        });
    }
</script>
@endsection