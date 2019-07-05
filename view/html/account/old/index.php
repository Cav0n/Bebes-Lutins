<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:17
 */

$user_container = new UserContainer(unserialize($_SESSION['connected_user']));
$user = $user_container->getUser();

$id = $user->getId();
$surname = $user->getSurname();
$firstname = $user->getFirstname();
$phone_number = $user->getPhone();
$mail = $user->getMail();

if($phone_number != null){
    if(substr($phone_number, 0, 1) != 0) $phone_number = "0" . $phone_number;
} else $phone_number = "";

if(isset($_POST['message'])){
    $message = $_POST['message'];
}


$billing_address_count = 0;
$shipping_address_count = 0;
$billing_address_list = "";
$billing_already = array();
$shipping_already = array();
$shipping_address_list = "";
$number_of_orders = 0;
foreach ($user->getAddressList() as $address){
    $number_of_orders +=1;
    $address = (new AddressContainer($address))->getAddress();
    $address_street = $address->getAddressLine();
    $address_identity = ucfirst($address->getFirstname()) . " " . ucfirst($address->getSurname());
    $address_company = "<p class='company'>" . $address->getCompany() . "</p>";
    $address_firstline = $address->getAddressLine();
    $address_complement = "<p>".$address->getComplement()."</p>";
    $address_secondline = $address->getPostalCode() . "<BR>" .$address->getCity();
    $address_id = $address->getId();

    if(substr($address_id, 0, 15) != 'withdrawal-shop' ){
        if(strpos($address_id, "-billing") && !in_array($address_street, $billing_already)) {
            $billing_address_count++;
            $billing_address_list = $billing_address_list . "
            <div class='address vertical'>
                <p  class='identity'>$address_identity</p>
                $address_company
                <p class='address-line'>$address_firstline</p>
                $address_complement
                <p class='address-line'>$address_secondline</p>
            </div>";
            $billing_already[] = $address_street;
        }
        if(strpos($address_id, "-shipping") && !in_array($address_street, $shipping_already)) {
            $shipping_address_count++;
            $shipping_address_list = $shipping_address_list . "
                <div class='address vertical'>
                    <p  class='identity'>$address_identity</p>
                    $address_company
                    <p class='address-line'>$address_firstline</p>
                    $address_complement
                    <p class='address-line'>$address_secondline</p>
                </div>";
            $shipping_already[] = $address_street;
        }
    }

    if($shipping_address_count = 0) $shipping_address_list = "Vous n'avez aucune adresse de livraison enregistrée sur le site. <BR>Lorsque vous passerez une commande sur le site, l'adresse de livraison et de facturation s'ajouteront automatiquement à vos adresses.";
    if($billing_address_count = 0) $billing_address_list = "Vous n'avez aucune adresse de facturation enregistrée sur le site. <BR>Lorsque vous passerez une commande sur le site, l'adresse de livraison et de facturation s'ajouteront automatiquement à vos adresses.";

}
$orders_list = $user->getOrderList();
$orders_list_display = "";
foreach ($orders_list as $order){
    $order = (new OrderContainer( $order))->getOrder();
    $order_date = date_format(DateTime::createFromFormat('Y-m-d H:i:s', $order->getDate()), 'd - m - Y à H:i');
    $order_price = $order->getTotalPrice();
    $order_shipping_price = $order->getShippingPrice();
    $order_total_price = $order_price + $order_shipping_price;
    $order_status = $order->getStatus();
    $order_status_string = ucfirst($order->statusToString()) .".";
    $order_payment_method = $order->getPaymentMethod();
    $order_id = $order->getId();

    if($order_shipping_price == 0) $order_total_price = str_replace("EUR", '€',money_format('%.2i',$order_total_price));
    else $order_total_price = str_replace("EUR", '€',money_format('%.2i',$order_total_price)) . " (dont ".str_replace("EUR","€", money_format("%.2i",$order_shipping_price)). " de frais de port)";

    if($order_payment_method == 1) $order_payment_method = "carte bancaire"; else $order_payment_method = "chèque bancaire";

    $order_item_list_display = "";
    foreach ($order->getOrderItems() as $order_item){
        $order_item = (new OrderItemContainer($order_item))->getOrderitem();
        $order_item_name = $order_item->getProduct()->getName();
        $order_item_list_display = $order_item_list_display . "<p>$order_item_name</p>";
    }

    $orders_list_display = $orders_list_display . "
        <div class='order vertical' onclick='show_bill(\"$order_id\")'>
            <div class='vertical order-infos'>
                <p class='date'>Commande passée le : $order_date</p>
                <p class='status'>$order_status_string</p>
                <p class='price'>$order_total_price</p>
            </div>
            <div class='order-item-list vertical'>
                $order_item_list_display
            </div>
        </div>
        ";
}
if($orders_list_display == "") $orders_list_display = "<p style='text-align: center;'>Vous n'avez jamais passé de commande.</p>"

?>

<!DOCTYPE html>
<html>
<head>
    <title>Espace client - Bebes Lutins</title>
    <meta name="description" content="Accedez a votre espace client pour suivre vos commandes et mettre a jour vos informations."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <div id="customer-area" class="desktop horizontal centered">
        <div id="tab-container">
            <div id="tabs" class="vertical top">
                <ul id="tab-list">
                    <li id="account" class="selected transition-fast" onclick="new_selection('account')">Mon compte</li>
                    <li id="address" class="non-selected transition-fast" onclick="new_selection('address')">Mes adresses</li>
                    <li id="orders" class="non-selected transition-fast" onclick="new_selection('orders')">Mes commandes</li>
                    <li id="birthlist" class="non-selected transition-fast" onclick="new_selection('birthlist')">Liste de naissance</li>
                </ul>
            </div>
            <form action="https://www.bebes-lutins.fr/espace-client/deconnexion" method="post">
                <button id="logout-button" class="transition-medium" type="submit">Déconnexion</button>
            </form>
        </div>
        <div id="display">
            <div id="disp-account" class="vertical selected">
                <h2><?php echo $firstname ." " . $surname?></h2>
                <form id="informations-change" action="https://www.bebes-lutins.fr/espace-client/modifier-informations" method="post" class="vertical">
                    <div class="horizontal bottom">
                        <label for="surname">Nom : </label>
                        <input required type="text" id="surname" name="surname" value="<?php echo $surname; ?>" placeholder="Dupont">
                    </div>
                    <div class="horizontal bottom">
                        <label for="firstname">Prénom : </label>
                        <input required type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" placeholder="Jean">
                    </div>
                    <div class="horizontal bottom">
                        <label for="phone">Téléphone : </label>
                        <input id="phone" type="tel" name="phone" value="<?php echo $phone_number; ?>" placeholder="06...">
                    </div>
                    <div class="horizontal bottom">
                        <label for="mail">Mail : </label>
                        <input required type="email" id="mail" name="mail" value="<?php echo $mail; ?>" placeholder="jean.dupont@courriel.fr">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <div class="horizontal bottom">
                        <button type="submit">Modifier</button>
                    </div>
                </form>
                <form id="disp-password-change" method="post" action="https://www.bebes-lutins.fr/espace-client/modifier-mot-de-passe">
                    <div class="horizontal top">
                        <p class="big">Modifier mon mot de passe</p>
                    </div>
                    <div class="horizontal bottom">
                        <label for="old-password">Ancien mot de passe :</label>
                        <input required name="old_password" id="old-password" type="password" placeholder="Mot de passe actuel">
                    </div>
                    <div class="horizontal bottom">
                        <label>Nouveau mot de passe :</label>
                        <input required name="new_password" id="new-password" type="password" placeholder="Nouveau mot de passe">
                    </div>
                    <div class="horizontal bottom">
                        <label class="small">Confirmer le nouveau mot de passe :</label>
                        <input required id="new-password" type="password" placeholder="Nouveau mot de passe">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <div class="horizontal bottom">
                        <button type="submit">Modifier</button>
                    </div>
                </form>
                <?php if(isset($_POST['message'])) echo $message;?>
            </div>

            <div id="disp-address" class="vertical non-selected">
                <h2>Mes adresses</h2>
                <div class="horizontal">
                    <div class="address-list">
                        <h3>Adresses de livraison</h3>
                        <?php echo $shipping_address_list;?>
                    </div>
                    <div class="address-list">
                        <h3>Adresses de facturation</h3>
                        <?php echo $billing_address_list; ?>
                    </div>
                </div>
            </div>


            <div id="disp-orders" class="vertical non-selected">
                <h2>Mes commandes</h2>
                <div class="tabs-orders horizontal centered">
                    <p class="order-tab">Commandes en cours</p>
                    <p class="order-tab">Commandes en terminées</p>
                    <p class="order-tab">Commandes annulées</p>
                </div>
                <div class="orders-list">
                    <?php echo $orders_list_display;?>
                </div>
            </div>


            <div id="disp-birthlist" class="vertical non-selected" style="height: 100%;">
                <h2>Ma liste de naissance</h2>
                <p style="    width: 100%;
    height: 100%;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;">Bientôt disponible</p>
            </div>
        </div>
    </div>
    <div id="customer-area-mobile" class="mobile vertical centered">
        <H1>Mon compte</H1>
        <div class="customer-area-bloc vertical">
            <H2>Mes commandes</H2>
            <button onclick="redirect_user_to('commandes')">Afficher mes commandes (<?php echo $number_of_orders;?>)</button>
        </div>
        <div class="customer-area-bloc vertical">
            <H2>Mes informations</H2>
            <div class="user-informations">
                <p><?php echo $firstname . " " . $surname;?></p>
                <p><?php echo $mail;?></p>
                <p><?php echo $phone_number;?></p>
            </div>
            <button onclick="redirect_user_to('mot-de-passe')">Modifier mon mot de passe</button>
            <button>Modifier mes informations</button>
        </div>
        <div class="customer-area-bloc vertical">
            <h2>Mes adresses</h2>
            <button>Ajouter une adresse</button>
            <button>Liste de mes adresses</button>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>

<script>
    function show_bill(id){
        var win = window.open("https://www.bebes-lutins.fr/espace-client/facture/"+id, '_blank');
        win.focus();
    }

    function new_selection(new_selected_id){
        var children_tab = Array.from(document.getElementById("tab-list").children);
        children_tab.forEach(function (entry) {
            entry.setAttribute("class", "non-selected transition-fast");
        });
        $("#"+new_selected_id).removeClass("non-selected").addClass("selected");

        var children_display = Array.from(document.getElementById("display").children);
        children_display.forEach(function (entry) {
            entry.setAttribute("class", "non-selected vertical");
        });
        $("#disp-"+new_selected_id).removeClass("non-selected").addClass("selected");
    }
</script>

<script>
    function redirect_user_to(user_page){
        document.location.href= "https://www.bebes-lutins.fr/espace-client/"+user_page;
    }
</script>
</body>
</html>