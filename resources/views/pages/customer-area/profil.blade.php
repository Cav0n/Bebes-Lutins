@extends('templates.customer-area')

@section('body')
<div class="row">
    <div class="col-12 col-md-9">
        <div id='profil-infos'>
            <p class='h5 font-weight-bold'>Mes informations personnelles</p>
            <p id='profil-success-message' class='mb-0 text-success'></p>
            <p class='mb-0'>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
            <p class='mb-0'>Inscrit depuis le {{ Auth::user()->created_at->formatLocalized('%e %B %Y') }}</p>
            <p class='mb-0'>Date de naissance : @if(Auth::user()->birthdate != null){{  Auth::user()->birthdate->formatLocalized('%e %B %Y') }} @else non indiquée @endif</p> 
            <p class='mb-0'>Téléphone : @if(Auth::user()->phone != null){{ trim( chunk_split(Auth::user()->phone, 2, ' ')) }} @else non indiqué @endif </p>
        </div>
        <div id='profil-infos-modification'>
            <p class='h5 font-weight-bold'>Modifier mes informations</p>
            <p id='profil-error-message' class='text-danger pb-0'></p>
            <div class="form-group">
                <label for="firstname">Prénom</label>
                <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="helpFirstname" placeholder="" value="{{Auth::user()->firstname}}">
                <small id="helpFirstname" class="form-text text-muted">Votre prénom</small>
            </div>

            <div class="form-group">
                <label for="lastname">Nom de famille</label>
                <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="helpLastname" placeholder="" value="{{Auth::user()->lastname}}">
                <small id="helpLastname" class="form-text text-muted">Votre nom de famille</small>
            </div>
            
            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="text" class="form-control" name="phone" id="phone" aria-describedby="helpPhone" placeholder="" value="{{Auth::user()->phone}}">
                <small id="helpPhone" class="form-text text-muted">Votre numéro de téléphone</small>
            </div>

            <div class="form-group">
                <label for="birthdate">Date de naissance</label>
                <input type="text" class="form-control" name="birthdate" id="birthdate" aria-describedby="helpBirthdate" placeholder="" value="{{Auth::user()->birthdate}}" disabled>
                <small id="helpBirthdate" class="form-text text-muted">Vous pourrez bientôt nous indiquer votre date de naissance</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 pt-2 pt-md-0">
        <button id='profil-button' type="button" class="btn btn-outline-dark w-100 rounded-0">
            <p class='text-center mb-0 mx-auto'>Modifier</p></button>
        <button id='profil-button-cancel' type="button" class="btn btn-outline-danger w-100 rounded-0 ld-ext-right">
                <p class='text-center mb-0 mx-auto'>Annuler</p><div class="ld ld-ring ld-spin"></div></button>
        <button id='profil-button-validate' type="button" class="btn btn-outline-success w-100 rounded-0 ld-ext-right">
                <p class='text-center mb-0 mx-auto'>Valider</p><div class="ld ld-ring ld-spin"></div></button>
    </div>
</div>
<div class="row mt-4 pt-4 border-top">
    <div class="col-12 col-md-9">
        <div id='password-infos'>
            <p class='h5 font-weight-bold'>Mot de passe</p>
            <p id='password-success-message' class='mb-0 text-success'></p>
            <p class='mb-0'>Vous pouvez modifier votre mot de passe à tout moment.</p>
        </div>
        <div id='password-infos-modification'>
            <p class='h5 font-weight-bold'>Modifier mon mot de passe</p>
            <p id='password-error-message' class='text-danger pb-0'></p>
            <div class="form-group">
                <label for="old_password">Ancien mot de passe</label>
                <input type="password" class="form-control" name="old_password" id="old_password" aria-describedby="helpPassword" placeholder="">
                <small id="helpPassword" class="form-text text-muted">Vous devez entrer votre ancien mot de passe par mesure de sécurité</small>
            </div>
            <div class="form-group">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="text" class="form-control" name="new_password" id="new_password" aria-describedby="helpNewPassword" placeholder="">
                <small id="helpNewPassword" class="form-text text-muted">Le nouveau mot de passe que vous souhaitez utiliser</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 pt-2 pt-md-0">
        <button id='password-button' type="button" class="btn btn-outline-dark w-100 rounded-0">
                <p class='text-center mb-0 mx-auto'>Modifier</p></button>
        <button id='password-button-cancel' type="button" class="btn btn-outline-danger w-100 rounded-0 ld-ext-right">
                <p class='text-center mb-0 mx-auto'>Annuler</p><div class="ld ld-ring ld-spin"></div></button>
        <button id='password-button-validate' type="button" class="btn btn-outline-success w-100 rounded-0 ld-ext-right">
                <p class='text-center mb-0 mx-auto'>Valider</p><div class="ld ld-ring ld-spin"></div></button>
    </div>
</div>
<div class="row mt-4 pt-4 border-top">
    <div class="col-8 col-xl-9">
        <p class='h5 font-weight-bold'>Newsletter</p>
        @if(Auth::user()->wantNewsletter) <p class='mb-0'> Vous avez indiqué vouloir recevoir les actualités Bébés Lutins.</p>
        @else <p class='mb-0'> Vous avez indiqué ne pas vouloir recevoir les actualités Bébés Lutins.</p>
        @endif
    </div>
    <div class="col-4 col-xl-3">
        @if(Auth::user()->wantNewsletter) 
        <button id='desktop-button' type="button" class="btn btn-outline-success border-success w-100 d-none d-md-flex rounded-0 ld-ext-right" onclick='invert_newsletter($(this))'>
            <p class='text-center mb-0 mx-auto d-flex flex-column justify-content-center'>Activé</p><div class="ld ld-ring ld-spin"></div></button>
        @else 
        <button id='desktop-button' type="button" class="btn btn-outline-danger w-100 d-none d-md-flex rounded-0 ld-ext-right" onclick='invert_newsletter($(this))'>
            <p class='text-center mb-0 mx-auto d-flex flex-column justify-content-center'>Désactivé</p><div class="ld ld-ring ld-spin"></div></button>
        @endif
    </div>
</div>

{{-- PREPARE PAGE --}}
<script>
    $(document).ready(function(){
        $("#profil-infos-modification").hide();
        $("#profil-button-cancel").hide();
        $("#profil-button-validate").hide();

        $("#password-infos-modification").hide();
        $("#password-button-cancel").hide();
        $("#password-button-validate").hide();
    });

    $('#profil-button').on('click', function(){
        $("#profil-infos").hide();
        $('#profil-button').hide();
        $("#profil-infos-modification").fadeIn(300);

        firstname = $("#firstname").val();
        lastname = $("#lastname").val();

        if (firstname.length > 0 && lastname.length > 0){
            $('#profil-button-cancel').hide();
            $("#profil-button-validate").fadeIn(300);
        } else {
            $("#profil-button-validate").hide();
            $('#profil-button-cancel').fadeIn(300);
        }
    });

    $('#profil-button-cancel').on('click', function(){
        $("#profil-infos-modification").hide();
        $('#profil-button-cancel').hide();
        $("#profil-infos").fadeIn(300);
        $("#profil-button").fadeIn(300);
    });

    $("#profil-button-validate").on('click', function(){
        firstname = $("#firstname").val();
        lastname = $("#lastname").val();
        phone = $("#phone").val();
        birthdate = $("#birthdate").val();

        update_infos($(this), firstname, lastname, phone, birthdate);
    });

    $('#firstname, #lastname, #phone, #birthdate').change(function(){
        firstname = $("#firstname").val();
        lastname = $("#lastname").val();
        phone = $("#phone").val();
        birthdate = $("#birthdate").val();
        
        if (firstname.length > 0 && lastname.length > 0){
            $('#profil-button-cancel').hide();
            $("#profil-button-validate").fadeIn(300);
        } else {
            $("#profil-button-validate").hide();
            $('#profil-button-cancel').fadeIn(300);
        }
    });

    $('#password-button').on('click', function(){
        $("#password-infos").hide();
        $('#password-button').hide();
        $("#password-infos-modification").fadeIn(300);
        $("#password-button-cancel").fadeIn(300);
    });

    $('#password-button-cancel').on('click', function(){
        $("#password-infos-modification").hide();
        $('#password-button-cancel').hide();
        $("#password-infos").fadeIn(300);
        $("#password-button").fadeIn(300);
    });

    $("#password-button-validate").on('click', function(){
        old_password = $("#old_password").val();
        new_password = $("#new_password").val();

        update_password($(this), old_password, new_password);
    });

    $('#old_password, #new_password').change(function(){
        var old_password = $('#old_password').val();
        var new_password = $('#new_password').val();
        
        if (old_password.length > 0 && new_password.length > 0){
            $('#password-button-cancel').hide();
            $("#password-button-validate").fadeIn(300);
        } else {
            $("#password-button-validate").hide();
            $('#password-button-cancel').fadeIn(300);

        }
    });
</script>

{{-- AJAX UPDATE INFOS --}}
<script>
    function update_infos(btn, firstname, lastname, phone, birthdate){
        $.ajax({
            url: "/espace-client/profil/modifier-informations",
            type: 'POST',
            data: { firstname:firstname, lastname:lastname, phone:phone, birthdate:birthdate },
            success: function(data){
                btn.removeClass('running');
                $("#profil-infos-modification").hide();
                $('#profil-button-cancel').hide();
                $('#profil-button-validate').hide();

                $("input").val("");
                $("input").removeClass('border-danger');

                $("#profil-infos").fadeIn(300);
                $("#profil-button").fadeIn(300);

                $("#profil-success-message").text("Informations mis à jour avec succés")

                setTimeout(function(){
                    window.location.reload(); // you can pass true to reload function to ignore the client cache and reload from the server
                },1200); //delayTime should be written in milliseconds e.g. 1000 which equals 1 second
            },
            error: function(response){
                btn.removeClass('running');
                
                error_message = response.responseJSON.message;
                errors_fields = Object.keys(response.responseJSON.errors);
                
                errors_fields.forEach(function(field){
                    $('#' + field).addClass('border-danger');
                });

                $('#profil-error-message').text(response.responseJSON.message);
            },
            beforeSend: function() {
                btn.addClass('running');
            }
        })
    }
</script>

{{-- AJAX UPDATE PASSWORD --}}
<script>
    function update_password(btn, old_password, new_password){
        $.ajax({
            url: "/espace-client/profil/modifier-mot-de-passe",
            type: 'POST',
            data: { old_password, new_password },
            success: function(data){
                btn.removeClass('running');
                $("#password-infos-modification").hide();
                $('#password-button-cancel').hide();
                $('#password-button-validate').hide();

                $("input").val("");
                $("input").removeClass('border-danger');

                $("#password-infos").fadeIn(300);
                $("#password-button").fadeIn(300);

                $("#password-success-message").text("Mot de passe modifié avec succés.")
            },
            error: function(response){
                btn.removeClass('running');

                error_message = response.responseJSON.message;

                errors_fields = Object.keys(response.responseJSON.errors);
                errors_fields.forEach(function(field){
                    $('#' + field).addClass('border-danger');
                });

                $('#password-error-message').text(response.responseJSON.message);
            },
            beforeSend: function() {
                btn.addClass('running');
            }
        });
    }
</script>

{{-- INVERT NEWSLETTER --}}
<script>
    function invert_newsletter(btn){
        $.ajax({
            url: "/espace-client/newsletter-invert",
            type: 'POST',
            data: { },
            success: function(data){
                console.log('Toggle newsletter.');
                location.reload();
            },
            beforeSend: function() {
                btn.addClass('running');
            }
        })
        .done(function( data ) {
            
        }); 
    }
</script>
    
@endsection