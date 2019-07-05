<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:46
 */

$user = UserGateway::GetUserByUserID($_GET['user_id']);
$surname = $user->getSurname();
$firstname = $user->getFirstname();
$mail = strtolower($user->getMail());
if ($user->getPhone() != null) $phone = $user->getPhone(); else $phone = "Non indiqué";
$registration_date = $user->getRegistrationDateString();

$address_list = UserGateway::GetAllAddress($user);
$shipping_address_list = $address_list['shipping'];
$shipping_address_display = "";
foreach ($shipping_address_list as $shipping_address){
    $shipping_address = (new AddressContainer($shipping_address))->getAddress();
    $identity = $shipping_address->getCivilityString() ." ". $shipping_address->getFirstname() ." ". $shipping_address->getSurname();
    if($shipping_address->getCompany() != null) $company = $shipping_address->getCompany(); else $company = "";
    $street = $shipping_address->getAddressLine();
    if($shipping_address->getComplement() != null) $complement = $shipping_address->getComplement(); else $complement = "";
    $postal_code = $shipping_address->getPostalCode();
    $city = $shipping_address->getCity();

    $shipping_address_display = $shipping_address_display . "
    <div class='address'>
        <p>$identity</p>
        <p>$company</p>
        <p>$street</p>
        <p>$complement</p>
        <p>$postal_code</p>
        <p>$city</p>
    </div>
    ";
}

if($shipping_address_display == "") $shipping_address_display = "<p>Aucune adresse de livraison n'a été entré par cet utilisateur.</p>";

$billing_address_list = $address_list['billing'];
$billing_address_display = "";
foreach ($billing_address_list as $billing_address){
    $billing_address = (new AddressContainer($billing_address))->getAddress();
    $identity = $billing_address->getCivilityString() ." ". $billing_address->getFirstname() ." ". $billing_address->getSurname();
    if($billing_address->getCompany() != null) $company = $billing_address->getCompany(); else $company = "";
    $street = $billing_address->getAddressLine();
    if($billing_address->getComplement() != null) $complement = $billing_address->getComplement(); else $complement = "";
    $postal_code = $billing_address->getPostalCode();
    $city = $billing_address->getCity();

    $billing_address_display = $billing_address_display . "
    <div class='address'>
        <p>$identity</p>
        <p>$company</p>
        <p>$street</p>
        <p>$complement</p>
        <p>$postal_code</p>
        <p>$city</p>
    </div>";
}
if($billing_address_display == "") $billing_address_display = "<p>Aucune adresse de facturation n'a été entré par cet utilisateur.</p>";

$order_list = UserGateway::GetOrders($user);

$orders_display = "";
foreach ($order_list as $order){
    $order = (new OrderContainer($order))->getOrder();
    $order_id = $order->getId();
    $order_status = ucfirst($order->statusToString()) . ".";
    $order_date = $order->getDateString();
    $order_payment_method = $order->getPaymentMethodString();
    $order_shipping_price = $order->getShippingPrice();
    $order_shipping_price_string = str_replace("EUR","€", money_format("%.2i", $order_shipping_price));
    $order_price = $order->getTotalPrice();
    $order_price_string = str_replace("EUR","€", money_format("%.2i", $order_price));
    $order_total_price = $order_shipping_price + $order_price;
    $order_total_price_string = str_replace("EUR", "€", money_format("%.2i", $order_total_price));
    $order_shipping_address = $order->getShippingAddress();
    $order_billing_address = $order->getBillingAddress();

    $orders_display = $orders_display . " 
    <div class='order'>
        <p>Commande passée le : $order_date</p>
        <p>$order_status</p>
        <p>Prix : $order_total_price_string (frais de port : $order_shipping_price_string)</p>
        <p>Payé par : $order_payment_method</p>
        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'><b>Afficher la facture</b></a>
    </div>
    ";
}
if($orders_display == "") $orders_display = "L'utilisateur n'a encore jamais passé de commandes.";

?>

<!DOCTYPE html>
<html style="background: #3b3f4d;">
<head>
    <title>Fiche client - BEBES LUTINS</title>
    <meta name="description" content="Un récapitulatif de toutes les informations du client."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="user">

<header>
    <h1><?php echo $firstname. " " .$surname;?></h1>
    <p>Adresse e-mail : <?php echo $mail; ?></p>
    <p>Numéro de téléphone : <?php echo $phone; ?></p>
    <p>Inscrit depuis le : <?php echo $registration_date;?></p>
</header>
<main>
    <div id="address-list-container">
        <h2>Adresses</h2>
        <div id="address-list" class="horizontal">
            <div class="shipping vertical address-inner">
                <h3>Livraison</h3>
                <?php echo $shipping_address_display;?>
            </div>
            <div class="billing vertical address-inner">
                <h3>Facturation</h3>
                <?php echo $billing_address_display;?>
            </div>
        </div>
    </div>
    <div id="orders-list-container">
        <h2>Commandes</h2>
        <div id="orders-list" class="horizontal wrap">
            <?php echo $orders_display;?>
        </div>

    </div>
</main>
</body>
</html>
