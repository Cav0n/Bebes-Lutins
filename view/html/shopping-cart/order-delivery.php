<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 22:07
 */

if(isset($_SESSION['redirect_url'])){
    unset($_SESSION['redirect_url']);
}

$order = (new OrderContainer(unserialize($_SESSION['order'])))->getOrder();
$billing_address_count = 0;
$shipping_address_count = 0;

if(isset($_SESSION['connected_user'])) $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
else $user = null;

$total_items_price = $order->getTotalPrice();
$shipping_price = $order->getShippingPrice();
$total_price = $total_items_price + $shipping_price;

$total_quantity = 0;
$order_items = "";
foreach ($order->getOrderItems() as $item){
    $item = (new OrderItemContainer($item))->getOrderitem();
    $total_quantity += $item->getQuantity();
    $name = $item->getProduct()->getName();
    $quantity = $item->getQuantity();
    $image = $item->getProduct()->getImage();
    $price = str_replace("EUR", "€", money_format('%.2i',$item->getUnitPrice()));
    $total_item_price = str_replace("EUR", "€", money_format('%.2i',$item->getUnitPrice() * $quantity));

    $order_items = $order_items . "
        <div class='horizontal product'>
            <img src='https://www.bebes-lutins.fr/view/assets/images/products/$image'>
            <div class='vertical between'>
                <div>
                    <p class='name'>$name</p>
                    <p class='price-quantity'>$price x $quantity</p>
                </div>
                <p class='price'>$total_item_price</p>
            </div>
        </div>
        ";
}

if($user!= null){
    $billing_address_list = "";
    $billing_already = array();
    $shipping_already = array();
    $shipping_address_list = "";
    foreach ($user->getAddressList() as $address){
        $address = (new AddressContainer($address))->getAddress();
        $address_street = $address->getAddressLine();
        $address_id = $address->getId();

        if(substr($address_id, 0, 15) != 'withdrawal-shop' ){
            if(strpos($address_id, "-billing") && !in_array($address_street, $billing_already)) {
                $billing_address_count++;
                $billing_address_list = $billing_address_list . "<option value='$address_id'>$address_street</option>";
                $billing_already[] = $address_street;
            }
            if(strpos($address_id, "-shipping") && !in_array($address_street, $shipping_already)) {
                $shipping_address_count++;
                $shipping_address_list = $shipping_address_list . "<option value='$address_id'>$address_street</option>";
                $shipping_already[] = $address_street;
            }
        }
    }
}

/* VOUCHER */
if($order->getVoucher() != null){
    $voucher = $order->getVoucher();
    $new_price = $order->getPriceAfterDiscount();
    switch ($voucher->getType()){
        case 1: //%
            $voucher_description = "<p>- ".$voucher->getDiscount().$voucher->getTypeString()." sur votre commande.</p>";
            break;

        case 2: //€
            $voucher_description = "<p>- ".$voucher->getDiscount().$voucher->getTypeString()." sur votre commande.</p>";
            break;

        case 3: //Free shipping price
            $new_shipping_price = 0.00;
            $voucher_description = "<p>Frais de port offert pour votre commande.</p>";
            break;
    }
}

$total_price_string = UtilsModel::FloatToPrice($order->getPriceAfterDiscount());

?>

<!DOCTYPE html>
<html>
<head>
    <title>Livraison - Bebes Lutins</title>
    <meta name="description" content="Veuillez nous indiquer l'adresse de livraison de votre commande."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>

<main id="shopping-cart-main">
    <div id="delivery-wrapper" class="vertical">
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
                            2
                        </span>
                        <span class="checkout-step-name">
                            Livraison
                        </span>
                    </div>
                </li>
                <li class="checkout-step">
                    <div class="checkout-step-inner vertical">
                        <span class="checkout-step-number">
                            3
                        </span>
                        <span class="checkout-step-name">
                            Paiement
                        </span>
                    </div>
                </li>
            </ul>
        </div>
        <div id="delivery-inner" class="desktop horizontal centered wrap">
            <div id="delivery-choice-container" class="vertical">
                <div class="delivery-choice vertical">
                <!-- choix de la livraison sous formes d'onglets-->
                <ul id="tab-list" class="horizontal centered">
                    <li id="new-address" class="<?php if($user != null && $billing_address_count > 0 && $shipping_address_count > 0) echo "non-";?>selected transition-fast" onclick="new_selection('new-address')">Nouvelle adresse</li>
                    <li id="previous-address<?php if($user == null || ($billing_address_count == 0 || $shipping_address_count == 0)) echo '-hidden';?>" class="<?php if($user == null || ($billing_address_count == 0 || $shipping_address_count == 0)) echo "non-";?>selected transition-fast" onclick="new_selection('previous-address')">Vos adresses</li>
                    <li id="withdrawal-shop" class="non-selected transition-fast" onclick="new_selection('withdrawal-shop')">Retrait à l'atelier</li>
                </ul>
                <div id="display" class="content">
                    <!-- un second div où la personne peut rentrer une nouvelle adresse -->
                    <!-- case a cocher pour demander une adresse de facturation différente -->
                    <div id='disp-new-address' class="<?php if($user != null && $billing_address_count > 0 && $shipping_address_count > 0) echo "non-";?>selected">
                        <form id="new-address-form" class="vertical" method="post" action="https://www.bebes-lutins.fr/panier/paiement">
                            <input type="hidden" name="address_type" value="new">
                            <div id="infos" class="horizontal centered">
                                <p>Les champs avec un astérisque (*) sont obligatoires.</p>
                            </div>
                            <div id="contact-infos" class="vertical <?php if($user!=null || $address_count = 0) echo 'hidden'?>">
                                <label for="mail">Mail * : </label>
                                <input type="email" name="mail" placeholder="Adresse email" id="mail" <?php if($user==null)echo 'required'?>>
                                <label for="phone">Téléphone : </label>
                                <input type="tel" name="phone" placeholder="Numéro de téléphone" id="phone">
                            </div>

                            <div id="billing-address" class="vertical">
                                <p class="subtitle-form">Adresse de facturation</p>
                                <label for="civility_billing">Civilité * : </label>
                                <select id='civility_billing' name="civility_billing" required>
                                    <option value="1">Monsieur</option>
                                    <option value="2">Madame</option>
                                </select>
                                <label for="surname_billing">Nom * : </label>
                                <input type="text" name="surname_billing" placeholder="Nom du destinataire" id="surname_billing" required>
                                <label for="firstname_billing">Prénom * : </label>
                                <input type="text" name="firstname_billing" placeholder="Prénom du destinataire" id="firstname_billing" required>
                                <label for="street_billing">Adresse * : </label>
                                <input type="text" name="street_billing" placeholder="Numéro et rue" id="street_billing" required>
                                <label for="complement_billing">Compléments : </label>
                                <input type="text" name="complement_billing" placeholder="Etage, batiment..." id="complement_billing">
                                <label for="zip_code_billing">Code postal * : </label>
                                <input type="number" name="zip_code_billing" placeholder="Code postal" id="zip_code_billing" max="95880" min="01000" step="1" required>
                                <label for="city_billing">Ville * : </label>
                                <input type="text" name="city_billing" placeholder="Ville" id="city_billing" required>
                                <label for="company_billing">Entreprise : </label>
                                <input type="text" name="company_billing" placeholder="Entreprise" id="company_billing">

                                <div id="checkbox_shipping" class="horizontal centered">
                                    <input id="shipping_address_checkbox" type="checkbox" name="same_shipping_address" value="yes" onclick="shipping_checked('checked')" checked>
                                    <label for="shipping_address_checkbox" class="noselect" style="all:unset">Même adresse de livraison</label>
                                </div>
                            </div>
                            <div id="shipping-address" class="vertical hidden">
                                <p class="subtitle-form">Adresse de livraison</p>
                                <label for="civility_shipping">Civilité * : </label>
                                <select id='civility_shipping' name="civility_shipping">
                                    <option value="1">Monsieur</option>
                                    <option value="2">Madame</option>
                                </select>
                                <label for="surname_shipping">Nom * : </label>
                                <input type="text" name="surname_shipping" placeholder="Nom du destinataire" id="surname_shipping" >
                                <label for="firstname_shipping">Prénom * : </label>
                                <input type="text" name="firstname_shipping" placeholder="Prénom du destinataire" id="firstname_shipping" >
                                <label for="street_shipping">Adresse * : </label>
                                <input type="text" name="street_shipping" placeholder="Numéro et rue" id="street_shipping" >
                                <label for="complement_shipping">Compléments : </label>
                                <input type="text" name="complement_shipping" placeholder="Etage, batiment..." id="complement_shipping">
                                <label for="zip-code_shipping">Code postal * : </label>
                                <input type="number" name="zip_code_shipping" placeholder="Code postal" id="zip_code_shipping" max="95880" min="01000" step="1" >
                                <label for="city_shipping">Ville * : </label>
                                <input type="text" name="city_shipping" placeholder="Ville" id="city_shipping" >
                                <label for="company_shipping">Entreprise : </label>
                                <input type="text" name="company_shipping" placeholder="Entreprise" id="company_shipping">
                            </div>
                        </form>
                    </div>
                    <!-- un premier div avec le choix d'une des adresses du client si il en a déjà -->
                    <div id='disp-previous-address' class="<?php if($user == null || ($billing_address_count == 0 || $shipping_address_count == 0)) echo "non-";?>selected <?php if($user == null || ($billing_address_count == 0 && $shipping_address_count == 0) ) echo 'hidden';?>">
                        <form action="https://www.bebes-lutins.fr/panier/paiement" id="previous-address-form" method="post" class="vertical">
                            <input type="hidden" name="address_type" value="selected">

                            <p class="big">Adresse de facturation :</p>
                            <label for="billing-address-selector">Choisissez une de vos adresses :</label>
                            <select id="billing-address-selector" name="billing_address_selected_id">
                                <?php echo $billing_address_list;?>
                            </select>

                            <p class="big">Adresse de livraison :</p>
                            <label for="shipping-address-selector">Choisissez une de vos adresses :</label>
                            <select id="shipping-address-selector" name="shipping_address_selected_id">
                                <?php echo $shipping_address_list;?>
                            </select>

                        </form>
                    </div>
                    <!-- un dernier div pour pouvoir venir chercher la commande directement chez Bébés Lutins -->
                    <div id='disp-withdrawal-shop' class="non-selected">
                        <form id="withdrawal-shop-form" method="post" action="https://www.bebes-lutins.fr/panier/paiement">
                            <p>Dès que votre commande sera prète nous vous enverrons un mail (et un SMS si vous indiquez votre numéro de téléphone). Vous pourrez venir la chercher à notre atelier de 9h à 16h.</p>
                            <div class="shop-address">
                                <p>Adresse de l'atelier : </p>
                                <p>
                                    <em>Bébés Lutins - Actypoles<BR>
                                        Rue du 19 Mars 1962<BR>
                                        63550 THIERS</em>
                                </p>
                            </div>
                            <div id="infos" class="horizontal centered">
                                <p>Les champs avec un astérisque (*) sont obligatoires.</p>
                            </div>
                            <div class="inputs vertical">
                                <input type="hidden" name="address_type" value="withdrawal-shop">

                                <label for="mail">Adresse mail * :</label>
                                <input id='mail' name='mail' type="email" placeholder="Votre adresse mail" required>
                                <label for="phone">Numéro de téléphone :</label>
                                <input id="phone" name='phone' type="tel" placeholder="Votre numéro de téléphone">
                                <label for="civility_billing">Civilité * : </label>
                                <select id='civility_billing' name="civility_billing" >
                                    <option value="1">Monsieur</option>
                                    <option value="2">Madame</option>
                                </select>
                                <label for="surname_billing">Nom * : </label>
                                <input type="text" name="surname_billing" placeholder="Votre nom" id="surname_billing" required>
                                <label for="firstname_billing">Prénom * : </label>
                                <input type="text" name="firstname_billing" placeholder="Votre prénom" id="firstname_billing" required>
                                <p class="subtitle-form">Adresse de facturation</p>
                                <label for="street_billing">Adresse * : </label>
                                <input type="text" name="street_billing" placeholder="Numéro et rue" id="street_billing" required>
                                <label for="complement_billing">Compléments : </label>
                                <input type="text" name="complement_billing" placeholder="Etage, batiment..." id="complement_billing">
                                <label for="zip_code_billing">Code postal * : </label>
                                <input type="number" name="zip_code_billing" placeholder="Code postal" id="zip_code_billing" max="95880" min="01000" step="1" required>
                                <label for="city_billing">Ville * : </label>
                                <input type="text" name="city_billing" placeholder="Ville" id="city_billing" required>
                                <label for="company_billing">Entreprise : </label>
                                <input type="text" name="company_billing" placeholder="Entreprise" id="company_billing">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
                <div id='map-container' class="delivery-choice vertical non-selected">
                    <div id="map" style="width: 100%;height: 200px"></div>
                </div>
            </div>
            <div class="order-summary vertical">
                <!-- Puis récap comme dans le panier -->
                <form method="post" action="?action=load_delivery" class="numbers vertical top">
                    <div class="horizontal between">
                        <p id="products-number"><?php echo $total_quantity;?> produits</p>
                        <p><?php echo str_replace('EUR', '€', money_format('%.2i', $total_items_price));?></p>
                    </div>
                    <?php if($voucher!=null){ ?>
                    <div class="horizontal between">
                        <p id="discount">Remise :</p>
                        <p><?php echo "- " . $voucher->getDiscountAndTypeString(); ?> <?php if($discount_value != null) echo " (- " . UtilsModel::FloatToPrice($discount_value) . ")" ; ?></p>
                    </div>
                    <?php } ?>
                    <div class="horizontal between">
                        <p>Frais de ports</p>
                        <p <?php if(isset($voucher) && $voucher->getType() == 3) echo "class='crossed'";?>><?php echo str_replace('EUR', '€', money_format('%.2i', $shipping_price));?></p>
                    </div>
                    <?php if(isset($voucher) && $voucher->getType() == 3){
                        ?>
                        <div class="horizontal between">
                            <p>Frais de ports</p>
                            <p><?php echo str_replace('EUR', '€', money_format('%.2i', $new_shipping_price));?></p>
                        </div>
                        <?php
                    }?>
                    
                    <?php if($voucher == null) { ?>
                    <div class="horizontal between">
                        <p>Total TTC :</p>
                        <p><b><?php echo str_replace('EUR', '€', money_format('%.2i', $total_price));?></b></p>
                    </div>
                    <?php } else { ?>
                    <div class="horizontal between">
                        <p>Total TTC :</p>
                        <p><b><?php echo str_replace('EUR', '€', money_format('%.2i', $new_price));?></b></p>
                    </div>
                    <?php } ?>
                    <div id="start-payment" class="vertical centered margin-bottom">
                        <p class="small">En cliquant sur le bouton ci-dessous vous acceptez sans réserve les conditions générales de vente.</p>
                        <button id="next-button" class="transition-fast" form="<?php if($user == null || ($billing_address_count == 0 || $shipping_address_count == 0)) echo 'new-address-form';?><?php if($user != null && $billing_address_count > 0 && $shipping_address_count > 0) echo "previous-address-form";?>">Passer au paiement</button>
                    </div>
                </form>

                <div id="voucher" class="vertical <?php if(!isset($voucher)) echo 'hidden';?>">
                    <?php echo $_SESSION['voucher_message']; unset($_SESSION['voucher_message']);?>
                    <?php echo $voucher_description;?>
                    <label for="voucher-input">Code coupon : </label>
                    <input id="voucher-input" type="text" name="voucher" value="<?php if(isset($voucher)) echo $voucher->getName();?>" placeholder="Code de réduction" disabled>
                </div>

                <div class="order-items vertical">
                    <!-- Afficher la liste des produits (image a gauche, div a droite contenant le nom aligné a gauche en haut, et le prix aligné a droite en bas avec la qte entre parenthèse)-->
                    <?php echo $order_items;?>
                </div>

                <div class="vertical">
                    <form method="post" action="https://www.bebes-lutins.fr/panier">
                        <button class="back-button">Retour</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="delivery-inner" class="mobile horizontal centered wrap">
            <div id="delivery-choice-container">
                <div id="delivery-choice">
                    <ul id="tab-list-mobile" class="horizontal centered">
                        <li id="new-address-mobile" class="<?php if($user != null && $billing_address_count > 0 && $shipping_address_count > 0) echo "non-";?>selected transition-fast" onclick="new_selection_mobile('new-address-mobile')">Nouvelle adresse</li>
                        <li id="previous-address-mobile<?php if($user == null || ($billing_address_count == 0 || $shipping_address_count == 0)) echo '-hidden';?>" class="<?php if($user == null || ($billing_address_count == 0 || $shipping_address_count == 0)) echo "non-";?>selected transition-fast" onclick="new_selection_mobile('previous-address-mobile')" >Vos adresses</li>
                        <li id="withdrawal-shop-mobile" class="non-selected transition-fast" onclick="new_selection_mobile('withdrawal-shop-mobile')">Retrait à l'atelier</li>
                    </ul>
                    <div id="display-mobile">
                        <div id="disp-new-address-mobile" class="<?php if($user != null && $billing_address_count > 0 && $shipping_address_count > 0) echo "non-";?>selected">
                            <form id="new-address-mobile-form" class="vertical" method="post" action="https://www.bebes-lutins.fr/panier/paiement">
                                <input type="hidden" name="address_type" value="new">
                                <div id="infos" class="horizontal centered">
                                    <p>Les champs avec un astérisque (*) sont obligatoires.</p>
                                </div>
                                <div id="contact-infos" class="vertical <?php if($user!=null || $address_count = 0) echo 'hidden'?>">
                                    <label for="mail">Mail * : </label>
                                    <input type="email" name="mail" placeholder="Adresse email" id="mail" <?php if($user==null)echo 'required'?>>
                                    <label for="phone">Téléphone : </label>
                                    <input type="tel" name="phone" placeholder="Numéro de téléphone" id="phone">
                                </div>

                                <div id="billing-address" class="vertical">
                                    <p class="subtitle-form">Adresse de facturation</p>
                                    <label for="civility_billing">Civilité * : </label>
                                    <select id='civility_billing' name="civility_billing" required>
                                        <option value="1">Monsieur</option>
                                        <option value="2">Madame</option>
                                    </select>
                                    <label for="surname_billing">Nom * : </label>
                                    <input type="text" name="surname_billing" placeholder="Nom du destinataire" id="surname_billing" required>
                                    <label for="firstname_billing">Prénom * : </label>
                                    <input type="text" name="firstname_billing" placeholder="Prénom du destinataire" id="firstname_billing" required>
                                    <label for="street_billing">Adresse * : </label>
                                    <input type="text" name="street_billing" placeholder="Numéro et rue" id="street_billing" required>
                                    <label for="complement_billing">Compléments : </label>
                                    <input type="text" name="complement_billing" placeholder="Etage, batiment..." id="complement_billing">
                                    <label for="zip_code_billing">Code postal * : </label>
                                    <input type="number" name="zip_code_billing" placeholder="Code postal" id="zip_code_billing" max="95880" min="01000" step="1" required>
                                    <label for="city_billing">Ville * : </label>
                                    <input type="text" name="city_billing" placeholder="Ville" id="city_billing" required>
                                    <label for="company_billing">Entreprise : </label>
                                    <input type="text" name="company_billing" placeholder="Entreprise" id="company_billing">

                                    <div id="checkbox_shipping" class="horizontal centered">
                                        <input id="shipping_address_checkbox_mobile" type="checkbox" name="same_shipping_address" value="yes" onclick="shipping_checked_mobile('checked')" checked>
                                        <label for="shipping_address_checkbox_mobile" class="noselect" style="all:unset">Même adresse de livraison</label>
                                    </div>
                                </div>
                                <div id="shipping-address-mobile" class="vertical hidden">
                                    <p class="subtitle-form">Adresse de livraison</p>
                                    <label for="civility_shipping_mobile">Civilité * : </label>
                                    <select id='civility_shipping_mobile' name="civility_shipping">
                                        <option value="1">Monsieur</option>
                                        <option value="2">Madame</option>
                                    </select>
                                    <label for="surname_shipping_mobile">Nom * : </label>
                                    <input type="text" name="surname_shipping" placeholder="Nom du destinataire" id="surname_shipping_mobile" >
                                    <label for="firstname_shipping_mobile">Prénom * : </label>
                                    <input type="text" name="firstname_shipping" placeholder="Prénom du destinataire" id="firstname_shipping_mobile" >
                                    <label for="street_shipping_mobile">Adresse * : </label>
                                    <input type="text" name="street_shipping" placeholder="Numéro et rue" id="street_shipping_mobile" >
                                    <label for="complement_shipping_mobile">Compléments : </label>
                                    <input type="text" name="complement_shipping" placeholder="Etage, batiment..." id="complement_shipping_mobile">
                                    <label for="zip_code_shipping_mobile">Code postal * : </label>
                                    <input type="number" name="zip_code_shipping" placeholder="Code postal" id="zip_code_shipping_mobile" max="95880" min="01000" step="1" >
                                    <label for="city_shipping_mobile">Ville * : </label>
                                    <input type="text" name="city_shipping" placeholder="Ville" id="city_shipping_mobile" >
                                    <label for="company_shipping_mobile">Entreprise : </label>
                                    <input type="text" name="company_shipping" placeholder="Entreprise" id="company_shipping_mobile">
                                </div>
                            </form>
                        </div>
                        <div id='disp-previous-address-mobile' class="<?php if($user == null || ($billing_address_count == 0 || $shipping_address_count == 0)) echo "non-";?>selected <?php if($user == null || ($billing_address_count == 0 && $shipping_address_count == 0) ) echo 'hidden';?>">
                            <form action="https://www.bebes-lutins.fr/panier/paiement" id="previous-address-mobile-form" method="post" class="vertical">
                                <input type="hidden" name="address_type" value="selected">

                                <p class="big">Adresse de facturation :</p>
                                <label for="billing-address-selector">Choisissez une de vos adresses :</label>
                                <select id="billing-address-selector" name="billing_address_selected_id">
                                    <?php echo $billing_address_list;?>
                                </select>

                                <p class="big">Adresse de livraison :</p>
                                <label for="shipping-address-selector">Choisissez une de vos adresses :</label>
                                <select id="shipping-address-selector" name="shipping_address_selected_id">
                                    <?php echo $shipping_address_list;?>
                                </select>

                            </form>
                        </div>
                        <div id='disp-withdrawal-shop-mobile' class="non-selected">
                            <form id="withdrawal-shop-mobile-form" method="post" action="https://www.bebes-lutins.fr/panier/paiement">
                                <p>Dès que votre commande sera prète nous vous enverrons un mail (et un SMS si vous indiquez votre numéro de téléphone). Vous pourrez venir la chercher à notre atelier de 9h à 16h.</p>
                                <div class="shop-address">
                                    <p>Adresse de l'atelier : </p>
                                    <p>
                                        <em>Bébés Lutins - Actypoles<BR>
                                            Rue du 19 Mars 1962<BR>
                                            63550 THIERS</em>
                                    </p>
                                </div>
                                <div id='map-container-mobile' class="delivery-choice vertical non-selected">
                                    <div id="map-mobile" style="width: 100%;height: 200px"></div>
                                </div>
                                <div id="infos" class="horizontal centered">
                                    <p>Les champs avec un astérisque (*) sont obligatoires.</p>
                                </div>
                                <div class="inputs vertical">
                                    <input type="hidden" name="address_type" value="withdrawal-shop">

                                    <label for="mail">Adresse mail * :</label>
                                    <input id='mail' name='mail' type="email" placeholder="Votre adresse mail" required>
                                    <label for="phone">Numéro de téléphone :</label>
                                    <input id="phone" name='phone' type="tel" placeholder="Votre numéro de téléphone">
                                    <label for="civility_billing">Civilité * : </label>
                                    <select id='civility_billing' name="civility_billing" >
                                        <option value="1">Monsieur</option>
                                        <option value="2">Madame</option>
                                    </select>
                                    <label for="surname_billing">Nom * : </label>
                                    <input type="text" name="surname_billing" placeholder="Votre nom" id="surname_billing" >
                                    <label for="firstname_billing">Prénom * : </label>
                                    <input type="text" name="firstname_billing" placeholder="Votre prénom" id="firstname_billing" >
                                    <p class="subtitle-form">Adresse de facturation</p>
                                    <label for="street_billing">Adresse * : </label>
                                    <input type="text" name="street_billing" placeholder="Numéro et rue" id="street_billing" >
                                    <label for="complement_billing">Compléments : </label>
                                    <input type="text" name="complement_billing" placeholder="Etage, batiment..." id="complement_billing">
                                    <label for="zip_code_billing">Code postal * : </label>
                                    <input type="number" name="zip_code_billing" placeholder="Code postal" id="zip_code_billing" max="95880" min="01000" step="1" >
                                    <label for="city_billing">Ville * : </label>
                                    <input type="text" name="city_billing" placeholder="Ville" id="city_billing" >
                                    <label for="company_billing">Entreprise : </label>
                                    <input type="text" name="company_billing" placeholder="Entreprise" id="company_billing">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="order" class="vertical">
                    <div id="order-summary" class="vertical">
                        <div id="order-summary-header">
                            <p><b><?php echo $total_quantity;?> produits </b>- <?php echo $total_price_string;?></p>
                        </div>
                        <div id="order-summary-products">
                            <?php foreach ($order->getOrderItems() as $order_item) {
                                $order_item = (new OrderItemContainer($order_item))->getOrderitem();
                                $product_image = $order_item->getProduct()->getImage();
                                $product_name = $order_item->getProduct()->getName();
                                $product_quantity = $order_item->getQuantity();
                                $product_price = UtilsModel::FloatToPrice($order_item->getUnitPrice() * $order_item->getQuantity());
                                ?>
                                <div class="product horizontal">
                                    <span class="product-image">
                                        <img src='https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product_image?>'>
                                    </span>
                                    <div class="product-texts vertical">
                                        <p class="product-name"><?php echo $product_name;?></p>
                                        <p class="product-price"><?php echo $product_quantity;?> x <?php echo $product_price;?></p>
                                    </div>
                                </div>
                                <?php
                            }?>
                        </div>
                        <div id="order-summary-prices">
                            <div class="horizontal between">
                                <p id="products-number">Total HT : </p>
                                <p><?php echo str_replace('EUR', '€', money_format('%.2i', $total_items_price));?></p>
                            </div>
                            <div class="horizontal between">
                                <p>Frais de ports</p>
                                <p <?php if(isset($voucher) && $voucher->getType() == 3) echo "class='crossed'";?>><?php echo str_replace('EUR', '€', money_format('%.2i', $shipping_price));?></p>
                            </div>
                            <?php if(isset($voucher) && $voucher->getType() == 3){
                                ?>
                                <div class="horizontal between">
                                    <p>Frais de ports</p>
                                    <p><?php echo str_replace('EUR', '€', money_format('%.2i', $new_shipping_price));?></p>
                                </div>
                                <?php
                            }?>
                            <div class="horizontal between">
                                <p><b>Total TTC :</b></p>
                                <p <?php if(isset($voucher)) echo "class='crossed'";?>><b><?php echo str_replace('EUR', '€', money_format('%.2i', $total_price));?></b></p>
                            </div>
                            <?php if(isset($voucher)){ ?>
                                <div class="horizontal between">
                                    <p><b>Nouveau total TTC :</b></p>
                                    <p style="font-weight: 600;"><b><?php echo str_replace('EUR', '€', money_format('%.2i', $new_price));?></b></p>
                                </div>
                            <?php }?>
                            <button id="next-button-mobile" class="transition-fast" form="<?php if($user == null || ($billing_address_count == 0 || $shipping_address_count == 0)) echo 'new-address-mobile-form';?><?php if($user != null && $billing_address_count > 0 && $shipping_address_count > 0) echo "previous-address-mobile-form";?>">Passer au paiement</button>
                        </div>
                    </div>
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

        if(new_selected_id == "withdrawal-shop"){
            $("#map-container").removeClass("non-selected").addClass("selected");
            $("#shipping-price").addClass("crossed");
        }
        else{
            $("#shipping-price").removeClass("crossed");
            $("#map-container").removeClass("selected").addClass("non-selected");
        }

        document.getElementById("next-button").setAttribute('form',new_selected_id+"-form")
    }

    function new_selection_mobile(new_selected_id){
        var children_tab = Array.from(document.getElementById("tab-list-mobile").children);
        children_tab.forEach(function (entry) {
            entry.setAttribute("class","non-selected transition-fast");
        });
        $("#"+new_selected_id).removeClass("non-selected").addClass("selected");

        var children_display = Array.from(document.getElementById("display-mobile").children);
        children_display.forEach(function (entry) {
            entry.setAttribute("class", "non-selected vertical");
        });
        $("#disp-"+new_selected_id).removeClass("non-selected").addClass("selected");

        document.getElementById("next-button-mobile").setAttribute('form',new_selected_id+"-form")

        if(new_selected_id == "withdrawal-shop-mobile"){
            $("#map-container-mobile").removeClass("non-selected").addClass("selected");
            $("#shipping-price").addClass("crossed");
        }
        else{
            $("#shipping-price").removeClass("crossed");
            $("#map-container-mobile").removeClass("selected").addClass("non-selected");
        }
    }

    function initMap() {
        var uluru = {lat: 45.844297, lng: 3.524763};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: uluru
        });
        var map2 = new google.maps.Map(document.getElementById('map-mobile'), {
            zoom: 10,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
        var marker2 = new google.maps.Marker({
            position: uluru,
            map: map2
        });
    }

    function shipping_checked(state){
        if(state=='checked'){
            document.getElementById("shipping_address_checkbox").checked = false;
            $("#shipping-address").removeClass('hidden').addClass('display');

            document.getElementById("civility_shipping").required = true;
            document.getElementById("surname_shipping").required = true;
            document.getElementById("firstname_shipping").required = true;
            document.getElementById("street_shipping").required = true;
            document.getElementById("zip_code_shipping").required = true;
            document.getElementById("city_shipping").required = true;

            document.getElementById("shipping_address_checkbox").setAttribute('onclick', 'shipping_checked("not-checked")')
        } else {
            document.getElementById("shipping_address_checkbox").checked = true
            $("#shipping-address").removeClass('display').addClass('hidden');

            document.getElementById("civility_shipping").required = false;
            document.getElementById("surname_shipping").required = false;
            document.getElementById("firstname_shipping").required = false;
            document.getElementById("street_shipping").required = false;
            document.getElementById("zip_code_shipping").required = false;
            document.getElementById("city_shipping").required = false;

            document.getElementById("shipping_address_checkbox").setAttribute('onclick', 'shipping_checked("checked")')
        }
    }

    function shipping_checked_mobile(state){
        if(state=='checked'){
            document.getElementById("shipping_address_checkbox_mobile").checked = false;
            $("#shipping-address-mobile").removeClass('hidden').addClass('display');

            document.getElementById("civility_shipping_mobile").required = true;
            document.getElementById("surname_shipping_mobile").required = true;
            document.getElementById("firstname_shipping_mobile").required = true;
            document.getElementById("street_shipping_mobile").required = true;
            document.getElementById("zip_code_shipping_mobile").required = true;
            document.getElementById("city_shipping_mobile").required = true;

            document.getElementById("shipping_address_checkbox_mobile").setAttribute('onclick', 'shipping_checked_mobile("not-checked")')
        } else {
            document.getElementById("shipping_address_checkbox_mobile").checked = true
            $("#shipping-address-mobile").removeClass('display').addClass('hidden');

            document.getElementById("civility_shipping_mobile").required = false;
            document.getElementById("surname_shipping_mobile").required = false;
            document.getElementById("firstname_shipping_mobile").required = false;
            document.getElementById("street_shipping_mobile").required = false;
            document.getElementById("zip_code_shipping_mobile").required = false;
            document.getElementById("city_shipping_mobile").required = false;

            document.getElementById("shipping_address_checkbox_mobile").setAttribute('onclick', 'shipping_checked_mobile("checked")')
        }
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5Pnw_Hl2G8f5ETGsTWRhX6bjC1HMz8QI&callback=initMap">
</script>
</html>
