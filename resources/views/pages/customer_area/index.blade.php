@extends('templates.default')

@section('title', "Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 card p-0 border-0 rounded-0 shadow-sm">

            @include('components.customer_area.title')

            <div class="body px-3">
                <div class="row py-3">
                    <div class="col-lg-10">
                        <h3 class="h4 font-weight-bold">Mes informations personnelles</h3>
                        <div class="personal-informations">
                            <p class="mb-0">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
                            <p class="mb-0">{{Auth::user()->email}}</p>
                            <p class="mb-0">{{Auth::user()->phone}}</p>
                        </div>
                        {{--//@todo: Create method for form --}}
                        <form class="personal-informations" action="" method="POST">
                            <div class="form-group">
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="helpFirstname">
                                <small id="helpFirstname" class="form-text text-muted">Votre prénom</small>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Nom de famille</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="helpLastname">
                                <small id="helpLastname" class="form-text text-muted">Votre nom de famille</small>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" aria-describedby="helpEmail">
                                <small id="helpEmail" class="form-text text-muted">Votre email (il vous sert à vous connecter)</small>
                            </div>
                            <div class="form-group">
                                <label for="phone">Téléphone</label>
                                <input type="text" class="form-control" name="phone" id="phone" aria-describedby="helpPhone">
                                <small id="helpPhone" class="form-text text-muted">Votre numéro de téléphone (nous l'utiliserons pour vous contacter à propos de vos commandes)</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                    <div class="col-lg-2">
                        <button id="personal-informations-btn" type="button" class="btn btn-dark w-100">Modifier</button>
                    </div>
                </div>
                <div class="row py-3 border-top">
                    <div class="col-lg-10">
                        <h3 class="h4 font-weight-bold">Mot de passe</h3>
                        <div class="password">
                            <p class="mb-0">Vous pouvez changer votre mot de passe quand vous le souhaitez.</p>
                        </div>
                        {{--//@todo: Create method for form --}}
                        <form class="password" action="" method="POST">
                            <div class="form-group">
                                <label for="password">Mot de passe actuel</label>
                                <input type="text" class="form-control" name="password" id="password" aria-describedby="helpPassword">
                                <small id="helpPassword" class="form-text text-muted">Votre mot de passe actuel</small>
                            </div>
                            <div class="form-group">
                                <label for="new-password">Nouveau mot de passe</label>
                                <input type="text" class="form-control" name="new-password" id="new-password" aria-describedby="helpNewPassword" placeholder="">
                                <small id="helpNewPassword" class="form-text text-muted">Le nouveau mot de passe que vous souhaitez</small>
                            </div>
                            <div class="form-group">
                                <label for="new-password-confirm">Confirmation du nouveau mot de passe</label>
                                <input type="text" class="form-control" name="new-password-confirm" id="new-password-confirm" aria-describedby="helpNewPasswordConfirm">
                                <small id="helpNewPasswordConfirm" class="form-text text-muted">Retapez votre nouveau mot de passe pour être sûr d'avoir écrit le bon.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                    <div class="col-lg-2">
                        <button id="password-btn" type="button" class="btn btn-dark w-100">Modifier</button>
                    </div>
                </div>
                <div class="row py-3 border-top">
                    <div class="col-lg-10">
                        <h3 class="h4 font-weight-bold">Newsletter</h3>
                        @if (Auth::user()->wantNewsletter)
                            <p class="mb-0">Vous avez indiqué vouloir recevoir les actualités Bébés Lutins.</p>
                        @else
                            <p class="mb-0">Vous avez indiqué ne pas vouloir recevoir les actualités Bébés Lutins.</p>
                        @endif
                    </div>
                    <div class="col-lg-2">
                        @if (Auth::user()->wantNewsletter)
                            <a class="btn btn-success w-100" href='{{ route('user.newsletters.toggle', ['user' => Auth::user()]) }}'>Activé</a>
                        @else
                            <a class="btn btn-danger w-100" href='{{ route('user.newsletters.toggle', ['user' => Auth::user()]) }}'>Désactivé</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer rounded-0 bg-white p-3">
                <a href="{{route('logout')}}" class="mb-0 text-dark">Se déconnecter</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('form.personal-informations').hide();
    $('form.password').hide();

    $('#personal-informations-btn').on('click', function(){
        $('form.personal-informations').toggle();
        $('div.personal-informations').toggle();
    });

    $('#password-btn').on('click', function(){
        $('form.password').toggle();
        $('div.password').toggle();
    });
</script>
@endsection
