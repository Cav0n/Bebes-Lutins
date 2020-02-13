<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 30/11/2018
 * Time: 08:42
 */

$shipping_price = number_format(UtilsGateway::getShippingPrice(), 2,","," ");
$free_shipping_price = number_format(UtilsGateway::getFreeShippingPrice(), 2,","," ");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Livraison et frais de port - Bebes Lutins</title>
    <meta name="description" content="Retrouvez ici les informations à connaitre concernant nos délais de livraison ainsi que le montant des frais de port."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>

    <div id="static-container">
        <h1>Livraison et frais de port</h1>
        <div class="static-bloc">
            <div class="static-bloc-inner">
            <h2>Frais de port et d'emballage</h2>
            <p>Les colis seront envoyés en « colissimo » ou « colissimo recommandé » par la poste. Les frais de port s’élèvent à <?php echo $shipping_price;?> euros TTC et sont offerts à partir de <?php echo $free_shipping_price;?> euros d’achat TTC (toutes taxes comprises).<BR>
                <BR>
                <em>Nous contacter pour des envois hors France métropolitaine.</em></p>
            </div>
            <div class="static-bloc-inner">
            <h2>Délais de livraison</h2>
            <p>Délais de livraison de plus ou moins 1 semaine. Les livraisons sont effectuées en France métropolitaine. Bébés Lutins n’est, en aucun cas tenu responsable des retards, pertes ou dégâts occasionnés lors du transport.<BR>
                <BR>
                <em>Les délais de livraison ne sont donnés qu'à titre indicatif.</em></p>
            </div>
            <div class="static-bloc-inner">
            <h2>Retrait gratuit à l'atelier</h2>
            <p>Prendre contact avec l'équipe Bébés Lutins pour finaliser votre commande si vous souhaitez retirer votre commande directement à l'atelier.
                Vous pouvez nous contacter de différentes manières en cliquant <a href="">ici.</a></p>
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