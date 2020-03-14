<div id="reset-password-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reinitialisation du mot de passe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id='password-reset-code-container' class="form-group">
                    <label for="password-reset-code">Nous vous avons envoyé un code par email. Veuillez le coller ici :</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="hashtag">#</span>
                        </div>
                        <input type="text" class="form-control" name="password-reset-code" id="password-reset-code" aria-describedby="helpPasswordResetCode">
                    </div>
                    <small id="helpPasswordResetCode" class="form-text text-muted">Vous n'avez pas recu l'email ?</small>
                </div>
            </div>
            <div class="modal-footer">
                <button id="verify-reset-code-btn" type="button" class="btn btn-outline-primary">Étape suivante</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Reset userID because without it userID become undefined after
    // first successed code verification
    userID = userId;

    $('#reset-password-modal').on('code_verification_success', function (event, param) {
        $('#password-reset-code-container').after(param.inputTemplate);
        $('#reset-password-modal .modal-footer #verify-reset-code-btn').remove();
        $('#reset-password-modal .modal-footer').append(param.btnTemplate);

        password = $('#newPassword');

        $('#reset-password-btn').on('click', function() {
            $('.invalid-feedback').remove();
            password.removeClass('is-invalid');

            fetch("{{ route('password.reset') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    password: password.val(),
                    user: userID,
                })
            })
            .then(response => response.json())
            .then(response => {
                if (undefined !== response.errors){
                    throw response.errors;
                }

                window.location.href = "{{ route('login') }}";
            }).catch((errors) => {
                password.addClass('is-invalid');
                errors.password.forEach(message => {
                    password.after(errorFeedbackHtml.replace('__error__', message));
                });
            });
        });
    });

    $('#verify-reset-code-btn').on('click', function() {
        code = $('#password-reset-code');

        $('.invalid-feedback').remove();
        code.removeClass('is-invalid');

        fetch("{{ route('password.reset.verify_code') }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                    code: code.val(),
                    user: userID,
                })
        })
        .then(response => response.json())
        .then(response => {
            if (undefined !== response.error){
                throw response.error;
            }

            $('#password-reset-code').attr('disabled', 'disabled');
            $('#reset-password-modal').trigger('code_verification_success', [response]);
        }).catch((error) => {
            code.addClass('is-invalid');
            $('#password-reset-code').after(errorFeedbackHtml.replace('__error__', error.message));
        });
    });
</script>

{{-- RESET PASSWORD FUNCTION --}}
<script>
    $('#reset-password-btn').on('click', function() {
        console.log('c\'est parti')
    });
</script>
