@extends('templates.email')

@section('content')
<main class='row justify-content-center m-0 my-5 px-4 px-sm-0'>
    <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <h1 class="text-primary h2">Nouveau message de {{$contact_message->senderName}}</h1>
        <p class="text-justify">
            « {{$contact_message->message}} »<BR>
            <BR>
            Vous pouvez répondre à {{$contact_message->senderName}} en répondant à cet email ou en 
            cliquant sur son adresse mail : <a href='mailto:{{$contact_message->senderEmail}}'>{{$contact_message->senderEmail}}</a>
        </p>
    </div>
</main>
@endsection