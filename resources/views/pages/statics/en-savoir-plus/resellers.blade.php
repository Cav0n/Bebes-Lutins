@extends('templates.template')

@section('title', 'Nos revendeurs - Bébés Lutins')

@section('content')
<div class="row justify-content-center py-lg-5 m-0">
    <div class="col-12 col-lg-6">

        <h1 class='h2 font-weight-bold mb-3'>Nos revendeurs</h1>

        <div>
            <h2 class='h4'>Rebelle de Nature</h2>
            <p class='text-justify mb-0'>
                Hotel d'entreprise<br>
                Place Michel Paulus - Écosite du Val de Drôme<br>
                26400 Eurre
            </p>
            <a name="rebelle-button" id="rebelle-button" class="btn btn-outline-dark py-1 my-1" href="https://www.rebelledenature.com/" role="button">
                Site web</a>
        </div>

        <div class='pt-2'>
            <h2 class='h4'>Lieu'topie</h2>
            <p class='text-justify mb-0'>
                21 Rue Kessler<br>
                63000 Clermont-Ferrand<br>
                <i>Achats réservés aux étudiants.</i>
            </p>
            <a name="lieutopie-button" id="lieutopie-button" class="btn btn-outline-dark py-1 my-1" href="https://www.lieutopie-clermont.org/" role="button">
                Site web</a>
        </div>

        <div class='pt-2'>
            <h2 class='h4'>L'Ingrédient</h2>
            <p class='text-justify mb-0'>
                8 rue Burnol<br>
                03200 Vichy
            </p>
            <a name="lingredient-button" id="lingredient-button" class="btn btn-outline-dark py-1 my-1" href="https://www.facebook.com/lingredient03/" role="button">
                Page facebook</a>
        </div>
    </div>
</div>
@endsection