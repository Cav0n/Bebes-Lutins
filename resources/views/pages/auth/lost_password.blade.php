@extends('templates.default')

@section('title', "Connexion - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center py-xl-5">
        <div class="col-11 col-md-10 col-lg-6 col-xl-5 col-xxl-4 col-xxxl-3 p-0">
            @if ($errors->has('throttle'))
                <div class="alert alert-danger">
                    <p class="mb-0">{{ $errors->first('throttle') }}</p>
                </div>
            @endif
            <div id="lost-password-container" class="p-3 shadow-sm bg-white">
                <h1>J'ai perdu mon mot de passe</h1>
                <p>Nous allons vous envoyer un email pour que vous puissiez reinitialiser votre mot de passe facilement.</p>
                <div class="form-group">
                    <label for="email">Veuillez indiquer votre email : </label>
                    <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" aria-describedby="helpEmail" value="{{ old('email') }}">
                    {!! $errors->has('email') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('email')) . "</div>" : '' !!}
                </div>
                <button id="submit-btn" type="submit" class="btn btn-primary">
                    Envoyer l'email de réinitialisation</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    errorFeedbackHtml = "<div class='invalid-feedback'>__error__</div>"
    var userId = null;

    $('#lost-password-container').on('show_reset_password_modal', function (event, param) {
        userId = param.userId;
        $('#lost-password-container').append(param.template);
        $('#reset-password-modal').modal('show');
    });

    $('#lost-password-container #submit-btn').on('click', function() {
        email = $('#lost-password-container #email');

        $('.invalid-feedback').remove();
        email.removeClass('is-invalid');

        fetch("{{ route('password.lost.reset') }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({email: email.val()})
        })
        .then(response => response.json())
        .then(response => {
            if (undefined !== response.error){
                throw response.error;
            }

            $('#lost-password-container').trigger('show_reset_password_modal', [response]);
        }).catch((error) => {
            email.addClass('is-invalid');
            $('#lost-password-container .form-group').append(errorFeedbackHtml.replace('__error__', error.message));
        });
    });
</script>
@endsection
