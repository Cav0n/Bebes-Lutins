@extends('templates.email')

@section('content')
<main class='row justify-content-center m-0 my-5 px-4 px-sm-0'>
    <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <h1 class="text-primary h2">Votre mot de passe a été modifié</h1>
        <p class="text-justify">
            Bonjour <b>{{$user->firstname}} {{$user->lastname}}</b>, vous avez récemment
            modifié votre mot de passe sur notre site (<a href='https://www.bebes-lutins.fr'>bebes-lutins.fr</a>).<BR>
            <BR>
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