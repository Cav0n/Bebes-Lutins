<?php

if($_SESSION['order_id'] != null) {
    $order = OrderGateway::GetOrderFromDBByID2($_SESSION['order_id']);
    unset($_SESSION['order_id']);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Erreur - Bebes Lutins</title>
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
                    <h2>Une erreur est survenue lors du paiement. </h2>
                    <p>Il nous est impossible de procéder au paiement de votre commande.<BR>Votre commande a été annulée, vous ne serez pas débité.</p>
                </div>
            </div>
        </div>

        <div id="payment-inner-mobile" class="mobile vertical">
            <div class="thanks-header horizontal">
                <div class="error-checksign vertical centered" style='color:red'>
                    <i class="far fa-times-circle fa-3x"></i>
                </div>
                <div class="thanks-message">
                    <h2>Une erreur est survenue lors du paiement. </h2>
                    <p>Il nous est impossible de procéder au paiement de votre commande.<BR>Votre commande a été annulée, vous ne serez pas débité.</p>
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
