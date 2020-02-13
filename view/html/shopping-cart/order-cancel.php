<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 04/12/2018
 * Time: 09:02
 */
?>

<!DOCTYPE html>
<html>
<head>
    <title>Paiement annulee - Bebes Lutins</title>
    <meta name="description" content="Vous venez d'annuler votre paiement par carte bancaire."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>

<main>
    <div id="payment-wrapper" class="horizontal centered">
        <h1>Paiement annulé</h1>
        <p>Vous venez d'annuler votre paiement par carte bancaire, néanmoins si jamais il s'agit d'une erreur votre panier est toujours là.</p>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
<script>

</script>
</html>