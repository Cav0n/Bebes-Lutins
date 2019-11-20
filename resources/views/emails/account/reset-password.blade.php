@extends('templates.email')

@section('content')
<main class='row justify-content-center m-0 my-5 px-4 px-sm-0'>
    <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <h1 class="text-primary h2">Réinitialisation de votre mot de passe</h1>
        <p class="text-justify">
            Bonjour <b>{{$user->firstname}} {{$user->lastname}}</b>, vous avez récemment
            demandé la réinitialisation de votre mot de passe.<BR>
            <BR>
            Voici le code de réinitialisation vous permettant de changer votre mot de passe :<BR>
            <H1 class='text-primary'>{{$user->resetCode}}</H1><BR>
            Si vous pensez qu'il s'agit d'une erreur nous vous
            invitons à nous contacter au plus vite à l'adresse
            <b><a href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a></b>.<BR>
            <BR>
            Belle journée,<BR>
            L'équipe Bébés Lutins 💚
        </p>
    </div>
</main>
@endsection