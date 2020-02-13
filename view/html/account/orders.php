<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:38
 */

$user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
$orders_list = UserGateway::GetOrders($user)

?>
<!DOCTYPE html>
<html>
<head>
    <title>Espace client - Mes commandes - Bebes Lutins</title>
    <meta name="description" content="Vos commandes passées sur Bébés Lutins."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <div id="user-orders-mobile" class="mobile vertical">
        <a href="https://www.bebes-lutins.fr/espace-client"><H1>< Mon compte</H1></a>
        <div class="orders">
            <H2>Mes commandes</H2>
            <?php foreach ($orders_list as $order){
                $order = (new OrderContainer($order))->getOrder();?>
                <div class="order">
                    <div class="head">
                        <div class="date-and-price horizontal">
                            <p><?php echo $order->getDateString();?></p>
                            <p><?php echo UtilsModel::FloatToPrice( $order->getPriceAfterDiscount());?></p>
                        </div>
                        <div>
                            <p><?php echo $order->getPaymentMethodString();?></p>
                        </div>
                    </div>
                    <div class="status" style="background-color: <?php echo UtilsModel::StatusToColor($order->getStatus());?>">
                        <p><?php echo UtilsModel::order_status_to_string($order->getStatus());?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
</html>