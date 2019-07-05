<?php

$orders = OrderGateway::GetOrdersFromGateway();

if (isset($_SESSION['connected_user']))
    $administrator = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();

$nb_order = 0;
foreach ($orders as $order){
    if ($order->getStatus() == -1 || $order->getStatus() == -11){
        $nb_order++;
    }
}

?>
<!DOCTYPE html>
<html style="background: #3b3f4d;">
<head>
    <title>ADMINISTRATION - BEBES LUTINS</title>
    <meta name="description" content="Bienvenue dans votre tout nouveau tableau de bord."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="administration">
<?php AdminModel::load_administration_header(); ?>

<main>
    <div id="options">

    </div>
    <div id="disp-orders" class="horizontal between windows-container selected">
        <?php if (isset($_POST['error-message-orders'])) echo $_POST['error-message-orders']; ?>
        <div class="vertical window" id="orders-window">
            <div id="window-tabs-orders" class="horizontal window-tabs">
                <p id="in-preparation-orders" class="tab non-selected transition-fast" onclick="tab_selection_changed_orders('payed')">Commande en attente</p>
                <p id="waiting-for-payments-orders" class="tab non-selected transition-fast" onclick="tab_selection_changed_orders('payment')">Commande en cours de paiement</p>
                <p id="sent-orders" class="tab non-selected transition-fast" onclick="tab_selection_changed_orders('sended')">Commande envoyée</p>
                <p id="canceled-orders" class="tab selected transition-fast" onclick="tab_selection_changed_orders('canceled')">Commande annulée</p>
            </div>
            <div id="display-orders" class="tab-display">
                <div id="disp-in-preparation-orders" class="selected vertical centered orders-list">
                    <?php if ($nb_order <= 0) {?>
                        <p>Il n'y a aucune commande en cours de traitement.</p>
                    <?php } else foreach ($orders as $order) { if ($order->getStatus() == -1 || $order->getStatus() == -11) {
                        $billing_address_string = $order->getBillingAddress()->generateBillingAddressString();
                        $shipping_address_string = $order->getShippingAddress()->generateShippingAddressString();

                        if($order->getBirthlistID() != null){
                            $birthlist_id = $order->getBirthlistID();
                            $shipping_address_string = "La commande fait partie d'une <a target=\"_blank\" rel=\"noopener noreferrer\" href='https://www.bebes-lutins.fr/liste-de-naissance/partage/$birthlist_id'>liste de naissance</a>.";
                        }

                        ?>
                        <div class='order-container vertical'>
                            <div id='order-<?php echo $order->getId(); ?>' class='horizontal between order' onclick='display_details("<?php echo $order->getId(); ?>")'>
                                <div class='horizontal'>
                                    <p class='date'><?php echo $order->getDateString(); ?></p>
                                    <p><?php echo $order->getCustomer()->getFirstname() . " " . $order->getCustomer()->getSurname()?></p>
                                </div>
                                <div class='horizontal'>
                                    <p><?php echo UtilsModel::FloatToPrice($order->getPriceAfterDiscount()); ?> (Frais de port : <?php echo UtilsModel::FloatToPrice($order->getShippingPrice()); ?>)</p>
                                    <p class='payment-method'><?php echo $order->getPaymentMethodMin(); ?></p>
                                    <p class='status status-<?php echo $order->getStatus(); ?>'><?php echo $order->statusToString(); ?></p>
                                </div>
                            </div>
                            <div id='details-<?php echo $order->getId(); ?>' class='vertical order-details hidden'>
                                <div class='order-product-list vertical'>
                                    <?php foreach ($order->getOrderItems() as $orderItem) {
                                        $orderItem = (new OrderItemContainer($orderItem))->getOrderitem(); ?>
                                        <div class='order-product horizontal between'>
                                            <div class='horizontal'>
                                                <img width='40px' height='40px' src='https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $orderItem->getProduct()->getImage(); ?>'>
                                                <p class='vertical centered'><?php echo $orderItem->getProduct()->getName(); ?></p>
                                            </div>
                                            <p class='vertical centered'>(<?php echo UtilsModel::FloatToPrice($orderItem->getUnitPrice()); ?>) x <?php echo $orderItem->getQuantity(); ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class='order-message vertical'>
                                    <p><?php if ($order->getCustomerMessage() != null) {
                                            echo "Message du client : <BR>".$order->getCustomerMessage();
                                        } ?></p>
                                </div>
                                <div class='horizontal between'>
                                    <div class='order-shipping-address-list vertical'>
                                        <p class='address-title'>Adresse de livraison</p>
                                        <?php echo $shipping_address_string; ?>
                                    </div>
                                    <div class='order-billing-address-list vertical'>
                                        <p class='address-title'>Adresse de facturation</p>
                                        <?php echo $billing_address_string; ?>
                                    </div>
                                </div>
                                <form class='horizontal between' action='https://www.bebes-lutins.fr/dashboard/changer-etat' method='post'>
                                    <input type='hidden' name='order_id' value='<?php echo $order->getId();?>'>
                                    <div class='vertical status-modifier'>
                                        <label for='new-status'>Modifier l'état de la commande :</label>
                                        <select id='new-status' name='new-status' <?php if($administrator->getPrivilege() < 4) echo 'disabled'; ?>>
                                            <option value='-1'>Annuler la commande</option>
                                            <option value='0' selected>En attente de paiement</option>
                                            <option value='1'>En cours de traitement</option>
                                            <option value='2'>En cours de livraison</option>
                                            <option value='3'>Livrée</option>
                                        </select>

                                        <label for='admin_message'>Message pour le client :</label>
                                        <textarea id='admin_message' name='admin_message' placeholder='Entrez un message (optionnel) pour le client.'></textarea>
                                        <button type='submit' <?php if($administrator->getPrivilege() < 4) echo 'disabled'; ?>>Modifier</button>
                                    </div>
                                    <div class='vertical bottom bill-link'>
                                        <a target="_blank" rel="noopener noreferrer" href='https://www.bebes-lutins.fr/dashboard/facture-<?php echo $order->getId(); ?>'>Afficher la facture</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } } ?>
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
</main>
</body>
<script>
    function tab_selection_changed_orders(option){
        document.location.href="https://www.bebes-lutins.fr/dashboard/tab/orders/"+option;
    }
</script>
</html>