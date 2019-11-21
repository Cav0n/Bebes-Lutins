@extends('templates.template')

@section('title', 'Paiement - Bébés Lutins')

@section('content')
<div class="row justify-content-center py-lg-5 m-0">
    <div class="col-12 col-lg-6">

        <h1 class='h2 font-weight-bold mb-3'>Paiement</h1>

        {{--  ACTYPOLES THIERS / BEBES LUTINS  --}}
        <div>
            <h2 class='h4'>Moyens de paiements</h2>
            <p class='text-justify'>
                Le paiement est exigible immédiatement à la commande, il peut s'effectuer par :
            </p>
            <h3 class='h5'>
                Carte bancaire
            </h3>
            <p class='text-justify'>
                Votre espace de paiement pour effectuer votre transaction sur www.bebes-lutins.fr sera sous 
                l'intitulé CITELIS.<br>
                BEBES LUTINS vous garantit un paiement en toute sécurité.<br>
                Les paiements sont réalisés par le biais du système sécurisé CITELIS qui utilise le protocole 
                TLS de telle sorte que les informations transmises sont cryptées par un logiciel et qu'aucun 
                tiers ne peut en prendre connaissance au cours du transport sur le réseau. Le compte de l'acheteur 
                sera débité après validation de la commande au tarif des produits commandés. Le Client autorise la 
                société ACTYPOLES / BEBES LUTINS à débiter sa carte du montant relatif au prix indiqué, en communiquant 
                ses informations bancaires lors de la vente. Le Client confirme qu’il est bien le titulaire légal 
                de la carte à débiter et qu’il est légalement en droit d’en faire usage.<br>
                <br>
                <i>En cas d’erreur, ou d’impossibilité de débiter la carte, la vente est annulée ainsi que la commande.</i><br>
            </p>
            <h3 class='h5'>
                Chèque bancaire
            </h3>
            <p class='text-justify'>
                Le paiement par chèque bancaire n'est possible que pour des chèques en euros tirés sur une banque 
                domiciliée en France. Attention : en choisissant de payer par chèque, la commande ne sera traitée 
                qu'après encaissement de celui-ci et les délais ne débuteront qu'à partir de ce moment.<br>
                Le chèque devra être établi à l'ordre : ACTYPOLES-THIERS<br>
                Et envoyer à : Bébés Lutins, Rue du 19 mars 1962, 63300 THIERS<br>
                <br>
                <i>Dans le cas où vous seriez en retard dans le paiement de la commande, nous serions en droit de procéder 
                à l'annulation de la commande passé un délai de 15 jours après la confirmation de commande envoyée au client,
                sauf entente préalable.</i><br>
            </p>
            <h3 class='h5'>
                PayPal et/ou PayLib
            </h3>
            <p class='text-justify'>
                Le Client est redirigé sur le site de PayPal à la fin de sa commande. Il se connecte avec ses identifiants de 
                compte PayPal et confirme le paiement. Le paiement est alors enregistré dans le système de PayPal, et la commande 
                est traitée. Lors d'un paiement par PayPal, le montant total dû sera encaissé juste après l'ordre de commande.<br>
                <br>
                Note : <i>Dans tous les cas possible de paiement, Bébés Lutins se réserve le droit de refuser d'effectuer une 
                livraison ou d'honorer une commande émanant d'un consommateur qui n'aurait pas réglé totalement ou partiellement
                une commande précédente ou avec lequel un litige de paiement serait en cours d'administration. BEBES LUTINS se 
                réserve le droit d’inscrire les coordonnées associées au litige dans un fichier correspondant aux incidents de 
                paiements.</i>
            </p>
        </div>

        <div class='pt-2'>
            <h2 class='h4'>Prix</h2>
            <p class='text-justify'>
                Les prix sont indiqués en Euro (€) sur le site <a href='https://www.bebes-lutins.fr'>www.bebes-lutins.fr</a> et 
                s’entendent T.T.C. (toutes taxes comprises, y compris la T.V.A. au taux applicable au jour de la commande). Les prix
                sont toujours entendus hors frais de livraison ; le client est informé du montant des frais de livraison lors de la 
                passation de la commande. BEBES LUTINS se réserve le droit de modifier ses prix à tout moment mais les produits seront
                facturés sur la base des tarifs en vigueur au moment de votre validation de commande.<br>
                <br>
                <em>Nous contacter pour une expédition hors France métropolitaine</em>
            </p>
        </div>
    </div>
</div>
@endsection