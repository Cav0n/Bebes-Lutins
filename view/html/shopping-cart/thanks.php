<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 22:10
 */

?>

<!DOCTYPE html>
<html>
<head>
    <title>Merci - Bebes Lutins</title>
    <meta name="description" content="Toute l'équipe de Bébés Lutins vous remercie pour votre commande, nous la préparons au plus vite."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>

<main id='shopping-cart-main'>
    <div id="payment-wrapper" class="vertical">
        <div id="checkout-stepper-wrapper">
            <ul class="checkout-stepper horizontal">
                <li class="checkout-step checkout-step-current">
                    <div class="checkout-step-inner vertical">
                        <span class="checkout-step-number">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="checkout-step-name">
                            Panier
                        </span>
                    </div>
                </li>
                <li class="checkout-step checkout-step-current">
                    <div class="checkout-step-inner vertical">
                        <span class="checkout-step-number">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="checkout-step-name">
                            Livraison
                        </span>
                    </div>
                </li>
                <li class="checkout-step checkout-step-current">
                    <div class="checkout-step-inner vertical">
                        <span class="checkout-step-number">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="checkout-step-name">
                            Paiement
                        </span>
                    </div>
                </li>
            </ul>
        </div>

        <div id="payment-inner" class="desktop vertical centered">
            <div class="thanks-header horizontal centered">
                <div class="thanks-checksign vertical centered">
                    <i class="fas fa-check fa-3x"></i>
                </div>
                <div class="thanks-message">
                    <h2>Merci pour votre commande. </h2>
                    <p>Retrouvez le suivi de votre commande dans votre espace "mon compte", rubrique "voir mes commandes". </p>
                </div>
            </div>
            <div id="thanks-image" class="horizontal centered">
                <img src="https://www.bebes-lutins.fr/view/assets/images/utils/malouflyer.png">
                <span id="thanks-text-image" class="transition-medium">Merci<?php if(isset($_SESSION['user'])) echo $user->GetPrenom() . " " . $user->GetNom(); ?>.</span>
            </div>
        </div>

        <div id="payment-inner-mobile" class="mobile vertical">
            <div class="thanks-header horizontal">
                <div class="thanks-checksign vertical centered">
                    <i class="fas fa-check fa-3x"></i>
                </div>
                <div class="thanks-message vertical">
                    <h2>Merci pour votre commande. </h2>
                    <p>Retrouvez le suivi de votre commande dans votre espace "mon compte", rubrique "voir mes commandes". </p>
                </div>
            </div>
            <div class="thanks-image">
                <img src="https://www.bebes-lutins.fr/view/assets/images/utils/malouflyer.png">
            </div>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
<script>

</script>
</html>
