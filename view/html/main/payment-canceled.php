<?php

if($_REQUEST['order_id'] != null) {
    $order = OrderGateway::GetOrderFromDBByID2($_REQUEST['order_id']);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Paiement annulé - Bebes Lutins</title>
    <meta name="description" content="Une erreur est survenue lors du paiement de votre commande."/>
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
                            <i class="fas fa-times fa"></i>
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
                <div class="error-checksign vertical centered" style='color:red'>
                    <i class="far fa-times-circle fa-3x"></i>
                </div>
                <div class="thanks-message">
                    <h2>Votre commande a été annulé. </h2>
                    <p>Vous avez annulez le paiement de votre commande, de ce fait vous ne serez pas débité.</p>
                </div>
            </div>
        </div>

        <div id="payment-inner-mobile" class="mobile vertical">
            <div class="thanks-header horizontal">
                <div class="error-checksign vertical centered" style='color:red'>
                    <i class="far fa-times-circle fa-3x"></i>
                </div>
                <div class="thanks-message">
                    <h2>Votre commande a été annulé. </h2>
                    <p>Vous avez annulez le paiement de votre commande, de ce fait vous ne serez pas débité.</p>
                </div>
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
