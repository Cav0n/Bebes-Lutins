@extends('templates.template')

@section('title', "Mode d'emploi des couches lavables - Bébés Lutins")

@section('content')
<div class="row justify-content-center py-lg-5 m-0">
    <div class="col-12 col-lg-6">

        <h1 class='h2 font-weight-bold mb-3'>Mode d'emploi des couches lavables</h1>

        <nav class="nav nav-pills mb-2">
            <small><a id='colombine-button' class="nav-link active py-1" href="#">
                Système "TE2" Colombine</a></small>
            <small><a id='diapers-and-panties-button' class="nav-link py-1" href="#">
                Système couche + culotte</a></small>
            <small><a id='papillon-button' class="nav-link py-1" href="#">
                Réglage de la taille de la Papillon</a></small>
        </nav>

        <div id='manuals-container'>

            <div id='colombine'>
                <div class='row'>
                    <div class="col-lg-3">
                       <img class='w-100' src='{{asset('images/utils/manual/colombine/1.jpg')}}'>
                    </div>
                    <div class="col-lg-9 d-flex flex-column justify-content-center">
                        <p class="mb-0">Réglage des pressions à l'avant suivant le poids de bébé.</p>
                    </div>
                </div>

                <div class='row pt-2'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/colombine/2.jpg')}}'>
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <p>
                            Fixer le grand pan / insert absorbant à l'aide des 2 pressions à l'avant
                            de la couche. Ajouter le petit pan / insert si besoin, en le glissant
                            en dessous et bien à l'avant de la couche.
                        </p>
                    </div>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/colombine/3.jpg')}}'>
                    </div>
                </div>

                <div class='row pt-2'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/colombine/4.jpg')}}'>
                    </div>
                    <div class="col-lg-9 d-flex flex-column justify-content-center">
                        <p>Placer le voile de protection jetable au fond de la couche.</p>
                    </div>
                </div>
                
                <div class='row pt-2'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/colombine/5.jpg')}}'>
                    </div>
                    <div class="col-lg-9 d-flex flex-column justify-content-center">
                        <p>On installe la couche sur bébé, on referme, c'est aussi simple que ça !</p>
                    </div>
                </div>

                <div class='row pt-2'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/colombine/6.jpg')}}'>
                    </div>
                    <div class="col-lg-9 d-flex flex-column justify-content-center">
                        <p>On vérifie autour des cuisses et dans le dos, le voile de protection et 
                            le tissu absorbant ne doivent pas dépasser.</p>
                    </div>
                </div>
            </div>

            <div id='diapers-and-panties'>
                <div class='row'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/1.png')}}'>
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <p>
                            Positionner le voile de protection jetable au fond de la couche.
                        </p>
                    </div>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/2.png')}}'>
                    </div>
                </div>

                <div class='row'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/3.png')}}'>
                    </div>
                    <div class="col-lg-9 d-flex flex-column justify-content-center">
                        <p class="mb-0">Installer la couche classique sur bébé.</p>
                    </div>
                </div>

                <div class='row pt-2'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/4.png')}}'>
                    </div>
                    <div class="col-lg-9 d-flex flex-column justify-content-center">
                        <p>Puis installer la culotte de protection indispensable pour les couches classiques.</p>
                    </div>
                </div>
                
                <div class='row pt-2'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/5.png')}}'>
                    </div>
                    <div class="col-lg-9 d-flex flex-column justify-content-center">
                        <p>On vérifie autour des cuisses et dans le dos, la couche classique ne doit pas dépasser.<br>
                            Et le biais élastique doit être juste posé sans trop serrer.</p>
                    </div>
                </div>
            </div>

            <div id='papillon'>
                <div class='row'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/papillon/1.png')}}'>
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <p>
                            Placer la doublure au fond de la couche si besoin (nuit par exemple).
                            Puis positionner le voile de protection jetable au fond de la couche.
                        </p>
                    </div>
                    <div class="col-lg-3">
                        <img class='w-100 h-100' src='{{asset('images/utils/manual/papillon/2.png')}}' style='object-fit:cover'>
                    </div>
                </div>
                
                <div class='row'>
                    <div class="col-lg-3">
                        <img class='w-100 h-100' src='{{asset('images/utils/manual/papillon/3.png')}}' style='object-fit:cover'>
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <p>
                            Réglage de la taille suivant le poids de bébé.
                            (A gauche : petit et moyen)
                            (A droite : grand)
                        </p>
                    </div>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/papillon/4.png')}}'>
                    </div>
                </div>
                
                <div class='row'>
                    <div class="col-lg-12 d-flex flex-column justify-content-center">
                        <p class="text-center my-2">
                            On installe la couche sur bébé, on referme, c'est aussi simple que ça !
                        </p>
                    </div>
                </div>

                <div class='row'>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/papillon/5.png')}}'>
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <p>
                            On vérifie autour des cuisses et dans le dos, le voile de protection ne doit pas dépasser.
                        </p>
                    </div>
                    <div class="col-lg-3">
                        <img class='w-100' src='{{asset('images/utils/manual/papillon/6.png')}}'>
                    </div>
                </div>
    
                <div class='row'>
                    <div class="col-lg-12 d-flex flex-column justify-content-center">
                        <p class="text-center my-2">
                            Et on n'oublie pas d'ajouter la culotte de protection imperméable :-).
                        </p>
                    </div>
                </div>
            </div>
        </div>
        

        <div class='pt-3'>
            <h2 class='h4'>En image</h2>
            <div class="row">
                <div class="col-12 col-lg-4 my-2 my-lg-2">
                    <img class='w-100' src='{{asset('images/utils/manual/Mode-Emploi-Colombine.jpg')}}'>
                </div>
                <div class="col-12 col-lg-4 my-2 my-lg-2">
                    <img class='w-100' src='{{asset('images/utils/manual/Mode-Emploi-CoucheCulotte.jpg')}}'>
                </div>
                <div class="col-12 col-lg-4 my-2 my-lg-2">
                    <img class='w-100' src='{{asset('images/utils/manual/Mode-Emploi-Papillon.jpg')}}'>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  PREPARE PAGE  --}}
<script>
    $(document).ready(function(){
        $('#diapers-and-panties').hide();
        $('#papillon').hide();

        $('#colombine-button').on('click', function(){
            $('#colombine').fadeIn(300);
            $('#diapers-and-panties').hide();
            $('#papillon').hide(); 

            $('#colombine-button').addClass('active');
            $('#diapers-and-panties-button').removeClass('active');
            $('#papillon-button').removeClass('active');
        });

        $('#diapers-and-panties-button').on('click', function(){
            $('#colombine').hide();
            $('#diapers-and-panties').fadeIn(300);
            $('#papillon').hide(); 

            $('#diapers-and-panties-button').addClass('active');
            $('#colombine-button').removeClass('active');
            $('#papillon-button').removeClass('active');
        });

        $('#papillon-button').on('click', function(){
            $('#colombine').hide();
            $('#diapers-and-panties').hide();
            $('#papillon').fadeIn(300);

            $('#papillon-button').addClass('active');
            $('#diapers-and-panties-button').removeClass('active');
            $('#colombine-button').removeClass('active');
        });
    });
</script>
@endsection