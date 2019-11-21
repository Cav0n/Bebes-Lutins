@extends('templates.template')

@section('title', 'Livraison et frais de port - Bébés Lutins')

@section('content')
<div class="row justify-content-center py-lg-5 m-0">
    <div class="col-12 col-lg-6">

        <h1 class='h2 font-weight-bold mb-3'>Livraison et frais de port</h1>

        {{--  ACTYPOLES THIERS / BEBES LUTINS  --}}
        <div>
            <h2 class='h4'>Frais de port et d'emballage</h2>
            <p class='text-justify'>Les colis seront envoyés en « colissimo » ou « colissimo recommandé » par la poste. Les frais 
                de port s’élèvent à 5,90 euros TTC et sont offerts à partir de 70,00 euros d’achat TTC (toutes 
                taxes comprises).<br>
                <br>
                <em>Nous contacter pour des envois hors France métropolitaine.</em></p>
        </div>

        <div class='pt-2'>
            <h2 class='h4'>Délais de livraison</h2>
            <p class='text-justify'>Délais de livraison de plus ou moins 1 semaine. Les livraisons sont effectuées en France 
                métropolitaine. Bébés Lutins n’est, en aucun cas tenu responsable des retards, pertes ou dégâts
                occasionnés lors du transport.<br>
                <br>
                <em>Les délais de livraison ne sont donnés qu'à titre indicatif.</em></p>
        </div>

        <div class='pt-2'>
            <h2 class='h4'>Retrait gratuit à l'atelier</h2>
            <p class='text-justify'>Prendre contact avec l'équipe Bébés Lutins pour finaliser votre commande si vous souhaitez 
                retirer votre commande directement à l'atelier. Vous pouvez nous contacter de différentes manières en cliquant 
                <a href='/contact'>ici</a>.</p>
        </div>
    </div>
</div>
@endsection