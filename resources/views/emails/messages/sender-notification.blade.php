@extends('templates.email')

@section('content')
<main class='row justify-content-center m-0 my-5 px-4 px-sm-0'>
    <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <h1 class="text-primary h2">Nous avons bien reçu votre message</h1>
        <p class="text-justify">
            Merci pour votre message {{$contact_message->senderName}}, nous vous répondrons dans les plus brefs délais.<BR>
            <BR>
            Pour rappel, votre message est « {{$contact_message->message }} » <br>
            <BR>
            - L'équipe Bébés Lutins 💚
        </p>
    </div>
</main>
@endsection