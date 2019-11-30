@extends('templates.dashboard')

@section('content')
<div class="row p-4">
    <div class="col-12">
        <h1 class='h4 m-0 font-weight-normal'>
            Notes de mise à jour
        </h1>
        <div class='update-infos-container py-2'>
            <h2 class="h6">Mise à jour 5.0.1</h2>
            <ul>
                <li>Ajout du bouton permettant d'afficher la liste des catégories lors de la création / mis à jour d'un produit</li>
                <li>Ajout d'un outil d'importation des informations d'un produit lors de la création d'un produit</li>
                <li>Ajout de l'API de CITELIS pour effectuer les paiements par carte bancaire</li>
                <li>Ajout de <a href='https://support.google.com/recaptcha/?hl=fr'>reCAPTCHA v2</a> sur la page de contact pour éviter les spams</li>
                <li>Ajout de la liste d'envie</li>
                <li>Correction des liens "MON PANIER" et "CONTACT" pour rendre tout le bloc cliquable</li>
                <li>Correction du bug qui ajouté toujours une quantité de 1 lors de l'ajout dans le panier</li>
                <li>Correction du bug qui empechait d'avoir la livraison gratuite lors du choix de livraison "Retrait à l'atelier"</li>
            </ul>
        </div>
        <div class='update-infos-container py-2'>
            <h2 class="h6">Mise à jour 5.0.0</h2>
            <ul>
                <li><b>Refonte complète avec Laravel et Bootstrap</b></li>
                <li>Adaptation aux mobiles du tableau de bord</li>
                <li>Ajout d’un outil d’analyse du chiffre d’affaire</li>
                <li>Ajout facilité de dates dans la création de coupons de réductions</li>
                <li>Ajout d’une multitude de feedbacks (chargements dans boutons)</li>
                <li>Stockage du panier dans le cache + dans la base de données</li>
                <li>Meilleur gestion des images des produits (image principale et vignettes)</li>
                <li>Paginations des produits pour des chargements plus courts et recherche à l’aide de requêtes AJAX</li>
                <li>Amélioration du popup de changement d'état d'une commande</li>
                <li>Amélioration du popup d'ajout au panier</li>
            </ul>
        </div>
    </div>
</div>


@endsection