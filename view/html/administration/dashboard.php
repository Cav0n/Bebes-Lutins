<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:39
 */
if(isset($_GET['header_tab'])) $selection_tab_header = $_GET['header_tab'];
else $selection_tab_header = "orders";

if(isset($_SESSION['header_tab'])) $selection_tab_header = $_SESSION['header_tab'];
unset($_SESSION['header_tab']);

if (isset($_SESSION['connected_user'])){
    $administrator = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
}

try {
    $today_date = date('Y-m', mktime(0, 0, 0,date("m")+1, 0, date("Y")));
    $yesterday_date = date('Y-m', mktime(0, 0, 0, date("m"), 0, date("Y")));

    $min_date = date('Y-m', mktime(0,0,0,7, 0, 2017));
    $max_date = $today_date;
} catch (Exception $e) {

}


$orders = OrderGateway::GetOrdersFromGateway();

$products = ProductGateway::GetProducts();
$highlighted_products = ProductGateway::GetHighlightedProducts();
$categories = CategoryGateway::GetCategories();
usort($categories, function(Category $a, Category $b)
{
    if($a->getRank() - $b->getRank() == $b->getRank() - $a->getRank()) return strcmp( $b->getName(), $a->getName());
    return $a->getRank() - $b->getRank();
});

$users = UserGateway::getAllUsers();
$vouchers = VoucherGateway::GetAllVoucher();
$turnover = 0;

$order_display_0 = ""; $nb_0 = 0; $nb_10 = 0;
$order_display_1 = ""; $nb_1 = 0; $nb_11 = 0;
$order_display_2 = ""; $nb_2 = 0;
$order_display_3 = ""; $nb_3 = 0;
$order_display_canceled = ""; $nb_cancelled = 0; $nb_cancelled2 = 0;
foreach ($orders as $order) {
    $order = (new OrderContainer($order))->getOrder();
    $order_id = $order->getId();
    $date = $order->getDateString();
    $name_surname = $order->getCustomer()->getSurname() ." ". $order->getCustomer()->getFirstname();
    $total_price = UtilsModel::FloatToPrice( $order->getTotalPrice() + $order->getShippingPrice());
    $shipping_price = UtilsModel::FloatToPrice( $order->getShippingPrice());
    if($order->getCustomerMessage() != null) $message =
        'Message du client : <BR> 
        "'. $order->getCustomerMessage() .'"';
    else $message = "";

    $status = $order->statusToString();
    $status_number = $order->getStatus();
    $payment_method = $order->getPaymentMethodMin();

    if($status_number >= 2) $turnover += ($order->getTotalPrice() + $order->getShippingPrice());

    if($administrator->getPrivilege() < 4) $status_choice = "disabled";
    else $status_choice = "";

    $order_item_list_display = "";
    foreach ($order->getOrderItems() as $orderItem){
        $orderItem = (new OrderItemContainer($orderItem))->getOrderitem();
        $orderItem_name = $orderItem->getProduct()->getName();
        $orderItem_price = str_replace("Eu", "€", money_format('%.2n', $orderItem->getUnitPrice()));
        $orderItem_quantity = $orderItem->getQuantity();
        $orderItem_image = $orderItem->getProduct()->getImage();

        $order_item_list_display = $order_item_list_display . "
            <div class='order-product horizontal between'>
                <div class='horizontal'>
                    <img width='40px' height='40px' src='https://www.bebes-lutins.fr/view/assets/images/products/$orderItem_image'>
                    <p class='vertical centered'>$orderItem_name </p>
                </div>
                <p class='vertical centered'>($orderItem_price) x $orderItem_quantity</p>
            </div>
        ";
    }

    $shipping_address = $order->getShippingAddress();
    if(substr($shipping_address->getId(), 0, 15) != 'withdrawal-shop') {
        $identity = $shipping_address->getFirstname() . " " . $shipping_address->getSurname() . "<BR>" . $shipping_address->getCompany();
        $address = $shipping_address->getAddressLine() . "<BR>" . $shipping_address->getComplement() . "<BR>" . $shipping_address->getPostalCode() . "<BR>" . $shipping_address->getCity();
        $shipping_address_string = "
        <p>$identity</p>
        <p>$address</p>
    ";
    } else $shipping_address_string = "<p>Retrait à l'atelier.</p>";

    if($order->getBirthlistID() != null){
        $birthlist_id = $order->getBirthlistID();
        $shipping_address_string = "La commande fait partie d'une <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/liste-de-naissance/partage/$birthlist_id'>liste de naissance</a>.";
    }

    $billing_address = $order->getBillingAddress();
    $identity = $billing_address->getFirstname() . " " . $billing_address->getSurname() . "<BR>".$billing_address->getCompany();
    $address = $billing_address->getAddressLine() . "<BR>" . $billing_address->getComplement() ."<BR>" . $billing_address->getPostalCode() . "<BR>" . $billing_address->getCity();
    $billing_address_string = "
        <p>$identity</p>
        <p>$address</p>
    ";

    if ($status_number == 0) {
        $nb_0++;
        $order_display_0 = $order_display_0 . "
        <span class='order-container vertical'>
            <div id='order-$order_id' class='horizontal between order' onclick='display_details(\"$order_id\")'>
                <div class='horizontal'>
                    <p class='date'>$date</p>
                    <p>$name_surname</p>
                </div>
                <div class='horizontal'>
                    <p>$total_price (Frais de port : $shipping_price)</p>
                    <p class='payment-method'>$payment_method</p>
                    <p class='status status-$status_number'>$status</p>
                </div>
            </div>
            <div id='details-$order_id' class='vertical order-details hidden'>
                <div class='order-product-list vertical'>
                    $order_item_list_display
                </div>
                <div class='order-message vertical'>
                    <p>$message</p>
                </div>
                <div class='horizontal between'>
                    <div class='order-shipping-address-list vertical'>
                        <p class='address-title'>Adresse de livraison</p>
                        $shipping_address_string
                    </div>
                    <div class='order-billing-address-list vertical'>
                        <p class='address-title'>Adresse de facturation</p>
                        $billing_address_string
                    </div>
                </div>
                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                <input type='hidden' name='order_id' value='$order_id'>
                    <div class='vertical status-modifier'>
                        <label for='new-status'>Modifier l'état de la commande :</label>
                        <select id='new-status' name='new-status' $status_choice>
                            <option value='-1'>Annuler la commande</option>
                            <option value='0' selected>En attente de paiement</option>
                            <option value='1'>En cours de traitement</option>
                            <option value='2'>En cours de livraison</option>
                            <option value='3'>Livrée</option>
                        </select>
                        
                        <label for='admin_message'>Message pour le client :</label>
                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                        <button type='submit' $status_choice>Modifier</button>
                    </div>
                    <div class='vertical bottom bill-link'>
                        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'>Afficher la facture</a>
                    </div>
                </form>
            </div>
        </span>
        ";
    }
    if ($status_number == 1) {
        $nb_1++;
        $order_display_1 = $order_display_1 . "
        <span class='order-container vertical'>
            <div id='order-$order_id' class='horizontal between order' onclick='display_details(\"$order_id\")'>
                <div class='horizontal'>
                    <p class='date'>$date</p>
                    <p>$name_surname</p>
                </div>
                <div class='horizontal'>
                    <p>$total_price (Frais de port : $shipping_price)</p>
                    <p class='payment-method'>$payment_method</p>
                    <p class='status status-$status_number'>$status</p>
                </div>
            </div>
            <div id='details-$order_id' class='vertical order-details hidden'>
                <div class='order-product-list vertical'>
                    $order_item_list_display
                </div>
                <div class='order-message vertical'>
                    <p>$message</p>
                </div>
                <div class='horizontal between'>
                    <div class='order-shipping-address-list vertical'>
                        <p class='address-title'>Adresse de livraison</p>
                        $shipping_address_string
                    </div>
                    <div class='order-billing-address-list vertical'>
                        <p class='address-title'>Adresse de facturation</p>
                        $billing_address_string
                    </div>
                </div>
                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                <input type='hidden' name='order_id' value='$order_id'>
                    <div class='vertical status-modifier'>
                        <label for='new-status'>Modifier l'état de la commande :</label>
                        <select id='new-status' name='new-status' $status_choice>
                            <option value='-1'>Annuler la commande</option>
                            <option value='0' selected>En attente de paiement</option>
                            <option value='1'>En cours de traitement</option>
                            <option value='2'>En cours de livraison</option>
                            <option value='3'>Livrée</option>
                        </select>
                        
                        <label for='admin_message'>Message pour le client :</label>
                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                        <button type='submit' $status_choice>Modifier</button>
                    </div>
                    <div class='vertical bottom bill-link'>
                        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'>Afficher la facture</a>
                    </div>
                </form>
            </div>
        </span>
        ";
    }
    if ($status_number == 2) {
        $nb_2++;
        $order_display_2 = $order_display_2 . "
        <span class='order-container vertical'>
            <div id='order-$order_id' class='horizontal between order' onclick='display_details(\"$order_id\")'>
                <div class='horizontal'>
                    <p class='date'>$date</p>
                    <p>$name_surname</p>
                </div>
                <div class='horizontal'>
                    <p>$total_price (Frais de port : $shipping_price)</p>
                    <p class='payment-method'>$payment_method</p>
                    <p class='status status-$status_number'>$status</p>
                </div>
            </div>
            <div id='details-$order_id' class='vertical order-details hidden'>
                <div class='order-product-list vertical'>
                    $order_item_list_display
                </div>
                <div class='order-message vertical'>
                    <p>$message</p>
                </div>
                <div class='horizontal between'>
                    <div class='order-shipping-address-list vertical'>
                        <p class='address-title'>Adresse de livraison</p>
                        $shipping_address_string
                    </div>
                    <div class='order-billing-address-list vertical'>
                        <p class='address-title'>Adresse de facturation</p>
                        $billing_address_string
                    </div>
                </div>
                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                <input type='hidden' name='order_id' value='$order_id'>
                    <div class='vertical status-modifier'>
                        <label for='new-status'>Modifier l'état de la commande :</label>
                        <select id='new-status' name='new-status' $status_choice>
                            <option value='-1'>Annuler la commande</option>
                            <option value='0' selected>En attente de paiement</option>
                            <option value='1'>En cours de traitement</option>
                            <option value='2'>En cours de livraison</option>
                            <option value='3'>Livrée</option>
                        </select>
                        
                        <label for='admin_message'>Message pour le client :</label>
                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                        <button type='submit' $status_choice>Modifier</button>
                    </div>
                    <div class='vertical bottom bill-link'>
                        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'>Afficher la facture</a>
                    </div>
                </form>
            </div>
        </span>
        ";
    }
    if ($status_number == 3) {
        $nb_3++;
        $order_display_3 = $order_display_3 . "
       <span class='order-container vertical'>
            <div id='order-$order_id' class='horizontal between order' onclick='display_details(\"$order_id\")'>
                <div class='horizontal'>
                    <p class='date'>$date</p>
                    <p>$name_surname</p>
                </div>
                <div class='horizontal'>
                    <p>$total_price (Frais de port : $shipping_price)</p>
                    <p class='payment-method'>$payment_method</p>
                    <p class='status status-$status_number'>$status</p>
                </div>
            </div>
            <div id='details-$order_id' class='vertical order-details hidden'>
                <div class='order-product-list vertical'>
                    $order_item_list_display
                </div>
                <div class='order-message vertical'>
                    <p>$message</p>
                </div>
                <div class='horizontal between'>
                    <div class='order-shipping-address-list vertical'>
                        <p class='address-title'>Adresse de livraison</p>
                        $shipping_address_string
                    </div>
                    <div class='order-billing-address-list vertical'>
                        <p class='address-title'>Adresse de facturation</p>
                        $billing_address_string
                    </div>
                </div>
                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                <input type='hidden' name='order_id' value='$order_id'>
                    <div class='vertical status-modifier'>
                        <label for='new-status'>Modifier l'état de la commande :</label>
                        <select id='new-status' name='new-status' $status_choice>
                            <option value='-1'>Annuler la commande</option>
                            <option value='0' selected>En attente de paiement</option>
                            <option value='1'>En cours de traitement</option>
                            <option value='2'>En cours de livraison</option>
                            <option value='3'>Livrée</option>
                        </select>
                        
                        <label for='admin_message'>Message pour le client :</label>
                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                        <button type='submit' $status_choice>Modifier</button>
                    </div>
                    <div class='vertical bottom bill-link'>
                        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'>Afficher la facture</a>
                    </div>
                </form>
            </div>
        </span>
        ";
    }
    if ($status_number == -1) {
        $nb_cancelled++;
        $order_display_canceled = $order_display_canceled . "
        <span class='order-container vertical'>
            <div id='order-$order_id' class='horizontal between order' onclick='display_details(\"$order_id\")'>
                <div class='horizontal'>
                    <p class='date'>$date</p>
                    <p>$name_surname</p>
                </div>
                <div class='horizontal'>
                    <p>$total_price (Frais de port : $shipping_price)</p>
                    <p class='payment-method'>$payment_method</p>
                    <p class='status status-$status_number'>$status</p>
                </div>
            </div>
            <div id='details-$order_id' class='vertical order-details hidden'>
                <div class='order-product-list vertical'>
                    $order_item_list_display
                </div>
                <div class='order-message vertical'>
                    <p>$message</p>
                </div>
                <div class='horizontal between'>
                    <div class='order-shipping-address-list vertical'>
                        <p class='address-title'>Adresse de livraison</p>
                        $shipping_address_string
                    </div>
                    <div class='order-billing-address-list vertical'>
                        <p class='address-title'>Adresse de facturation</p>
                        $billing_address_string
                    </div>
                </div>
                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                <input type='hidden' name='order_id' value='$order_id'>
                    <div class='vertical status-modifier'>
                        <label for='new-status'>Modifier l'état de la commande :</label>
                        <select id='new-status' name='new-status' $status_choice>
                            <option value='-1'>Annuler la commande</option>
                            <option value='0' selected>En attente de paiement</option>
                            <option value='1'>En cours de traitement</option>
                            <option value='2'>En cours de livraison</option>
                            <option value='3'>Livrée</option>
                        </select>
                        
                        <label for='admin_message'>Message pour le client :</label>
                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                        <button type='submit' $status_choice>Modifier</button>
                    </div>
                    <div class='vertical bottom bill-link'>
                        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'>Afficher la facture</a>
                    </div>
                </form>
            </div>
        </span>
        ";
    }
    if($status_number == 10){
        $nb_0++;
        $nb_10++;
        $order_display_0 = $order_display_0 . "
        <span class='order-container vertical'>
            <div id='order-$order_id' class='horizontal between order' onclick='display_details(\"$order_id\")'>
                <div class='horizontal'>
                    <p class='date'>$date</p>
                    <p>$name_surname</p>
                </div>
                <div class='horizontal'>
                    <p>$total_price (Frais de port : $shipping_price)</p>
                    <p class='payment-method'>$payment_method</p>
                    <p class='status status-$status_number'>$status</p>
                </div>
            </div>
            <div id='details-$order_id' class='vertical order-details hidden'>
                <div class='order-product-list vertical'>
                    $order_item_list_display
                </div>
                <div class='order-message vertical'>
                    <p>$message</p>
                </div>
                <div class='horizontal between'>
                    <div class='order-shipping-address-list vertical'>
                        <p class='address-title'>Adresse de livraison</p>
                        $shipping_address_string
                    </div>
                    <div class='order-billing-address-list vertical'>
                        <p class='address-title'>Adresse de facturation</p>
                        $billing_address_string
                    </div>
                </div>
                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                <input type='hidden' name='order_id' value='$order_id'>
                    <div class='vertical status-modifier'>
                        <label for='new-status'>Modifier l'état de la commande :</label>
                        <select id='new-status' name='new-status' $status_choice>
                            <option value='-1'>Annuler la commande</option>
                            <option value='0' selected>En attente de paiement</option>
                            <option value='1'>En cours de traitement</option>
                            <option value='2'>En cours de livraison</option>
                            <option value='3'>Livrée</option>
                        </select>
                        
                        <label for='admin_message'>Message pour le client :</label>
                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                        <button type='submit' $status_choice>Modifier</button>
                    </div>
                    <div class='vertical bottom bill-link'>
                        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'>Afficher la facture</a>
                    </div>
                </form>
            </div>
        </span>
        ";
    }
    if ($status_number == 11) {
        $nb_11++;
        $order_display_1 = $order_display_1 . "
        <span class='order-container vertical'>
            <div id='order-$order_id' class='horizontal between order' onclick='display_details(\"$order_id\")'>
                <div class='horizontal'>
                    <p class='date'>$date</p>
                    <p>$name_surname</p>
                </div>
                <div class='horizontal'>
                    <p>$total_price (Frais de port : $shipping_price)</p>
                    <p class='payment-method'>$payment_method</p>
                    <p class='status status-$status_number'>$status</p>
                </div>
            </div>
            <div id='details-$order_id' class='vertical order-details hidden'>
                <div class='order-product-list vertical'>
                    $order_item_list_display
                </div>
                <div class='order-message vertical'>
                    <p>$message</p>
                </div>
                <div class='horizontal between'>
                    <div class='order-shipping-address-list vertical'>
                        <p class='address-title'>Adresse de livraison</p>
                        $shipping_address_string
                    </div>
                    <div class='order-billing-address-list vertical'>
                        <p class='address-title'>Adresse de facturation</p>
                        $billing_address_string
                    </div>
                </div>
                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                <input type='hidden' name='order_id' value='$order_id'>
                    <div class='vertical status-modifier'>
                        <label for='new-status'>Modifier l'état de la commande :</label>
                        <select id='new-status' name='new-status' $status_choice>
                            <option value='-1'>Annuler la commande</option>
                            <option value='0' selected>En attente de paiement</option>
                            <option value='1'>En cours de traitement</option>
                            <option value='2'>En cours de livraison</option>
                            <option value='3'>Livrée</option>
                        </select>
                        
                        <label for='admin_message'>Message pour le client :</label>
                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                        <button type='submit' $status_choice>Modifier</button>
                    </div>
                    <div class='vertical bottom bill-link'>
                        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'>Afficher la facture</a>
                    </div>
                </form>
            </div>
        </span>
        ";
    }
    if ($status_number == -11){
        $nb_cancelled2++;
        $order_display_canceled = $order_display_canceled . "
        <span class='order-container vertical'>
            <div id='order-$order_id' class='horizontal between order' onclick='display_details(\"$order_id\")'>
                <div class='horizontal'>
                    <p class='date'>$date</p>
                    <p>$name_surname</p>
                </div>
                <div class='horizontal'>
                    <p>$total_price (Frais de port : $shipping_price)</p>
                    <p class='payment-method'>$payment_method</p>
                    <p class='status status-$status_number'>$status</p>
                </div>
            </div>
            <div id='details-$order_id' class='vertical order-details hidden'>
                <div class='order-product-list vertical'>
                    $order_item_list_display
                </div>
                <div class='order-message vertical'>
                    <p>$message</p>
                </div>
                <div class='horizontal between'>
                    <div class='order-shipping-address-list vertical'>
                        <p class='address-title'>Adresse de livraison</p>
                        $shipping_address_string
                    </div>
                    <div class='order-billing-address-list vertical'>
                        <p class='address-title'>Adresse de facturation</p>
                        $billing_address_string
                    </div>
                </div>
                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                <input type='hidden' name='order_id' value='$order_id'>
                    <div class='vertical status-modifier'>
                        <label for='new-status'>Modifier l'état de la commande :</label>
                        <select id='new-status' name='new-status' $status_choice>
                            <option value='-11' selected>Annuler le paiement</option>
                            <option value='10'>En attente de paiement</option>
                            <option value='11'>Payée</option>
                        </select>
                        
                        <label for='admin_message'>Message pour le client :</label>
                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                        <button type='submit' $status_choice>Modifier</button>
                    </div>
                    <div class='vertical bottom bill-link'>
                        <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/dashboard/facture-$order_id'>Afficher la facture</a>
                    </div>
                </form>
            </div>
        </span>
        ";
    }
}
if($order_display_0 == ""){
    $order_display_0 = "<p class='horizontal centered'>Oh ! Il n'y a aucune commande en cours de paiement</p>";
}
if($order_display_1 == ""){
    $order_display_1 = "<p class='horizontal centered'>Oh ! Il n'y a aucune commande en attente.</p>";
}
if($order_display_2 == ""){
    $order_display_2 = "<p class='horizontal centered'>Oh ! Il n'y a aucune commande en cours de livraison.</p>";
}
if($order_display_3 == ""){
    $order_display_3 = "<p class='horizontal centered'>Oh ! Il n'y a aucune commande livrée.</p>";
}
if($order_display_canceled == ""){
    $order_display_canceled = "<p class='horizontal centered'>Chouette ! Il n'y a aucune commande annulée !</p>";
}

$user_display_verified = ""; $nb_verified = 0;
$user_display_non_verified = ""; $nb_non_verified = 0;
$user_display_administrators = ""; $nb_administrators = 0;
foreach ($users as $user) {
    $user = new UserConnected($user->getId(), $user->getSurname(), $user->getFirstname(), $user->getMail(), $user->getPhone(), $user->getPrivilege(), $user->getRegistrationDate(), $user->isActivated());
    $firstname = $user->getFirstname();
    $surname = strtoupper($user->getSurname());
    $mail = strtolower($user->getMail());
    $phone = $user->getPhone();
    $id = $user->getId();

    if($phone == null)$phone = "Aucun numéro de téléphone.";
    elseif(substr($phone, 0, 1) != 0) $phone = 0 . $phone;
    $registration_date = $user->getRegistrationDateString();

    if($user->isActivated() && $user->getPrivilege() < 1){
        $user_display_verified = $user_display_verified . "
            <div class='user horizontal between'>
                <div class='infos vertical'>
                    <p class='name'>$firstname $surname</p>
                    <p>Email : <a href='mailto:$mail'>$mail</a></p>
                    <p>Téléphone : $phone</p>
                </div>
                <div class='vertical between'>
                    <p>Date d'inscription : $registration_date</p>
                    <a href='https://www.bebes-lutins.fr/dashboard/page-client-$id' target='_blank'>Afficher la fiche client</a>
                </div>
            </div>
        ";
    }
    if(!$user->isActivated()){
        $user_display_non_verified = $user_display_non_verified . "
            <div class='user horizontal between'>
                <div class='infos vertical'>
                    <p class='name'>$firstname $surname</p>
                    <p>Email : <a href='mailto:$mail'>$mail</a></p>
                    <p>Téléphone : $phone</p>
                </div>
                <div class='vertical between'>
                    <p>Date d'inscription : $registration_date</p>
                    <a href='https://www.bebes-lutins.fr/dashboard/page-client-$id' target='_blank'>Afficher la fiche client</a>
                </div>
            </div>
        ";
    }
    if($user->isActivated() && $user->getPrivilege() > 1){
        $user_display_administrators = $user_display_administrators . "
            <div class='user horizontal between'>
                <div class='infos vertical'>
                    <p class='name'>$firstname $surname</p>
                    <p>Email : <a href='mailto:$mail'>$mail</a></p>
                    <p>Téléphone : $phone</p>
                </div>
                <div class='vertical between'>
                    <p>Date d'inscription : $registration_date</p>
                    <a href='https://www.bebes-lutins.fr/dashboard/page-client-$id' target='_blank'>Afficher la fiche client</a>
                </div>
            </div>
        ";
    }
}
if($user_display_verified == ""){ $user_display_verified = "<p>Oups... Aucun utilisateur n'a vérifié son adresse mail.</p>";}
if($user_display_non_verified == ""){ $user_display_non_verified = "<p>Il n'y a aucun utilisateur avec une adresse mail non vérifiée, c'est parfait !</p>";}
if($user_display_administrators == ""){ $user_display_administrators = "<p>Oula, il semblerait qu'un problème est survenu, il n'y a aucun administrateurs sur le site !!</p>";}

?>

<!DOCTYPE html>
<html style="background: #3b3f4d;">
<head>
    <title>ADMINISTRATION - BEBES LUTINS</title>
    <meta name="description" content="Bienvenue dans votre tout nouveau tableau de bord."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="administration">
<header>
    <a href="https://www.bebes-lutins.fr" class="no-decoration"><h1>BEBES LUTINS</h1></a>
    <div id="header-tabs" class="tabs">
        <button id="orders" class="header-button <?php if($selection_tab_header != 'orders') echo 'non-';?>selected" onclick="tab_selection_changed_header('orders')">
            <div class="horizontal tab">
                <i class="fas fa-boxes fa-2x"></i>
                <p>Commandes</p>
            </div>
        </button>
        <button id="products" class="header-button <?php if($selection_tab_header != 'products') echo 'non-';?>selected <?php if($administrator->getPrivilege() < 4) echo 'hidden'?>" onclick="tab_selection_changed_header('products')">
            <div class="horizontal tab">
                <i class="fas fa-sitemap fa-2x"></i>
                <p>Produits</p>
            </div>
        </button>
        <button id="users" class="header-button <?php if($selection_tab_header != 'users') echo 'non-';?>selected <?php if($administrator->getPrivilege() < 4) echo 'hidden'?>" onclick="tab_selection_changed_header('users')">
            <div class="horizontal tab">
                <i class="fas fa-users fa-2x"></i>
                <p>Utilisateurs</p>
            </div>
        </button>
        <button id="various" class="header-button <?php if($selection_tab_header != 'various') echo 'non-';?>selected <?php if($administrator->getPrivilege() < 4) echo 'hidden'?>" onclick="tab_selection_changed_header('various')">
            <div class="horizontal tab">
                <i class="fas fa-chart-line fa-2x"></i>
                <p>Divers</p>
            </div>
        </button>
    </div>
    <div id="dashboard-version">
        <p>Version : 3.1</p>
    </div>
</header>
<main>
    <div id="options">

    </div>
    <div id="display-windows">
        <div id="disp-orders" class="horizontal between windows-container <?php if($selection_tab_header != 'orders') echo 'non-';?>selected">
            <?php if (isset($_POST['error-message-orders'])) echo $_POST['error-message-orders']; ?>
            <div class="vertical window" id="orders-window">
                <div id="window-tabs-orders" class="horizontal window-tabs">
                    <p id="in-preparation-orders" class="tab selected transition-fast" onclick="tab_selection_changed_orders('in-preparation-orders')">Commande en attente</p>
                    <p id="waiting-for-payments-orders" class="tab non-selected transition-fast" onclick="tab_selection_changed_orders('waiting-for-payments-orders')">Commande en cours de paiement</p>
                    <p id="sent-orders" class="tab non-selected transition-fast" onclick="tab_selection_changed_orders('sent-orders')">Commande envoyée</p>
                    <p id="canceled-orders" class="tab non-selected transition-fast" onclick="tab_selection_changed_orders('canceled-orders')">Commande annulée</p>
                </div>
                <div id="display-orders" class="tab-display">
                    <div id="disp-in-preparation-orders" class="selected vertical centered orders-list">
                        <?php echo $order_display_1;?>
                    </div>
                    <div id="disp-waiting-for-payments-orders" class="non-selected vertical centered orders-list">
                        <?php echo $order_display_0;?>
                    </div>
                    <div id="disp-sent-orders" class="non-selected vertical centered orders-list">
                        <?php echo $order_display_2?>
                        <?php echo $order_display_3;?>
                    </div>
                    <div id="disp-canceled-orders" class="non-selected vertical centered orders-list">
                        <?php echo $order_display_canceled;?>
                    </div>
                </div>
            </div>
            <div class="vertical summary-window">
                <p>En cours de paiement : <?php echo $nb_0;?></p>
                <p>En attente : <?php echo $nb_1;?></p>
                <p>En cours de livraison : <?php echo $nb_2;?></p>
                <p>Livrée : <?php echo $nb_3;?></p>
                <p>Annulée : <?php echo $nb_cancelled;?></p>

                <p>LISTES DE NAISSANCE : </p>
                <p>En cours de paiement : <?php echo $nb_10?></p>
                <p>Paiements : <?php echo $nb_11?></p>
                <p>Paiements annulés : <?php echo $nb_cancelled2;?></p>
            </div>
        </div>
        <div id="disp-products" class="vertical between windows-container <?php if($selection_tab_header != 'products') echo 'non-';?>selected">
            <?php if(isset($_POST['error-message-products'])) echo $_POST['error-message-products'];?>
            <?php if(isset($_POST["ErreurUpload"])) echo $_POST["ErreurUpload"];?>
            <?php if(isset($_SESSION['test'])) echo $_SESSION['test'];?>
            <?php if(isset($_SESSION['name'])) echo $_SESSION['name'];?>

            <div class="vertical window" id="product-window">
                <form id="clone-popup" class="vertical hidden" method="post">
                    <h2 style="font-size: 1.2em;" id="product-name-popup"></h2>
                    <input id="product-id-popup-clone" type="hidden" name="product_id" value="">
                    <input id="product-id-copy-popup-clone" type="hidden" name="product_id_copy" value="">
                    <label for="clone-category-select">Choix de la catégorie : </label>
                    <select id="clone-category-select" name="clone_category">
                        <?php
                        foreach($categories as $category){
                            $category = (new CategoryContainer($category))->getCategory();
                            ?>
                            <option value="<?php echo $category->getName();?>"><?php echo $category->toString();?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <button class='button' formaction="https://www.bebes-lutins.fr/dashboard/clone" type="submit">Cloner le produit</button>
                    <button class='button' formaction="https://www.bebes-lutins.fr/dashboard/copier" type="submit">Copier le produit</button>
                    <button class='button' formaction="https://www.bebes-lutins.fr/dashboard/deplacer" type="submit">Deplacer le produit</button>
                    <p class="button" onclick="close_popup_clone_product()">Annuler</p>
                </form>
                <div class="window-header">
                    <form method="post">
                        <input id="search-product-input" type="text" name="search" placeholder="Rechercher un produit">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="category-container">
                    <form action="https://www.bebes-lutins.fr/dashboard/ajout-categorie-page" method="post" class="category horizontal centered">
                        <input type="hidden" name="category_parent" value="none">
                        <button class="add-category transition-fast">Ajouter une catégorie</button>
                    </form>
                </div>
                <?php
                foreach ($categories as $category){
                    $category = (new CategoryContainer($category))->getCategory();
                    /*if($category->getParent() != "none") {
                        $category_parent = $category->getParent();
                        $category_parent_string =  $category_parent . " - ";
                    }else {
                        $category_parent = null;
                        $category_parent_string = null;
                    }*/

                    if($category->getParent() == "none"){
                        $category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category->getName())));
                        ?>
                    <div id="category-<?php echo str_replace(" ","-",$category->getName());?>" class="category-container <?php if($category_parent == null) echo "border-bottom";?>">
                        <div id="category-header-<?php echo str_replace(" ","-",$category->getName());?>" class="category horizontal" onclick="display_details_category('<?php echo str_replace(" ","-",$category->getName());?>')">
                            <img src="https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $category->getImage() . "?" . filemtime("view/assets/images/categories/" . $category->getImage()->getName());?>">
                            <div class="vertical between texts">
                                <p class="name"><?php echo $category->getRank() . " " . $category->getName();?></p>
                                <p class="category-description"><?php echo $category->getDescription();?></p>
                            </div>
                            <form class="vertical between buttons" method="post" action="https://www.bebes-lutins.fr/dashboard/modifier-categorie-page">
                                <input type="hidden" name="category_name" value="<?php echo $category->getName();?>">
                                <button type="submit" class="modify transition-fast" formaction="https://www.bebes-lutins.fr/dashboard/modifier-categorie-page">Modifier</button>
                                <a onclick="avertissement_categorie('<?php echo $category_name_url;?>')" class="delete transition-fast">Supprimer</a>
                            </form>
                        </div>
                        <div id="category-details-<?php echo str_replace(" ","-",$category->getName())?>" class="category-details-container vertical hidden">
                            <div class="category-management-buttons horizontal centered">
                                <div class="category-container">
                                    <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajout-categorie-page" class="category horizontal centered">
                                        <input type="hidden" name="category_parent" value="<?php echo $category->getName();?>">
                                        <button type='submit' class="add-category transition-fast">Ajouter une sous-catégorie</button>
                                    </form>
                                </div>
                                <div class="category-container">
                                    <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajouter-produit-page" class="category horizontal centered">
                                        <input type="hidden" name="category_parent" value="<?php echo$category->getName();?>">
                                        <button type='submit' class="add-product transition-fast">Ajouter un produit</button>
                                    </form>
                                </div>
                            </div>


                            <?php
                            foreach ($categories as $sub_category) {
                                $sub_category = (new CategoryContainer($sub_category))->getCategory();
                                if ($sub_category->getParent() == $category->getName()) {
                                    $sub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($sub_category->getName())));

                                    ?>
                            <div id="category-<?php echo str_replace(" ","-",$sub_category->getName());?>" class="category-container">
                                <div id="category-header-<?php echo str_replace(" ","-",$sub_category->getName());?>" class="category horizontal" onclick="display_details_category('<?php echo str_replace(" ","-",$sub_category->getName());?>')">
                                    <img src="https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $sub_category->getImage() . "?" . filemtime("view/assets/images/categories/" . $sub_category->getImage()->getName());?>">
                                    <div class="vertical between texts">
                                        <p class="name"><?php echo $sub_category->getRank() . " " . $sub_category->getName();?></p>
                                        <p class="category-description"><?php echo $sub_category->getDescription();?></p>
                                    </div>
                                    <form class="vertical between buttons" method="post" action="#">
                                        <input type="hidden" name="category_name" value="<?php echo $sub_category->getName();?>">
                                        <button type="submit" class="modify transition-fast" formaction="https://www.bebes-lutins.fr/dashboard/modifier-categorie-page">Modifier</button>
                                        <a onclick="avertissement_categorie('<?php echo $sub_category_url;?>')" class="delete transition-fast">Supprimer</a>
                                    </form>
                                </div>
                                <div id="category-details-<?php echo str_replace(" ","-",$sub_category->getName())?>" class="category-details-container vertical hidden">
                                    <div class="category-management-buttons horizontal centered">
                                        <div class="category-container">
                                            <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajout-categorie-page" class="category horizontal centered">
                                                <input type="hidden" name="category_parent" value="<?php echo $sub_category->getName();?>">
                                                <button type='submit' class="add-category transition-fast">Ajouter une sous-catégorie</button>
                                            </form>
                                        </div>
                                        <div class="category-container">
                                            <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajouter-produit-page" class="category horizontal centered">
                                                <input type="hidden" name="category_parent" value="<?php echo $sub_category->getName();?>">
                                                <button type='submit' class="add-product transition-fast">Ajouter un produit</button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($categories as $subsub_category) {
                                        $subsub_category = (new CategoryContainer($subsub_category))->getCategory();
                                        if ($subsub_category->getParent() == $sub_category->getName()) {
                                            $subsub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($subsub_category->getName())));

                                            ?>
                                            <div id="category-<?php echo str_replace(" ","-",$subsub_category->getName());?>" class="category-container">
                                                <div id="category-header-<?php echo str_replace(" ","-",$subsub_category->getName());?>" class="category horizontal" onclick="display_details_category('<?php echo str_replace(" ","-",$subsub_category->getName());?>')">
                                                    <img src="https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $subsub_category->getImage() . "?" . filemtime("view/assets/images/categories/" . $sub_category->getImage()->getName());?>">
                                                    <div class="vertical between texts">
                                                        <p class="name"><?php echo $subsub_category->getRank() . " " . $subsub_category->getName();?></p>
                                                        <p class="category-description"><?php echo $subsub_category->getDescription();?></p>
                                                    </div>
                                                    <form class="vertical between buttons" method="post" action="#">
                                                        <input type="hidden" name="category_name" value="<?php echo $subsub_category->getName();?>">
                                                        <button type="submit" class="modify transition-fast" formaction="https://www.bebes-lutins.fr/dashboard/modifier-categorie-page">Modifier</button>
                                                        <a onclick="avertissement_categorie('<?php echo $subsub_category_url;?>')" class="delete transition-fast">Supprimer</a>
                                                    </form>
                                                </div>
                                                <div id="category-details-<?php echo str_replace(" ","-",$subsub_category->getName())?>" class="category-details-container vertical hidden">
                                                    <div class="category-management-buttons horizontal centered">
                                                        <div class="category-container">
                                                            <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajout-categorie-page" class="category horizontal centered">
                                                                <input type="hidden" name="category_parent" value="<?php echo $subsub_category->getName();?>">
                                                                <button type='submit' class="add-category transition-fast">Ajouter une sous-catégorie</button>
                                                            </form>
                                                        </div>
                                                        <div class="category-container">
                                                            <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajouter-produit-page" class="category horizontal centered">
                                                                <input type="hidden" name="category_parent" value="<?php echo $subsub_category->getName();?>">
                                                                <button type='submit' class="add-product transition-fast">Ajouter un produit</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    foreach ($products as $product){
                                                        $product = (new ProductContainer($product))->getProduct();
                                                        if($product->getCategory()->getName() == $subsub_category->getName()){?>
                                                            <div class="product-container horizontal">
                                                                <div class="product horizontal">
                                                                    <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage(). "?=" . filemtime("view/assets/images/categories/" . $product->getImage()->getName());?>">
                                                                    <div class="text vertical between">
                                                                        <p class="product_name"><?php echo $product->getName();?></p>
                                                                        <div class="numbers">
                                                                            <p><?php echo "Stock : ". $product->getStock();?></p>
                                                                            <p><?php echo "Prix : ".str_replace("Eu", "€", money_format('%.2n', $product->getPrice()));?></p>
                                                                            <p><?php echo "Référence : " . $product->getCustomId();?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <form action="#" method="post" class="buttons vertical">
                                                                    <input type="hidden" name="id_product" value="<?php echo $product->getId();?>">
                                                                    <i class="far fa-star empty-star" onclick="highlight_product('<?php echo $product->getId();?>')"></i>
                                                                    <button type="submit" name="action" value="edit_product_page" formaction="https://www.bebes-lutins.fr/dashboard/modifier-produit-page" class="modify transition-fast"><i class="fas fa-edit"></i></button>
                                                                    <i class="fas fa-clone" onclick="open_popup_clone_product('<?php echo $product->getId();?>','<?php echo $product->getIdCopy();?>', '<?php echo $product->getName();?>')"></i>
                                                                    <button type="submit" name="action" value="delete_product" formaction="https://www.bebes-lutins.fr/dashboard/supprimer-produit" class="delete transition-fast"><i class="fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </div>
                                                        <?php }
                                                    }?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } ?>
                                    <?php
                                    foreach ($products as $product){
                                        $product = (new ProductContainer($product))->getProduct();
                                        if($product->getCategory()->getName() == $sub_category->getName()){?>
                                            <div class="product-container horizontal">
                                                <div class="product horizontal">
                                                    <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage(). "?=" . filemtime("view/assets/images/categories/" . $product->getImage()->getName());?>">
                                                    <div class="text vertical between">
                                                        <p class="product_name"><?php echo $product->getName();?></p>
                                                        <div class="numbers">
                                                            <p><?php echo "Stock : ". $product->getStock();?></p>
                                                            <p><?php echo "Prix : ".str_replace("Eu", "€", money_format('%.2n', $product->getPrice()));?></p>
                                                            <p><?php echo "Référence : " . $product->getCustomId();?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="#" method="post" class="buttons vertical">
                                                    <input type="hidden" name="id_product" value="<?php echo $product->getId();?>">
                                                    <i class="far fa-star empty-star" onclick="highlight_product('<?php echo $product->getId();?>')"></i>
                                                    <button type="submit" name="action" value="edit_product_page" formaction="https://www.bebes-lutins.fr/dashboard/modifier-produit-page" class="modify transition-fast"><i class="fas fa-edit"></i></button>
                                                    <i class="fas fa-clone" onclick="open_popup_clone_product('<?php echo $product->getId();?>','<?php echo $product->getIdCopy();?>', '<?php echo $product->getName();?>')"></i>
                                                    <button type="submit" name="action" value="delete_product" formaction="https://www.bebes-lutins.fr/dashboard/supprimer-produit" class="delete transition-fast"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        <?php }
                                    }?>
                                </div>
                            </div>
                                    <?php
                                }
                            } ?>
                            <?php
                            foreach ($products as $product){
                                $product = (new ProductContainer($product))->getProduct();
                                if($product->getCategory()->getName() == $category->getName()){?>
                                    <div class="product-container horizontal">
                                        <div class="product horizontal">
                                            <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage(). "?=" . filemtime("view/assets/images/categories/" . $category->getImage()->getName());?>">
                                            <div class="text vertical between">
                                                <p class="product_name"><?php echo $product->getName();?></p>
                                                <div class="numbers">
                                                    <p><?php echo "Stock : ". $product->getStock();?></p>
                                                    <p><?php echo "Prix : ".UtilsModel::FloatToPrice($product->getPrice());?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="#" method="post" class="buttons vertical">
                                            <input type="hidden" name="id_product" value="<?php echo $product->getId();?>">
                                            <i class="far fa-star empty-star" onclick="highlight_product('<?php echo $product->getId()?>')"></i>
                                            <button type="submit" name="action" value="edit_product_page" formaction="https://www.bebes-lutins.fr/dashboard/modifier-produit-page" class="modify transition-fast"><i class="fas fa-edit"></i></button>
                                            <i class="fas fa-clone" onclick="open_popup_clone_product('<?php echo $product->getId();?>','<?php echo $product->getIdCopy();?>', '<?php echo $product->getName();?>')"></i>
                                            <button type="submit" name="action" value="delete_product" formaction="https://www.bebes-lutins.fr/dashboard/supprimer-produit" class="delete transition-fast"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                            <?php }}?>
                        </div>
                    </div>
                <?php }} ?>
            </div>
            <div class="vertical window" id="highlighted-products-window">
                <div class="window-header centered">
                    <h3>Produits à mettre en avant</h3>
                </div>
                <div class="highlighted-products-container centered horizontal">
                    <?php
                    foreach ($highlighted_products as $highlighted_product){
                        $hp = (new ProductContainer($highlighted_product))->getProduct();

                        $hp_id = $hp->getId();
                        $hp_image = $hp->getImage();
                        $hp_name = $hp->getName();?>

                        <div id="highlighted-product" class="vertical">
                            <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $hp_image. "?=" . filemtime("view/assets/images/categories/" . $hp_image->getName());?>">
                            <p><?php echo $hp_name;?></p>
                            <button class="delete_button" onclick="remove_highlight_product('<?php echo $hp_id;?>')">Retirer</button>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="disp-users" class="horizontal between windows-container <?php if($selection_tab_header != 'users') echo 'non-';?>selected">
            <div class="vertical window" id="users-window">
                <div id="window-tabs-users" class="horizontal window-tabs">
                    <p id="verified-accounts" class="tab selected transition-fast" onclick="tab_selection_changed_users('verified-accounts')">Comptes validés</p>
                    <p id="non-verified-accounts" class="tab non-selected transition-fast" onclick="tab_selection_changed_users('non-verified-accounts')">Comptes non validés</p>
                    <p id="administrators" class="tab non-selected transition-fast" onclick="tab_selection_changed_users('administrators')">Administrateurs</p>
                </div>
                <div id="display-users" class="tab-display">
                    <div id="disp-verified-accounts" class="selected vertical centered users-list">
                        <?php echo $user_display_verified;?>
                    </div>
                    <div id="disp-non-verified-accounts" class="non-selected vertical centered users-list">
                        <?php echo $user_display_non_verified;?>
                    </div>
                    <div id="disp-administrators" class="non-selected vertical centered users-list">
                        <?php echo $user_display_administrators;?>
                    </div>
                </div>
            </div>
        </div>
        <div id="disp-various" class="horizontal between windows-container <?php if($selection_tab_header != 'various') echo 'non-';?>selected">
            <?php if(isset($_POST['error-message-various'])) echo $_POST['error-message-various'];?>
            <div class="vertical window" id="various-window">
                <div id="window-tabs-various" class="horizontal window-tabs">
                    <p id="turnover" class="tab selected transition-fast" onclick="tab_selection_changed_various('turnover')">Chiffre d'affaire</p>
                    <p id="vouchers" class="tab non-selected transition-fast" onclick="tab_selection_changed_various('vouchers')">Coupons</p>
                    <p id="product-backup" class="tab non-selected transition-fast" onclick="tab_selection_changed_various('product-backup')">Restauration</p>
                </div>
                <div id="display-various" class="tab-display">
                    <div id="disp-turnover" class="selected vertical various-element">
                        <h2>Chiffre d'affaire depuis le début du site : <?php echo str_replace('EUR','€', money_format('%.2i', $turnover));?></h2>
                        <form id="turnover-calculation-form">
                            <label for="beginning-date">Date de début :</label>
                            <input id="beginning-date" name="beginning_date" type="month" value="<?php echo $yesterday_date?>" min="<?php echo $min_date?>" max="<?php echo $max_date?>">
                            <label for="end-date">Date de fin :</label>
                            <input id="end-date" name="end_date" type="month" value="<?php echo $today_date?>" min="<?php echo $min_date?>" max="<?php echo $max_date?>">
                            <p id="turnover-result"></p>
                        </form>
                    </div>
                    <div id="disp-vouchers" class="non-selected vertical various-element">
                        <div id="voucher-container" class="horizontal wrap">
                            <a class="vertical centered voucher" href="https://www.bebes-lutins.fr/dashboard/creation-code-coupon">Ajouter un code coupon</a>
                            <?php foreach ($vouchers as $voucher){
                                $voucher = (new VoucherContainer($voucher))->getVoucher();
                                if($voucher->isExpire()) {
                                    $date = "<p class='expired-voucher-message'>Le coupon n'est plus valable.</p>";
                                }
                                else {
                                    $beginning_date = $voucher->getDateBeginningString();
                                    $end_date = $voucher->getDateEndString();
                                    $date = "<p>Valable du $beginning_date au $end_date.</p>";
                                }
                                ?>
                                <form method="post" action="https://www.bebes-lutins.fr/dashboard/supprimer-coupon" class="voucher" <?php if($voucher->isExpire()) echo "style='color:red;'";?>>
                                    <p class="name"><?php echo $voucher->getName();?></p>
                                    <p class="reduction">Réduction : <?php echo $voucher->getDiscountAndTypeString().'.';?></p>
                                    <p class="number-of-usage">Nombre d'utilisation max : <?php echo $voucher->getNumberOfUsage();?></p>
                                    <p class><?php echo $date;?></p>

                                    <input type="hidden" name="voucher_id" value="<?php echo $voucher->getId();?>">
                                    <button type="submit" >Supprimer</button>
                                </form>
                            <?php }?>
                        </div>
                    </div>
                    <div id="disp-product-backup" class="non-selected vertical various-element">

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

<script>
    function highlight_product(product_id) {
        //document.location.href="https://www.bebes-lutins.fr/?action=add_highlight_product&product_id=" + product_id;

        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {product_id:product_id, action:"add_highlight_product"},
            success: function() {
                document.location.href="https://www.bebes-lutins.fr/dashboard";
            }
        });
    }

    function remove_highlight_product(product_id){
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {product_id:product_id, action:"remove_highlight_product"},
            success: function() {
                document.location.href="https://www.bebes-lutins.fr/dashboard/tab-products";
            }
        });
    }
</script>

<script>
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("turnover-result").innerHTML = this.responseText;
        }
    };

    /* Date de début */
    let beginning_date = document.getElementById('beginning-date');
    beginning_date.valueAsDate = new Date();

    var previous_typed_beginning_date = new Date();

    // Sauvegarde de la date
    beginning_date.onfocus = function(){
        previous_typed_beginning_date = document.getElementById('beginning-date').value;
    };

    // Changement de la date dynamiquement
    beginning_date.onchange = function(){
        if(beginning_date.valueAsDate > end_date.valueAsDate){
            document.getElementById('beginning-date').value = previous_typed_beginning_date;
            alert("La date de début ne peut pas être après la date de fin.");
            //console.log(previous_typed_beginning_date);
        }
        else{
            console.log("https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");

            xhttp.open("GET", "https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");
            xhttp.send();
        }
    };

    /* ---- */

    /* Date de fin */
    let end_date = document.getElementById('end-date');
    end_date.valueAsDate = new Date();

    // Sauvegarde de la date
    end_date.onfocus = function(){
        previous_typed_end_date = document.getElementById('end-date').value;
    }

    // Changement de la date dynamiquement
    end_date.onchange = function(){
        if(end_date.valueAsDate < beginning_date.valueAsDate){
            document.getElementById('end-date').value = previous_typed_end_date;
            alert("La date de fin ne peut pas être avant la date de début.");
        }
        else {
            console.log("https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");


            xhttp.open("GET", "https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");
            xhttp.send();
        }
    };
    /* ---- */

    // Initialisation du chiffre d'affaire :
    xhttp.open("GET", "https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");
    xhttp.send();
    console.log("https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");

</script>

<script>
    function tab_selection_changed_header(new_selected_id){
        var children_tab = Array.from(document.getElementById("header-tabs").children);
        children_tab.forEach(function (entry) {
            entry.setAttribute("class", "header-button non-selected");
        });
        $("#"+new_selected_id).removeClass("non-selected").addClass("selected");

        var children_display = Array.from(document.getElementById("display-windows").children);
        children_display.forEach(function (entry) {
            entry.setAttribute("class", "non-selected horizontal between windows-container");
        });
        $("#disp-"+new_selected_id).removeClass("non-selected").addClass("selected");
    }

    function tab_selection_changed_orders(new_selected_id){
        var children_tab = Array.from(document.getElementById("window-tabs-orders").children);
        children_tab.forEach(function (entry) {
            entry.setAttribute("class", "tab non-selected transition-fast");
        });
        $("#"+new_selected_id).removeClass("non-selected").addClass("selected");

        var children_display = Array.from(document.getElementById("display-orders").children);
        children_display.forEach(function (entry) {
            entry.setAttribute("class", "non-selected vertical centered orders-list");
        });
        $("#disp-"+new_selected_id).removeClass("non-selected").addClass("selected");
    }

    function tab_selection_changed_users(new_selected_id){
        var children_tab = Array.from(document.getElementById("window-tabs-users").children);
        children_tab.forEach(function (entry) {
            entry.setAttribute("class", "tab non-selected transition-fast");
        });
        $("#"+new_selected_id).removeClass("non-selected").addClass("selected");

        var children_display = Array.from(document.getElementById("display-users").children);
        children_display.forEach(function (entry) {
            entry.setAttribute("class", "non-selected vertical centered users-list");
        });
        $("#disp-"+new_selected_id).removeClass("non-selected").addClass("selected");
    }

    function tab_selection_changed_various(new_selected_id){
        var children_tab = Array.from(document.getElementById("window-tabs-various").children);
        children_tab.forEach(function (entry) {
            entry.setAttribute("class", "tab non-selected transition-fast");
        });
        $("#"+new_selected_id).removeClass("non-selected").addClass("selected");

        var children_display = Array.from(document.getElementById("display-various").children);
        children_display.forEach(function (entry) {
            entry.setAttribute("class", "non-selected vertical various-element");
        });
        $("#disp-"+new_selected_id).removeClass("non-selected").addClass("selected");
    }

    function open_popup_clone_product(product_id, product_id_copy, name){
        $("#clone-popup").removeClass('hidden').addClass('display');
        document.getElementById("product-id-popup-clone").value = product_id;
        document.getElementById("product-id-copy-popup-clone").value = product_id_copy;
        document.getElementById("product-name-popup").innerHTML = name;
    }

    function close_popup_clone_product(){
        $("#clone-popup").removeClass('display').addClass('hidden');
    }

    function open_category(category){
        var children_tab = Array.from(document.getElementById(category).children);
        children_tab.forEach(function (entry) {
                entry.setAttribute("class", "product horizontal display");
        });
        $("#"+category).setAttribute("onClick", "close_category("+category+")");
    }

    function close_category(category){
        var children_tab = Array.from(document.getElementById(category).children);
        children_tab.forEach(function (entry) {
            entry.setAttribute("class", "product horizontal display");
        });
        $("#"+category).setAttribute("onclick", "open_category("+category+")");
    }

    function display_details(id){
        $("#details-"+id).removeClass("hidden").addClass("display");
        document.getElementById("order-"+id).setAttribute("onClick", "hide_details('"+id+"')");
    }

    function hide_details(id){
        $("#details-"+id).removeClass("display").addClass("hidden");
        document.getElementById("order-"+id).setAttribute("onClick", "display_details('"+id+"')");
    }

    function display_details_category(category_name){
        console.log("#category-details-"+category_name);
        $("#category-details-"+category_name).removeClass("hidden").addClass("display");
        document.getElementById("category-header-"+category_name).setAttribute("onClick", "hide_details_category('"+category_name+"')");
    }

    function hide_details_category(category_name){
        $("#category-details-"+category_name).removeClass("display").addClass("hidden");
        document.getElementById("category-header-"+category_name).setAttribute("onClick", "display_details_category('"+category_name+"')");
    }

    function avertissement_categorie(nom){
        if(confirm("Vous allez supprimer une catégorie.")){
            window.location.replace("https://www.bebes-lutins.fr/dashboard/supprimer-categ-"+nom);
        }
        else{
            confirm("Vous n'aller rien supprimer");
        }
    }

    function avertissement_produit(id, categorie){
        if(confirm("Vous allez supprimer un produit.")){
            window.location.replace("https://www.bebes-lutins.fr/?action=SupprimerProduit&id="+id+"&categorie="+categorie);
        }
        else{
            confirm("Vous n'aller rien supprimer");
        }
    }
</script>
</html>