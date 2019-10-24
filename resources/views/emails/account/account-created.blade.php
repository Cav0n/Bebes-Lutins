@extends('templates.email')

@section('content')
<main class='row justify-content-center m-0 my-5 px-4 px-sm-0'>
    <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <h1 class="text-primary h2">Votre compte a été crée !</h1>
        <p class="text-justify">
            Bonjour <b>{{$user->firstname}} {{$user->lastname}}</b>, vous recevez cet e-mail
            car vous venez de créer un compte sur notre site.<BR>
            <BR>
            Si vous pensez qu'il s'agit d'une erreur nous vous
            invitons à nous contacter à l'addresse
            <b><a href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a></b>.<BR>
            <BR>
            Belle journée,<BR>
            L'équipe Bébés Lutins 💚
        </p>
    </div>
</main>
@endsection