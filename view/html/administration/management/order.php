<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:55
 */

/* Order */
$order = OrderGateway::GetOrderFromDBByID($_GET['order_id']);
$order_price = $order->getTotalPrice();
$order_shipping_price = $order->getShippingPrice();
$order_total_price = str_replace("EUR","€",money_format("%.2i",$order_price + $order_shipping_price));
$order_price = str_replace("EUR","€",money_format("%.2i", $order_price));
$order_shipping_price = str_replace("EUR","€",money_format("%.2i", $order_shipping_price));
$order_payment_method = $order->getPaymentMethodString();
$order_date = $order->getDateString();
$order_birthlist_id = $order->getBirthlistID();

/* Order items */
$order_items = $order->getOrderItems();

/* User */
$user = $order->getCustomer();
$user_firstname = $user->getFirstname();
$user_surname = $user->getSurname();
$user_phone = $user->getPhone();
$user_email = strtolower($user->getMail());

/* Shipping address */
$shipping_address = $order->getShippingAddress();
$shipping_address_id = $shipping_address->getId();
$shipping_address_company = $shipping_address->getCompany();
$shipping_address_identity = $shipping_address->getCivilityString() . " " . ucfirst($shipping_address->getFirstname()) . " " . strtoupper($shipping_address->getSurname());
$shipping_address_complement = $shipping_address->getComplement();
$shipping_address_address_line = $shipping_address->getAddressLine();
$shipping_address_zipcode = $shipping_address->getPostalCode();
$shipping_address_city = $shipping_address->getCity();

if($order_birthlist_id != null) {
    $birthlist = BirthlistGateway::GetBirthlistByID($order_birthlist_id);
    $shipping_address_identity = $birthlist->getMotherName() . " et " . $birthlist->getFatherName();
    $shipping_address_company = "";
}

/* Billing address */
$billing_address = $order->getBillingAddress();
$billing_address_company = $billing_address->getCompany();
$billing_address_identity = $billing_address->getCivilityString() . " " . ucfirst($billing_address->getFirstname()) . " " . strtoupper($billing_address->getSurname());
$billing_address_complement = $billing_address->getComplement();
$billing_address_address_line = $billing_address->getAddressLine();
$billing_address_zipcode = $billing_address->getPostalCode();
$billing_address_city = $billing_address->getCity();


if(substr($shipping_address_id, 0, 15) == "withdrawal-shop") $withdrawal_shop = true;
else $withdrawal_shop = false;
if($order_birthlist_id != null) $is_from_birthlist = true;
else $is_from_birthlist = false;

if($order->getCustomerMessage() != null)
    $customer_message =  "Message du client : " . $order->getCustomerMessage();
else $customer_message = "";

?>

<!DOCTYPE html>
<html lang="fr" style="background: #3b3f4d;">
<head>
    <title>Facture - BEBES LUTINS</title>
    <meta name="description" content="Affichage de la facture d'une commande."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="bill">
<header class="horizontal between">
    <div id="shipping-address-container" class="address-container vertical">
        <div class="shipping-address">
            <H1>Adresse de livraison</H1>
            <?php echo $shipping_address_company; ?>
            <p class='identity'><?php echo $shipping_address_identity; ?></p>
            <?php if(!$withdrawal_shop && !$is_from_birthlist){ ?>
                <?php echo $shipping_address_complement; ?>
                <p class='address-line'><?php echo $shipping_address_address_line; ?></p>
                <p class='zip-code'><?php echo $shipping_address_zipcode; ?></p>
                <p class='city'><?php echo $shipping_address_city; ?></p>
            <?php } else if($withdrawal_shop) {
                echo "<p>Retrait à l'atelier</p>";
            } else if($is_from_birthlist){
                echo "<a href='https://www.bebes-lutins.fr/liste-de-naissance/partage/$order_birthlist_id'>Fait partie d'une liste de naissance.</a>";
            } ?>
        </div>
        <div class="contact-infos vertical">
            <p><u>E-Mail</u> : <?php echo $user_email;?></p>
            <p><u>Téléphone</u> : <?php echo $user_phone;?></p>
        </div>
    </div>
    <div id='billing-address-container' class="address-container vertical">
        <div class="shipping-address">
            <H1>Adresse de facturation</H1>
            <?php echo $billing_address_company; ?>
            <p class='identity'><?php echo $billing_address_identity; ?></p>
            <?php echo $billing_address_complement; ?>
            <p class='address-line'><?php echo $billing_address_address_line; ?></p>
            <p class='zip-code'><?php echo $billing_address_zipcode; ?></p>
            <p class='city'><?php echo $billing_address_city; ?></p>
        </div>
    </div>
</header>
<main>
    <H2><?php echo $order_date;?></H2>
    <p><?php echo $customer_message;?></p>
    <table class="order-items-table">
        <tr>
            <th>Produits</th>
            <th>Prix unitaire TTC</th>
            <th>Quantité</th>
            <th>Total TTC</th>
        </tr>
        <?php foreach ($order_items as $order_item) {
            $order_item = (new OrderItemContainer($order_item))->getOrderitem();
            $item_name = $order_item->getProduct()->getName();
            $item_quantity = $order_item->getQuantity();
            $item_unitprice = $order_item->getUnitPrice();
            $item_total_price = str_replace("EUR","€",money_format("%.2i",$item_unitprice * $item_quantity));
            $item_unitprice = str_replace("EUR","€",money_format("%.2i",$order_item->getUnitPrice()));
            if ($order_item->getProduct()->getReference() != null){
                $item_custom_id = $order_item->getProduct()->getReference() . " -";
            } else $item_custom_id = "";

            echo "
            <tr>
                <td>$item_custom_id $item_name</td>
                <td class=\"table-price\">$item_unitprice</td>
                <td class='table-quantity'>$item_quantity</td>
                <td class=\"table-price\">$item_total_price</td>
            </tr>
            ";
        }?>
        <tr class="empty">
            <td>Une notice d'entretien</td>
            <td class="table-price">0,00 €</td>
            <td class="table-quantity">1</td>
            <td class="table-price">0,00 €</td>
        </tr>
        <tr class="empty">
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="table-price">Sous total TTC : </td>
            <td class="table-price"><?php echo $order_price; ?></td>
        </tr>
        <tr class="empty">
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="table-price">Frais de port TTC : </td>
            <td class="table-price"><?php echo $order_shipping_price; ?></td>
        </tr>
        <tr class="empty">
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="table-price">Réduction : </td>
            <td class="table-price"><?php echo "0,00 €";?></td>
        </tr>
        <tr class="empty">
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="table-price">TOTAL TTC : </td>
            <td class="table-price"><?php echo $order_total_price;?></td>
        </tr>
    </table>
    <div>
        <p class="payment-method">Payé par <?php echo $order_payment_method;?></p>
    </div>
</main>
</body>
</html>