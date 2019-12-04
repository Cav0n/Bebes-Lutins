@extends('templates.dashboard')

@section('content')
<div class="row p-4">
    <div class="col-12">
        <h1 class='h4 m-0 font-weight-normal'>
            Notes de mise à jour
        </h1>
        <div class='update-infos-container py-2'>
            <h2 class="h6">Mise à jour 5.0.3</h2>
            <ul>
                <li>La quantité dans le récapitulatif de commande s'affiche désormais avant le prix unitaire de chaque produits</li>
                <li>Lorsque l'on clique sur une image dans les manuels d'utilisation elles s'ouvrent en grand dans un nouvel onglet</li>
                <li>Changement dans l'entete du site sur mobile :</li>
                <li>Le bouton de déconnexion dans l'espace client affiche une roue de chargement lorsque l'on clique dessus.</li>
                <li>Ajout des caractéristiques simplifiées dans le panier ("Nom du produit " - "caractéristique"...)</li>
                <li>Ajout des caractéristiques simplifiées dans le résumé de commande ("Nom du produit " - "option" - "caractéristique"...)</li>
                <li>Ajout d'un message d'aide personnalisé sur la page du produit pour chaque caractéristiques (en rouge)</li>
                <li>Ajout des miniatures sur la fiche produit sur mobile et tablette</li>
                <li>Correction des dates (commentaires des produits, affichage des commandes)</li>
                <br>
                <li>Modification de l'en-tête du site (header) sur mobile :
                    <ul>
                        <li>Correction du lien "A propos", renommé en "Qui sommes nous" et redirige vers la bonne page</li>
                        <li>Ajout du lien "Guide et conseils"</li>
                        <li>Lorsque l'utilisateur est connecté, le lien "Se connecter" devient "Mon compte" et un bouton de déconnexion apparait</li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class='update-infos-container py-2'>
            <h2 class="h6">Mise à jour 5.0.2.1</h2>
            <ul>
                <li>Ajout de la première catégorie parente dans le fil d'ariane de la page de produit</li>
                <li>Ajout d'un popup qui affiche l'image du produit en grand lorsque l'on clique dessus (dans la page de produit)</li>
                <li>Création de l'identifiant d'une catégorie lors de sa création</li>
                <li>Correction d'un bug qui rendait illisible le changement de statut d'une commande</li>
            </ul>
        </div>
        <div class='update-infos-container py-2'>
            <h2 class="h6">Mise à jour 5.0.2</h2>
            <ul>
                <li>Ajout du champ "téléphone" dans le formulaire de création de compte</li>
                <li>Ajout d'une fonctionnalité permettant de verrouiller le bouton "Créer mon compte" lorsque tous les champs requis ne sont pas remplis</li>
                <li>Ajout du message du client dans la facture</li>
                <li>Ajout de l'affichage des codes promos dans la facture des commandes</li>
                <li>Correctiond des barres de recherche dans le tableau d'administration pour ne rien afficher</li>
                <li>Correction des codes promos offrant la livraison gratuite</li>
                <li>Correction du lien de partage de panier</li>
                <li>Correction d'un bug permettant d'accéder à la page de paiement sans choisir de livraison</li>
                <li>Correction des commandes dans l'espace client pour prendre en compte les produits plus disponibles sur le site</li>
                <li>Le nom des produits dans les factures sont écrits en plus gros</li>
                <li>Lors de la selection "Retrait à l'atelier" les informations de contact du client se complètent automatiquement</li>
                <li>Les clients peuvent ecrire un message concernant leur commande à n'importe quel étape de leur commande</li>
                <li>Suppression des "placeholder" dans le formulaire de création de compte</li>
            </ul>
        </div>
        <div class='update-infos-container py-2'>
            <h2 class="h6">Mise à jour 5.0.1</h2>
            <ul>
                <li>Ajout du bouton permettant d'afficher la liste des catégories lors de la création / mis à jour d'un produit</li>
                <li>Ajout d'un outil d'importation des informations d'un produit lors de la création d'un produit</li>
                <li>Ajout de l'API de CITELIS pour effectuer les paiements par carte bancaire</li>
                <li>Ajout de <a href='https://support.google.com/recaptcha/?hl=fr'>reCAPTCHA v2</a> sur la page de contact pour éviter les spams</li>
                <li>Ajout de la liste d'envie</li>
                <li>Ajout d'un bouton pour annuler la recherche dans le tableau de bord</li>
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