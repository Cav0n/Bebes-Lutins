<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 22:05
 */

$shopping_cart_elements_display = "";

$shipping_price = UtilsGateway::getShippingPrice();
$free_shipping_price = UtilsGateway::getFreeShippingPrice();

$total_quantity = 0;
$total_items_price = 0.0;

$shopping_cart = (new ShoppingCartContainer(unserialize($_SESSION['shopping_cart'])))->getShoppingCart();
if(empty($shopping_cart->getShoppingCartItems())){
    $empty = true;
} else {
    $empty = false;
    foreach($shopping_cart->getShoppingCartItems() as $item){
        $item = (new ShoppingCartItemContainer($item))->getShoppingCartItem();
        $id = $item->getId();
        $name = $item->getProduct()->getName();
        $total_quantity += $item->getQuantity();
        $total_items_price += $item->getPrice() * $item->getQuantity();
        if($total_items_price >= $free_shipping_price) $shipping_price = 0.0;

        $quantity_selector = "";
        if($item->getProduct()->getStock() > 15) $stock = 15;
        else $stock = $item->getProduct()->getStock();
        for($i=1; $i<=$stock; $i++){
            if($i == $item->getQuantity()) $quantity_selector = $quantity_selector . "<option value='$i' selected>$i</option>";
            else $quantity_selector = $quantity_selector . "<option value='$i'>$i</option>";
        }

        /*$quantity_selector = "";
        for($i=1;$i < 11; $i++){
            if($i==$item->getQuantity()) $quantity_selector = $quantity_selector . "<option value='$i' selected>$i</option>";
            else $quantity_selector = $quantity_selector . "<option value='$i'>$i</option>";
        }*/

        $image = $item->getProduct()->getImage();
        $categories = "";
        foreach ($item->getProduct()->getCategory() as $category){
            $categories = $categories . $category->getName() . '<BR>';
        }
        $price = UtilsModel::FloatToPrice($item->getPrice() * $item->getQuantity());
        $shopping_cart_elements_display = $shopping_cart_elements_display . "
            <form action='https://www.bebes-lutins.fr/panier/supprimer-produit' method='post' class='shopping-cart-element-wrapper horizontal'>
                <div class='vertical'>
                    <img width='100px' height='100px' src='https://www.bebes-lutins.fr/view/assets/images/products/$image'>
                </div>
                <div class='vertical texts'>
                    <p>$name</p>
                    <p class='categories'>$categories</p>
                    <div class='horizontal'>
                        <p style='margin: auto 0; padding-right: 4px;'>$price - </p>
                        <select name='quantity' onchange='change_quantity(\"$id\", this)'>
                            $quantity_selector
                        </select>
                    </div>
                </div>
                <div class='vertical centered' style='margin-left: auto;'>
                    <input type='hidden' name='element_id' value='$id'>
                    <button type='submit'><i class=\"fas fa-times\"></i></button>
                </div>    
            </form>";
    }
    $total_price = $total_items_price + $shipping_price;
}

/* VOUCHER */
if($shopping_cart->getVoucher() != null){
    $voucher = $shopping_cart->getVoucher();
    switch ($voucher->getType()){
        case 1: //%
            $new_price = ($total_items_price - ($total_items_price * ($voucher->getDiscount() / 100))) + $shipping_price;
            $voucher_description = "<p>- ".$voucher->getDiscount().$voucher->getTypeString()." sur votre commande.</p>";
            break;

        case 2: //€
            $new_price = ($total_items_price - $voucher->getDiscount()) + $shipping_price;
            $voucher_description = "<p>- ".$voucher->getDiscount().$voucher->getTypeString()." sur votre commande.</p>";
            break;

        case 3: //Free shipping price
            $new_shipping_price = 0.00;
            $new_price = $total_items_price + $new_shipping_price;
            $voucher_description = "<p>Frais de port offert pour votre commande.</p>";
            break;
    }
}

$message = $shopping_cart->getMessage();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon panier - Bebes Lutins</title>
    <meta name="description" content="Accédez a votre panier pour passer votre commande."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main id="shopping-cart-main">
    <div id="shopping-cart-wrapper">
        <?php if(!$empty) UtilsModel::load_shopping_cart_stepper();?>
        <div id="shopping-cart-empty" class="vertical <?php if(! $empty) echo 'hidden';?>">
            <form action="https://www.bebes-lutins.fr/" id="empty-infos" class="vertical centered">
                <h1>VOTRE PANIER EST TOTALEMENT VIDE 😢</h1>
                <p>Découvrez vite nos couches, accessoires et lots :</p>
                <button type='submit' >Découvrir nos produits</button>
            </form>
        </div>

        <div id="shopping-cart-content" class="horizontal centered wrap <?php if($empty) echo 'hidden';?> desktop">
            <div class="products">
                <?php echo $shopping_cart_elements_display;?>

                <form method="post" action="https://www.bebes-lutins.fr/panier/ajout-message" id="message-add" class="vertical">
                    <?php echo $_SESSION['message_message'];?>
                    <label for="message-input">Message pour votre commande : </label>
                    <textarea id="message-input" name="message" onkeyup="link_message()" placeholder="Vous pouvez écrire ici des précisions dont vous voudriez nous faire part concernant votre commande."><?php if(isset($message)) echo $message;?></textarea>
                    <button type="submit">Ajouter</button>
                </form>
            </div>
            <div class="vertical">
                <form method="post" action="https://www.bebes-lutins.fr/panier/livraison" class="numbers vertical top">
                    <input id='hidden_post_message' type="hidden" name="message" value="<?php if(isset($message)) echo $message;?>">
                    <div class="horizontal between">
                        <p id="products-number"><?php echo $total_quantity;?> produits</p>
                        <p><?php echo str_replace('EUR', '€', money_format('%.2i', $total_items_price));?></p>
                    </div>
                    <?php if($voucher!=null){ ?>
                    <div class="horizontal between">
                        <p id="discount">Remise :</p>
                        <p><?php echo "- " . $voucher->getDiscountAndTypeString(); ?></p>
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
                    <div id="start-checkout" class="vertical centered margin-bottom">
                        <p class="small">En cliquant sur le bouton ci-dessous vous acceptez sans réserve les conditions générales de vente.</p>
                        <button class="transition-fast">Valider mon panier</button>
                    </div>
                </form>
                <form method="post" action="https://www.bebes-lutins.fr/panier/ajout-coupon" id="voucher-add" class="vertical">
                    <input id='hidden_post_message_coupon' type="hidden" name="message" value="<?php if(isset($message)) echo $message;?>">

                    <?php echo $_SESSION['voucher_message'];?>
                    <?php echo $voucher_description;?>
                    <label for="voucher-input">Code coupon : </label>
                    <input id="voucher-input" type="text" name="voucher" value="<?php if(isset($voucher)) echo $voucher->getName();?>" placeholder="Code de réduction">
                    <button type="submit">Ajouter</button>
                </form>
                <div id="infos-free-shipping" class="<?php if($shipping_price == 0.0) echo 'hidden';?>">
                    <p>Plus que <?php echo str_replace('EUR', '€', money_format('%.2i',$free_shipping_price - $total_items_price));?> pour profiter de le livraison gratuite !</p>
                </div>
            </div>
        </div>

        <div id="shopping-cart-content" class="mobile vertical centered wrap <?php if($empty) echo 'hidden';?>">
            <div class="products">
            <?php
            foreach ($shopping_cart->getShoppingCartItems() as $item){
                $item = (new ShoppingCartItemContainer($item))->getShoppingCartItem();

                $item_id = $item->getId();
                $product_name = $item->getProduct()->getName();
                $product_image = $item->getProduct()->getImage();
                $product_quantity = $item->getQuantity();
                $product_price_x_quantity = UtilsModel::FloatToPrice($item->getPrice() * $item->getQuantity());
                ?>
            <div class="product horizontal">
                <div class="product-image">
                    <img width='100px' height='100px' src='https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product_image;?>'>
                </div>
                <div class="product-texts">
                    <p class="product-name"><?php echo $product_name;?></p>
                    <p class="product-price"><?php echo $product_price_x_quantity;?></p>
                    <select name='quantity' onchange='change_quantity(<?php echo "\"$item_id\""; ?>, this)'>
                        <?php
                        $quantity_selector = "";
                        if($product_quantity > 15) $stock = 15;
                        else $stock = $item->getProduct()->getStock();
                        for($i=1; $i<=$stock; $i++){
                            if($i == $product_quantity) $quantity_selector = $quantity_selector . "<option value='$i' selected>$i</option>";
                            else $quantity_selector = $quantity_selector . "<option value='$i'>$i</option>";
                        }
                        echo $quantity_selector ?>
                    </select>
                </div>
                <button onclick='delete_product(<?php echo "\"$item_id\"";?>)'>X</button>
            </div>
            <?php
            }
            ?>
            </div>
            <div class="infos-free-shipping" class="<?php if($shipping_price == 0.0) echo 'hidden';?>">
                <p>Plus que <?php echo str_replace('EUR', '€', money_format('%.2i',$free_shipping_price - $total_items_price));?> pour profiter de le livraison gratuite !</p>
            </div>
            <div class="voucher">
                <form method="post" action="https://www.bebes-lutins.fr/panier/ajout-coupon" id="voucher-add" class="vertical">
                    <?php echo $_SESSION['voucher_message']; unset($_SESSION['voucher_message']);?>
                    <?php echo $voucher_description;?>
                    <input id="voucher-input" type="text" name="voucher" value="<?php if(isset($voucher)) echo $voucher->getName();?>" placeholder="Code de réduction">
                    <button type="submit">Ajouter</button>
                </form>
            </div>
            <div class="total">
                <form method="post" action="https://www.bebes-lutins.fr/panier/livraison" class="numbers vertical top">
                    <div class="horizontal between total-without-tax">
                        <p id="products-number">Sous-total : </p>
                        <p><?php echo str_replace('EUR', '€', money_format('%.2i', $total_items_price));?></p>
                    </div>
                    <div class="horizontal between shipping-price">
                        <p>Frais de livraison : </p>
                        <p <?php if(isset($voucher) && $voucher->getType() == 3) echo "class='crossed'";?>><?php echo str_replace('EUR', '€', money_format('%.2i', $shipping_price));?></p>
                    </div>
                    <?php if(isset($voucher) && $voucher->getType() == 3){
                        ?>
                        <div class="horizontal between shipping-price">
                            <p>Frais de livraison</p>
                            <p><?php echo str_replace('EUR', '€', money_format('%.2i', $new_shipping_price));?></p>
                        </div>
                        <?php
                    }?>
                    <div class="horizontal between total-with-tax">
                        <p>Total TTC :</p>
                        <p <?php if(isset($voucher)) echo "class='crossed'";?>><?php echo str_replace('EUR', '€', money_format('%.2i', $total_price));?></p>
                    </div>
                    <?php if(isset($voucher)){ ?>
                        <div class="horizontal between total-with-tax">
                            <p>Nouveau total TTC :</p>
                            <p style="font-weight: 600;"><?php echo str_replace('EUR', '€', money_format('%.2i', $new_price));?></p>
                        </div>
                    <?php }?>
                    <div id="start-checkout" class="vertical centered margin-bottom">
                        <p class="small">En cliquant sur le bouton ci-dessous vous acceptez sans réserve les conditions générales de vente.</p>
                        <button class="transition-fast">Valider mon panier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
<script>
    var input_message = document.getElementById('message-input');
    var post_output = document.getElementById('hidden_post_message');
    var post_output_coupon = document.getElementById('hidden_post_message_coupon');

    function link_message(){
        post_output.value = input_message.value;
        post_output_coupon.value = input_message.value;
    }

    var change_quantity = function(id, quantityObject) {
        var quantity = quantityObject.value;
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {id:id, quantity:quantity, action:"shopping_cart_change_quantity"},
            success: function(quantity) {
                document.location.href="https://www.bebes-lutins.fr/panier";
            }
        });
    };

    function delete_product(id){
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {element_id:id, action:"shopping_cart_delete_product"},
            success: function(){
                document.location.href="https://www.bebes-lutins.fr/panier";
            }
        });
    }
</script>
</html>