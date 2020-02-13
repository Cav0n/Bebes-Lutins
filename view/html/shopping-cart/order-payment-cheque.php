<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 22:15
 */


$order = (new OrderContainer(unserialize($_SESSION['order'])))->getOrder();

if(isset($_SESSION['user'])) $user = (new UserContainer(unserialize($_SESSION['user'])))->getUser();
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
            <div class='vertical between texts'>
                <div class='name-price'>
                    <p class='name'>$name</p>
                    <p class='price-quantity'>$price x $quantity</p>
                </div>
                <p class='price'>$total_item_price</p>
            </div>
        </div>
        ";
}

$shipping_address = $order->getShippingAddress();

$identity_shipping = ucfirst($shipping_address->getSurname()) . " " . ucfirst($shipping_address->getFirstname());
if($shipping_address->getComplement() != null) $complement_shipping = "<p class='complement'>" . $shipping_address->getComplement(). ", </p>"; else $complement_shipping = "";
if($shipping_address->getCompany() != null) $company_shipping = "<p class='company'>".$shipping_address->getCompany()."</p>"; else $company_shipping = "";

$address_line_shipping = ucfirst($shipping_address->getAddressLine()).", ";
$zip_code_shipping = ($shipping_address->getPostalCode()).", ";
$city_shipping = (ucfirst($shipping_address->getCity()));


$billing_address = $order->getBillingAddress();

$identity_billing = ucfirst($billing_address->getSurname()) . " " . ucfirst($billing_address->getFirstname());
if($billing_address->getComplement() != null) $complement_billing = "<p class='complement'>" . $billing_address->getComplement(). ", </p>"; else $complement_billing = "";
if($billing_address->getCompany() != null) $company_billing = "<p class='company'>".$billing_address->getCompany()."</p>"; else $company_billing = "";

$address_line_billing = ucfirst($billing_address->getAddressLine()).", ";
$zip_code_billing = ($billing_address->getPostalCode()).", ";
$city_billing = (ucfirst($billing_address->getCity()));


$order_address = "
    <p class='address-title'>Adresse de livraison</p>
    <div class='address'>
        $company_shipping
        <p class='identity'>$identity_shipping</p>
        $complement_shipping
        <p class='address-line'>$address_line_shipping</p>
        <p class='zip-code'>$zip_code_shipping</p>
        <p class='city'>$city_shipping</p>
    </div>
    <BR>
    <p class='address-title'>Adresse de facturation</p>
    <div class='address'>
        $company_billing
        <p class='identity'>$identity_billing</p>
        $complement_billing
        <p class='address-line'>$address_line_billing</p>
        <p class='zip-code'>$zip_code_billing</p>
        <p class='city'>$city_billing</p>
    </div>
    ";

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

$new_price = $order->getPriceAfterDiscount();
if($new_price == 0){
    $total_price_to_pay = $order->getTotalPrice() + $order->getShippingPrice();
} else $total_price_to_pay = $new_price;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Paiement par cheque - Bebes Lutins</title>
    <meta name="description" content="Suivez les instructions qui s'affiche à l'écran pour bien effectuer votre paiement par cheque."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>

<main id="shopping-cart-main">
    <div id="payment-wrapper" class="vertical">
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
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="checkout-step-name">
                            Livraison
                        </span>
                    </div>
                </li>
                <li class="checkout-step checkout-step-current">
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

        <div id="payment-inner" class="desktop horizontal centered">
            <div id="payment-container" class="vertical">
                <div id="payment-choice">
                    <p>Merci d'établir votre chèque à l'ordre de : <em>ACTYPOLES</em>.<BR>
                        <BR>
                        Le paiement est à nous faire parvenir à :<BR>
                        Actypoles / Bébés Lutins<BR>
                        4, rue du 19 mars 1962<BR>
                        63300 THIERS<BR>
                        <BR>
                        Montant de votre commande : <b><?php echo str_replace("EUR","€",money_format('%.2i',$total_price_to_pay));?></b>.<BR>
                        <BR>
                        Votre commande sera traitée et expédiée à réception de votre chèque.</p>
                </div>
                <form action="https://www.bebes-lutins.fr/merci-cheque" method="post" id="start-payment" class="vertical centered margin-bottom validate">
                    <p class="small">En cliquant sur le bouton ci-dessous vous acceptez sans réserve les conditions générales de vente.</p>
                    <button id="next-button" class="transition-fast">Valider ma commande</button>
                </form>
            </div>
            <div id="order-summary-container" class="vertical">
                <!-- Récapitulatif commande et bouton pour passer à la suite -->
                <div class="numbers vertical top">
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
                </div>

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

                <div class="order-address vertical">
                    <?php echo $order_address?>
                </div>
            </div>
        </div>

        <div id="payment-inner-mobile" class="mobile vertical">
            <div id="payment-container" class="vertical">
                <div id="payment-choice">
                    <p>Merci d'établir votre chèque à l'ordre de : <em>ACTYPOLES</em>.<BR>
                        <BR>
                        Le paiement est à nous faire parvenir à :<BR>
                        Actypoles / Bébés Lutins<BR>
                        4, rue du 19 mars 1962<BR>
                        63300 THIERS<BR>
                        <BR>
                        Montant de votre commande : <b><?php echo str_replace("EUR","€",money_format('%.2i',$total_price_to_pay));?></b>.<BR>
                        <BR>
                        Votre commande sera traitée et expédiée à réception de votre chèque.</p>
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
                    <form action="https://www.bebes-lutins.fr/merci-cheque" method="post" id="order-summary-prices">
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
                        <button id="next-button" class="transition-fast">Valider ma commande</button>
                    </form>
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

</script>
</html>
