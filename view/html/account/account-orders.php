<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 2019-03-20
 * Time: 13:20
 */

$user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();

$firstname = $user->getFirstname();
$surname = $user->getSurname();
$mail = $user->getMail();
$phone_number = $user->getPhone();

$orders_list = OrderGateway::GetOrdersOfCustomer($user->getId());

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mes commandes - Bebes Lutins</title>
    <meta name="description" content="Accedez a vos commandes pour connaitre leurs status."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main class="vertical">
    <div id="customer-area2" class="vertical">
        <div id="customer-area-header" class="vertical">
            <div id="hello" class="vertical">
                <h2>Bonjour <?php echo $firstname;?></h2>
                <p>Bienvenue dans votre espace</p>
            </div>
            <div id="customer-area-tabs" class="horizontal">
                <a href="https://www.bebes-lutins.fr/espace-client">Mon profil</a>
                <a href="#" class="selected">Mes commandes</a>
                <a href="https://www.bebes-lutins.fr/espace-client/adresses">Mes adresses</a>
            </div>
        </div>
        <div id="customer-area-inner" class="vertical">
            <?php if(!empty($orders_list)) {?>
            <div class="orders-container">
                <H3>MES COMMANDES</H3>
                <div class="orders">
                <?php foreach ($orders_list as $order){
                    $order = (new OrderContainer($order))->getOrder();

                    $order_id = $order->getId();
                    $order_date = date_format(DateTime::createFromFormat('Y-m-d H:i:s', $order->getDate()), 'd - m - Y à H:i');
                    $order_status = $order->statusToString();
                    $order_total_price = UtilsModel::FloatToPrice($order->getTotalPrice() + $order->getShippingPrice());
                    $order_admin_message = $order->getAdminMessage();
                    if($order->getShippingPrice() > 0) $order_total_price = $order_total_price . " (Dont " . UtilsModel::FloatToPrice($order->getShippingPrice()) . " de frais de livraison)";
                    ?>
                    <div class="order horizontal">
                        <div class="order-summary">
                            <p>Commande passée le <?php echo $order_date; ?></p>
                            <p>Status de la commande : <?php echo $order_status; ?></p>
                            <p>Prix total : <?php echo $order_total_price; ?></p>
                        </div>
                        <div class="order-link vertical centered">
                            <a target="_blank" rel="noopener noreferrer" href="https://www.bebes-lutins.fr/espace-client/facture/<?php echo $order_id; ?>">Afficher le détail de la commande</a>
                        </div>
                    </div>
                    <?php if($order_admin_message != null){ ?>
                        <div class="order-message vertical">
                            <p>Message de la part de l'équipe Bébés Lutins :</p>
                            <p><?php echo $order_admin_message; ?></p>
                        </div>
                    <?php } ?>
                <?php } ?>
                </div>
            </div>
            <?php } else { ?>
            <div class="no-orders horizontal centered">
                <p>Vous n'avez pour l'instant passé aucune commandes.</p>
            </div>
            <?php }?>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
</html>