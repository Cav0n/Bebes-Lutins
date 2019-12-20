<div id='resetPasswordPopup' class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reinitialisation du mot de passe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id='confirmation-code-container' class="modal-body row m-0">
                <div class="form-group">
                    <label for="confirmation-code">Code de confirmation</label>
                    <input type="text" class="form-control" name="confirmation-code" id="confirmation-code" aria-describedby="helpConfirmationCode" placeholder="">
                    <small id="helpConfirmationCode" class="form-text text-muted">Nous vous avons envoyé un code à votre adresse mail. Veuillez vérifier dans les "Spams" s'il n'apparaît pas.</small>
                </div>

                <div id='new-password-group' class="form-group">
                    <label for="new-password">Nouveau mot de passe</label>
                    <input type="text" class="form-control" name="new-password" id="new-password" aria-describedby="helpNewPassword" placeholder="">
                    <small id="helpNewPassword" class="form-text text-muted">Votre nouveau mot de passe</small>
                </div>
            </div>

            <div class="modal-footer flex-wrap">
                <button id='check-verification-code-button' type="button" class="btn btn-secondary rounded-0 mb-2 mb-sm-0 ml-auto ld-ext-right">
                    Valider <div class="ld ld-ring ld-spin"></div></button>
                <button id='reset-password-button' type="button" class="btn btn-secondary rounded-0 mb-2 mb-sm-0 ml-auto ld-ext-right">
                    Valider <div class="ld ld-ring ld-spin"></div></button>
            </div>
        </div>
    </div>
</div>

{{-- PREPARE PAGE --}}
<script>
    $('#check-verification-code-button').on('click', function(){
        verify_code($(this));
    });

    $('#reset-password-button').on('click', function(){
        reset_password($(this));
    });

    $('#new-password-group').hide();
    $('#reset-password-button').hide();
</script>

{{-- VERIFY CODE --}}
<script>
function verify_code(btn){
    confirmation_code = $("#confirmation-code").val();
    email = $("#email").val();

    $.ajax({
        url: "/espace-client/verifier-code-reinitialisation",
        type: 'POST',
        data: { email: email, confirmation_code: confirmation_code },
        success: function(response){
            btn.removeClass('running');

            $('#confirmation-code').prop('disabled', true);
            $('#check-verification-code-button').hide();
            $('#new-password-group').fadeIn(300);
            $('#reset-password-button').fadeIn(300);
        },
        error: function(response){
            $('#confirmation-code-container').append(
                "<p id='code-error-message' class='mb-0 text-danger'>"+response.responseJSON.message+"</p>"
            )
            btn.removeClass('running');
        },
        beforeSend: function() {
            btn.addClass('running');
            $('#result-message').remove();
            $('#code-error-message').remove();
        }
    });
}
</script>

{{-- PASSWORD RESET --}}
<script>
    function reset_password(btn){
        confirmation_code = $("#confirmation-code").val();
        email = $("#email").val();
        new_password = $("#new-password").val();
    
        $.ajax({
            url: "/espace-client/reinitialiser-mot-de-passe",
            type: 'POST',
            data: { confirmation_code:confirmation_code, email:email, new_password: new_password },
            success: function(response){
                $('#resetPasswordPopup').modal('toggle')
                btn.removeClass('running');

                $('#reset-button-container').append(
                "<p id='result-message' class='mb-0 ml-2 text-success d-flex flex-column justify-content-center'>"
                    +response.message+
                "</p>");

                setTimeout(function(){
                    load_url('/espace-client/connexion');
                },2000); 
            },
            error: function(response){
                btn.removeClass('running');
            },
            beforeSend: function() {
                btn.addClass('running');
                $('#result-message').remove();
            }
        });
    }
</script>