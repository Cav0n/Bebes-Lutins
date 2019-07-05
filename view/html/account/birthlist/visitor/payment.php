<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:31
 */

$products = ProductGateway::GetProducts();
$categories = CategoryGateway::GetCategories();

$birthlist = BirthlistGateway::GetBirthlistByID($_GET['birthlist_id']);
$selected_items = unserialize($_SESSION['selected_items']);

$total_items_count = 0;
$total_items_price = 0;

$address = (new AddressContainer(unserialize($_SESSION['address_billing'])))->getAddress();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Liste de naissance - Bebes Lutins</title>
    <meta name="description" content="Achetez les produits que vous souhaitez pour <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?> . Vous pouvez choisir la quantité à acheter,
                la quantité optimale a été choisis par <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?> ."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>

<main class="vertical">
    <div id="birthlist-visitor-container" class="vertical">
        <div id="birthlist-header" class="vertical">
            <h1>Liste de naissance de <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?></h1>
            <h2><?php echo $birthlist->getMessage(); ?></h2>
        </div>
        <div id="birthlist-inner" class="vertical">
            <div id="birthlist-explanation">
                <p>Voici un récapitulatif de ce que vous avez choisi d'acheter pour la liste de naissance de <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName();?>. Vous pouvez passer au paiement si cela vous convient ou vous pouvez annuler.</p>
                <div id="birthlist-final-summary-container" class="horizontal centered">
                    <div id="product-summary" class="birthlist-final-summary-inner vertical">
                        <h3>PRODUITS :</h3>
                        <div id="birthlist-products-container">
                            <div id="birthlist-items" class="horizontal wrap">
                                <?php
                                foreach ($selected_items as $item) {
                                    $item = (new BirthListItemContainer($item))->getBirthlistItem();
                                    foreach ($products as $product) {
                                        if ($product->getId() == $item->getProduct()->getId()) {
                                            $item_product = $product;
                                            break;
                                        }
                                    }

                                    $item_id = $item->getId();
                                    $product_name = $item_product->getName();
                                    $product_id = $item_product->getId();
                                    $product_image = $item_product->getImage();
                                    $product_price = $item_product->getPrice();
                                    $product_quantity = $item->getQuantity();

                                    $total_items_count++;
                                    $total_items_price += ($product_price * $product_quantity);
                                    ?>
                                    <div class="item horizontal">
                                        <div class="category-item-image-container">
                                            <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" title="<?php echo $product_name; ?>">
                                        </div>
                                        <div class="category-item-texts-container horizontal transition-fast">
                                            <div class="item-texts vertical">
                                                <p class="item-name"><?php echo $product_name; ?></p>
                                                <div class="item-bottom horizontal between">
                                                    <p><?php echo UtilsModel::FloatToPrice($product_price); ?></p>
                                                    <div class="quantity horizontal">
                                                        <label for="quantity">Quantité : </label>
                                                        <select id="quantity" name='quantities[]' disabled>
                                                            <?php
                                                            $quantity_selector = "";
                                                            $quantity_max = $item->getQuantity();
                                                            if($quantity_max > 15) $quantity_max = 15;
                                                            for($i=1; $i<=$quantity_max; $i++){
                                                                $i_value = $i."_".$item_id;
                                                                if($i == $product_quantity) $quantity_selector = $quantity_selector . "<option value='$i_value' selected>$i</option>";
                                                                else $quantity_selector = $quantity_selector . "<option value='$i_value'>$i</option>";
                                                            }
                                                            echo $quantity_selector ?>
                                                        </select>
                                                    </div>
                                                    <p>Total : <?php echo UtilsModel::FloatToPrice($product_price * $product_quantity);?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div id="informations-summary" class="birthlist-final-summary-inner vertical">
                        <div id="birthlist-address-container">
                            <H3>FACTURÉ À :</H3>
                            <div class="address-container">
                                <p class="company <?php if($address->getCompany() == null) echo 'hidden'; ?>"><?php echo $address->getCompany(); ?></p>
                                <p class='identity'><?php echo $address->getCivilityString() . " " . ucfirst($address->getFirstname()) . " " . strtoupper($address->getSurname()); ?></p>
                                <p class="complement <?php if($address->getComplement() == null) echo 'hidden'; ?>"><?php echo $address->getComplement(); ?></p>
                                <p class='address-line'><?php echo $address->getAddressLine(); ?></p>
                                <p class='zip-code'><?php echo $address->getPostalCode(); ?></p>
                                <p class='city'><?php echo $address->getCity(); ?></p>
                            </div>
                        </div>
                        <div id="birthlist-paymentchoice-container">
                            <H3>MÉTHODE DE PAIEMENT :</H3>
                            <form id="birthlist-paymentchoice-form" method="post" action="https://www.bebes-lutins.fr/liste-de-naissance/pay/<?php echo $birthlist->getId(); ?>">
                                <label for="payment_method" class="hidden">Moyen de paiement :</label>
                                <select id="payment_method" name="payment_method">
                                    <option value="1">Carte bancaire</option>
                                    <option value="2">Chèque bancaire</option>
                                </select>
                                <div id="start-payment" class="vertical centered margin-bottom">
                                    <p class="small">En cliquant sur le bouton ci-dessous vous acceptez sans réserve les conditions générales de vente.</p>

                                    <button id="next-button" class="transition-fast">Payer</button>
                                </div>
                            </form>
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
<script>
    $(".item-checkbox").change(function(){
        if ($('.item-checkbox:checked').length == 0) {
            document.getElementById("button-apply-modification-birthlist").setAttribute("disabled", "disabled");
        }
        else {
            document.getElementById("button-apply-modification-birthlist").removeAttribute("disabled");
        }
    });
</script>
</body>
</html>