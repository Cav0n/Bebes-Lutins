@extends('templates.template')

@section('title', "Guide et conseils - Bébés Lutins")

@section('content')

<div class='my-3'>

    {{-- MANUALS --}}
    <div class="row justify-content-center py-lg-2 m-0">
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
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/colombine/1.jpg')}}'>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center">
                            <p class="mb-0">Réglage des pressions à l'avant suivant le poids de bébé.</p>
                        </div>
                    </div>

                    <div class='row pt-2'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/colombine/2.jpg')}}'>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-center">
                            <p>
                                Fixer le grand pan / insert absorbant à l'aide des 2 pressions à l'avant
                                de la couche. Ajouter le petit pan / insert si besoin, en le glissant
                                en dessous et bien à l'avant de la couche.
                            </p>
                        </div>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/colombine/3.jpg')}}'>
                        </div>
                    </div>

                    <div class='row pt-2'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/colombine/4.jpg')}}'>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center">
                            <p>Placer le voile de protection jetable au fond de la couche.</p>
                        </div>
                    </div>
                    
                    <div class='row pt-2'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/colombine/5.jpg')}}'>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center">
                            <p>On installe la couche sur bébé, on referme, c'est aussi simple que ça !</p>
                        </div>
                    </div>

                    <div class='row pt-2'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/colombine/6.jpg')}}'>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center">
                            <p>On vérifie autour des cuisses et dans le dos, le voile de protection et 
                                le tissu absorbant ne doivent pas dépasser.</p>
                        </div>
                    </div>
                </div>

                <div id='diapers-and-panties'>
                    <div class='row'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/1.png')}}'>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-center">
                            <p>
                                Positionner le voile de protection jetable au fond de la couche.
                            </p>
                        </div>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/2.png')}}'>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/3.png')}}'>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center">
                            <p class="mb-0">Installer la couche classique sur bébé.</p>
                        </div>
                    </div>

                    <div class='row pt-2'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/4.png')}}'>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center">
                            <p>Puis installer la culotte de protection indispensable pour les couches classiques.</p>
                        </div>
                    </div>
                    
                    <div class='row pt-2'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/diapers-and-panties/5.png')}}'>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center">
                            <p>On vérifie autour des cuisses et dans le dos, la couche classique ne doit pas dépasser.<br>
                                Et le biais élastique doit être juste posé sans trop serrer.</p>
                        </div>
                    </div>
                </div>

                <div id='papillon'>
                    <div class='row'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/papillon/1.png')}}'>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-center">
                            <p>
                                Placer la doublure au fond de la couche si besoin (nuit par exemple).
                                Puis positionner le voile de protection jetable au fond de la couche.
                            </p>
                        </div>
                        <div class="col-3">
                            <img class='w-100 h-100' src='{{asset('images/utils/manual/papillon/2.png')}}' style='object-fit:cover'>
                        </div>
                    </div>
                    
                    <div class='row'>
                        <div class="col-3">
                            <img class='w-100 h-100' src='{{asset('images/utils/manual/papillon/3.png')}}' style='object-fit:cover'>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-center">
                            <p>
                                Réglage de la taille suivant le poids de bébé.
                                (A gauche : petit et moyen)
                                (A droite : grand)
                            </p>
                        </div>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/papillon/4.png')}}'>
                        </div>
                    </div>
                    
                    <div class='row'>
                        <div class="col-12 d-flex flex-column justify-content-center">
                            <p class="text-center my-2">
                                On installe la couche sur bébé, on referme, c'est aussi simple que ça !
                            </p>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/papillon/5.png')}}'>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-center">
                            <p>
                                On vérifie autour des cuisses et dans le dos, le voile de protection ne doit pas dépasser.
                            </p>
                        </div>
                        <div class="col-3">
                            <img class='w-100' src='{{asset('images/utils/manual/papillon/6.png')}}'>
                        </div>
                    </div>
        
                    <div class='row'>
                        <div class="col-12 d-flex flex-column justify-content-center">
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
                    <div class="col-4 my-2 my-lg-2">
                        <img class='w-100' src='{{asset('images/utils/manual/Mode-Emploi-Colombine.jpg')}}'>
                    </div>
                    <div class="col-4 my-2 my-lg-2">
                        <img class='w-100' src='{{asset('images/utils/manual/Mode-Emploi-CoucheCulotte.jpg')}}'>
                    </div>
                    <div class="col-4 my-2 my-lg-2">
                        <img class='w-100' src='{{asset('images/utils/manual/Mode-Emploi-Papillon.jpg')}}'>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    {{-- WHY --}}
    <div class="row justify-content-center py-lg-2 m-0">
        <div class="col-12 col-lg-6">

            <h1 class='h2 font-weight-bold mb-3'>Pourquoi les couches lavables ?</h1>

            <div>
                <p class='text-justify'>
                    La réduction des déchets est devenue une priorité dans notre société de consommation.
                    Or les couches jetables représentent un énorme gâchis pour l’environnement ! Bébés Lutins
                    vous propose de réduire les déchets liés aux changes de bébé.
                </p>
            </div>

            <div class='pt-2'>
                <h2 class='h4'>Le saviez vous ?</h2>
                <p class='text-justify'>
                    Pendant les 2 ans et demi en moyenne qu’il faut à un enfant pour acquérir la propreté,
                    les quelques 5000 couches jetées aux ordures ménagères représentent plus d’une tonne de
                    déchets, soit un volume de 30 m3 ! (l’équivalent d’une chambre de bébé). Déchets qui seront
                    incinérés ou enfouis et qui mettront plus de 300 ans pour se décomposer ! Bébés Lutins vous
                    propose des couches saines et confortables pour bébé, confectionnées dans notre atelier.<br>
                    <br>
                    Sachez aussi qu’en utilisant les couches lavables, vous réduisez la consommation d’eau,
                    d’électricité, et de bois. Vous œuvrez ainsi pour le respect de la biodiversité ! Envie
                    de vous y mettre ? Rendez-vous dans notre rubrique « comment s’équiper ».</p>
            </div>
        </div>
    </div>

    {{-- MAINTENANCE --}}
    <div class="row justify-content-center py-lg-2 m-0">
        <div class="col-12 col-lg-6">

            <h1 class='h2 font-weight-bold mb-3'>Entretien des couches lavables</h1>

            {{--  ACTYPOLES THIERS / BEBES LUTINS  --}}
            <div>
                <h2 class='h4'>Avant la première utilisation</h2>
                <p class='text-justify'>
                    Pour un entretien idéal de vos couches lavables, il est recommandé de 
                    les laisser tremper pendant une douzaine d'heures dans de l'eau froide afin de faire gonfler
                    les fibres, de bien les débarrasser de l’apprêt de tissage et les rendre plus absorbantes.
                    Ne vous inquiétez pas si des traces de couleurs apparaissent, nous dessinons nos patrons avec
                    des feutres non toxiques et lavables, dès le premier lavage tout sera parti.<br>
                    <br>
                    Il faut savoir qu’elles n’atteindront leur absorption maximale qu’après une dizaine de
                    lavages (comme c’est le cas pour les serviettes de bain par exemple). Il est donc conseillé
                    de laver 2 fois vos couches avant leur première utilisation et de changer votre enfant un
                    peu plus fréquemment au début.</p>
            </div>

            <div class='pt-2'>
                <h2 class='h4'>Stockage des couches souillées</h2>
                <p class='text-justify'>
                    <b>« Stockage à sec »</b> c'est-à-dire : Après utilisation, les couches seront stockées
                    dans un seau, sans eau, avec un couvercle.<br>
                    Vous pouvez pulvériser notre « spray Néobulle » spécial couches, directement dans le seau
                    ou sur la couche, les huiles essentielles sont diluées et donc sans danger pour la peau.
                    Attention à ne pas stocker vos couches au-delà de 3 jours au risque de les détériorer.<br>
                    Les huiles essentielles ont des propriétés désinfectantes et désodorisantes.<br>
                    Vous pouvez disposer un filet pour récupérer aisément les couches souillées avant de les
                    mettre dans le lave-linge.
                </p>
            </div>

            <div class='pt-2'>
                <h2 class='h4'>Les selles</h2>
                <p class='text-justify'>
                    Il existe des voiles non-tissés spécifiques, permettant de « récupérer » les selles.<br>
                    Vous en trouverez deux sortes :<br>
                    <ul>
                        <li>Le voile épais (en rouleau) qui est conseillé pour les selles molles des bébés allaités.</li>
                        <li>Le voile fin (en boîte) lorsque les selles sont plus compactes.</li>
                    </ul>
                    Ces deux voiles papiers peuvent être lavés au moins 3 fois avec vos couches s’ils sont juste
                    mouillés. Attention risque de passage dans le filtre sur certaines machines, n’hésitez pas à
                    les glisser dans un filet ! Sur les boites il est indiqué que l’on peut les jeter directement
                    dans les toilettes, surtout ne pas le faire pour les fosses septique ! Évitez de le faire trop
                    souvent pour le « tout à l’égout », notamment si les canalisations sont étroites, et préférez
                    la poubelle s’ils sont justes mouillés.<br>
                    Sachez aussi que si vous utilisez des voiles « micro-polaire » qui procurent un effet « bébé au sec »,
                    les selles adhèrent peu et il suffit souvent de secouer le voile au-dessus des toilettes avant de le
                    passer au lavage-linge. Cela convient bien lorsque bébé à des selles compactes.<br>
                </p>
            </div>

            <div class='pt-2'>
                <h2 class='h4'>Le lavage</h2>
                <p class='text-justify'>
                        Vous pouvez <strong>laver les couches et culottes de 40°C à 60°C</strong> sans souci, mais préférez un lavage régulier
                        à 40°C <b>pour les culottes de protection</b>. Les couches classiques, les enveloppes des « tout en un »
                        et parties absorbantes peuvent quant à elles passer à 60°C régulièrement sans souci.<br>
                        <strong>Il ne faut absolument pas utiliser d’adoucissant</strong>, il imperméabilise les couches rapidement et cela
                        engendre rapidement des fuites.<br>
                        De même, <strong>évitez les lessives grasses</strong> (lessives à base de savon de Marseille qui contiennent de la glycérine)
                        elles saturent les couches et les rendent inefficaces.<br>
                        Nous déconseillons les huiles essentielles dans la machine à laver, qui risquent de détériorer les fibres.<br>
                        Il est conseillé d’utiliser des produits d’entretien doux, pour préserver les fesses de bébé ainsi que vos
                        couches (on trouve des lessives sans allergènes et sans phosphates).<br>
                        Nous conseillons vivement <strong>les lessives en poudre</strong>, ce sont celles qui se rincent le mieux tout en restant les
                        plus efficaces pour l’entretien des couches lavables.<br>
                        Assurez-vous que vos couches soient toujours bien rincées, n’hésitez pas à laver en cycle coton pour éliminer
                        tous résidus de lessive.<br>
                        Les couches classiques ainsi que les pans absorbants des TE1 peuvent passer au sèche-linge sur un cycle délicat.<br>
                        Les culottes en PUL (celles concernant le système couche + culotte de protection) n’ont pas besoin d’être lavées
                        à chaque change. Il suffit de les aérer, c’est pourquoi il est conseillé d’en avoir au moins 3 par taille 
                        pour tourner sans souci. Vous pouvez les laver à 40° (60° maximum de temps en temps).<br>
                        <br>
                        <em>Rappel : L’utilisation du sèche-linge est déconseillée pour toutes les parties imperméables, utilisez
                            le cycle délicat si vous passez les éléments absorbants.</em>
                </p>
            </div>
        </div>
    </div>

    {{-- HOW --}}
    <div class="row justify-content-center py-lg-2 m-0">
        <div class="col-12 col-lg-6">

            <h1 class='h2 font-weight-bold mb-3'>Comment s'équiper ?</h1>

            <div>
                <h2 class='h4'>Les couches Bébés Lutins</h2>
                <p class='text-justify'>
                    Bébés Lutins vous propose des couches lavables modernes et pratiques !
                    Elastiquées à la taille et aux cuisses, fermeture à pressions, les couches
                    lavables Bébés Lutins s’adaptent à la morphologie de bébé. Si certaines couches
                    classiques s’utilisent avec une culotte de protection souple et imperméable,
                    d’autres intégrales « tout en un » sont complètes et se rapprochent de la
                    facilité d’utilisation de couches jetables.
                </p>
            </div>

            <div class='pt-2'>
                <h2 class='h4'>Combien de couches lavables ?</h2>
                <p class='text-justify'>
                    Bébés Lutins vous conseille entre <strong>15 et 20 couches lavables</strong> pour un bon
                    roulement avec des machines tous les 2-3 jours.<br>
                    Si vous vous équipez avec des couches classiques nécessitant une culotte de protection,
                    comptez au moins 3 culottes par taille. Celles-ci ne se lavent pas à chaque fois.<br>
                    <br>
                    <em>N’hésitez pas à consulter nos lots pour vous donner une idée.</em>
                </p>
            </div>

            <div class='pt-2'>
                <h2 class='h4'>Question budget ?</h2>
                <p class='text-justify'>
                        En plus de réduire vos déchets, vous réduisez vos dépenses !<br>
                        S’équiper pour tourner au quotidien en couches lavables vous coûtera entre 
                        400 et 600 € suivant vos choix.<br>
                        Pour information, les couches jetables que bébé utilisera jusqu’à sa propreté 
                        vous coûteront en moyenne 1500 € !<br>
                        Alors même en comptant 300 € d’entretien, lessive, eau, électricité, voiles de 
                        protection, vous réduisez tout de même d’un tiers voir de moitié votre budget !
                        Et bien entendu, pour un deuxième bébé vous économisez encore plus !<br>
                        <br>
                        <em>Pensez aussi « lingettes lavables » ! Pratiques, douces et souples elles se lavent facilement avec le reste de votre linge.</em>
                </p>
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