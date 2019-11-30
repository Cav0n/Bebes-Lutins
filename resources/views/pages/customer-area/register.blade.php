@extends('templates.template')

@section('content')
<main class='container-fluid mt-md-0 dim-background'>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card my-5 border-0 rounded-0">
                <div class="card-header bg-white">
                    Créer mon compte
                </div>
                <div class="card-body">
                    <small class="text-muted">* Les champs avec une astérisque sont obligatoires</small>
                    <form method="POST" action="/espace-client/enregistrement">
                        @csrf

                        {{-- FIRSTNAME --}}
                        <div class="form-group mb-2">
                          <label for="firstname" class='mb-0'>Votre prénom *</label>
                          <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" id="firstname" aria-describedby="helpFirstname" value='{{old('firstname', '')}}'>
                          @error('firstname')
                            <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        {{-- LASTNAME --}}
                        <div class="form-group mb-2">
                          <label for="lastname" class='mb-0'>Votre nom de famille *</label>
                          <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" id="lastname" aria-describedby="helpLastname" value='{{old('lastname', '')}}'>
                          @error('lastname')
                            <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="form-group mb-2">
                          <label for="email" class='mb-0'>Adresse e-mail *</label>
                          <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" aria-describedby="helpEmail" value='{{old('email', '')}}'>
                          @error('email')
                            <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        {{-- TELEPHONE --}}
                        <div class="form-group mb-2">
                          <label for="phone" class='mb-0'>Numéro de téléphone</label>
                          <input type="phone" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" aria-describedby="helpPhone" value='{{old('phone', '')}}'>
                          <small id="helpPhone" class="form-text text-muted">Votre numéro de téléphone n'est pas obligatoire mais nous permet de vous contacter plus facilement</small>
                          @error('phone')
                            <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-group mb-2">
                          <label for="password" class='mb-0'>Mot de passe *</label>
                          <input type="password" name="password" id="password" class="form-control  @error('password') is-invalid @enderror" aria-describedby="helpPassword">
                          @error('password')
                            <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div class="form-group mb-2">
                          <label for="password_confirmation" class='mb-0'>Retapez votre mot de passe *</label>
                          <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" aria-describedby="helpPassword">
                          <small id="helpPassword" class="form-text text-muted">Nous vous demandons cela pour que vous soyez sûr de ne pas vous tromper</small>
                          @error('password_confirmation')
                            <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        {{-- NEWSLETTER CHECKBOX --}}
                        <div class="custom-control custom-checkbox max-content mx-auto my-3 pointer">
                            <input name='want-newsletter' type="checkbox" class="custom-control-input pointer" id="want-newsletter" checked>
                            <label class="custom-control-label noselect pointer" for="want-newsletter">Je souhaite recevoir la newsletter Bébés Lutins</label>
                        </div>

                        <div class="form-group d-flex justify-content-center">
                          <button id='submit-button' type="submit" class="btn btn-primary" disabled>Créer mon compte</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white text-muted">
                    <a href='/espace-client/connexion' class="text-muted">J'ai déjà un compte</a>
                </div>
            </div>
        </div>
    </div>
</main>

{{--  prepare page  --}}
<script>
  $(document).ready(function(){
    if($('#firstname').val().length > 0 &&
        $('#lastname').val().length > 0 &&
        $('#email').val().length > 0 &&
        $('#password').val().length > 0 &&
        $('#password_confirmation').val().length > 0 &&
        ($('#phone').val().length == 0 || $('#phone').val().length == 10)){

          $('#submit-button').attr('disabled', false);
    } else {
      $('#submit-button').attr('disabled', true);
    }
  });
</script>

{{--  activate submit button  --}}
<script>
  $(':input').on('input propertychange', function(element){
    currentValue = element.currentTarget.value;
    if($('#firstname').val().length > 0 &&
        $('#lastname').val().length > 0 &&
        $('#email').val().length > 0 &&
        $('#password').val().length > 0 &&
        $('#password_confirmation').val().length > 0 &&
        ($('#phone').val().length == 0 || $('#phone').val().length == 10)){

          $('#submit-button').attr('disabled', false);
    } else {
      $('#submit-button').attr('disabled', true);
    }
  });
</script>
@endsection