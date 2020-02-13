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
if(isset($_SESSION['selected_items'])) unset($_SESSION['selected_items']);
if(isset($_SESSION['birthlist_payment'])) unset($_SESSION['birthlist_payment']);

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
                <p>Achetez les produits que vous souhaitez pour <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?>. Vous pouvez choisir la quantité à acheter,
                    la quantité optimale a été choisis par <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?>.</p>
            </div>
            <form id="birthlist-items" method="post" action="https://www.bebes-lutins.fr/liste-de-naissance/facturation/<?php echo $birthlist->getId(); ?>" class="horizontal wrap">
                <?php
                foreach ($birthlist->getItems() as $item) {
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

                    if(!$item->getPayed()){
                        ?>
                        <div class="item horizontal">
                            <div class="category-item-image-container">
                                <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" title="<?php echo $product_name; ?>">
                            </div>
                            <div class="category-item-texts-container horizontal transition-fast">
                                <div class="item-texts vertical">
                                    <p class="item-name"><?php echo $product_name; ?></p>
                                    <div class="item-bottom horizontal between">
                                        <div class="horizontal">
                                            <p><?php echo UtilsModel::FloatToPrice($product_price); ?></p>
                                            <div class="quantity horizontal">
                                                <label for="quantity">Quantité : </label>
                                                <select id="quantity" name='quantities[]'>
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
                                        </div>
                                    </div>
                                </div>
                                <label class="custom-checkbox">
                                    <input id="item-select" type="checkbox" name="items_id[]" class="item-checkbox" value="<?php echo $item_id; ?>">
                                    <span class="checkmark vertical"></span>
                                </label>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="item payed vertical" style="color: grey;">
                            <div class="horizontal payed-inner">
                                <div class="category-item-image-container">
                                    <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" title="<?php echo $product_name; ?>">
                                </div>
                                <div class="category-item-texts-container horizontal transition-fast">
                                    <div class="item-texts vertical">
                                        <p class="item-name"><?php echo $product_name; ?></p>
                                        <div class="item-bottom horizontal between">
                                            <div class="horizontal">
                                                <p><?php echo UtilsModel::FloatToPrice($product_price); ?></p>
                                                <div class="quantity horizontal">
                                                    <label for="quantity">Quantité : </label>
                                                    <select id="quantity" name='quantity' disabled="disabled">
                                                        <?php
                                                        $quantity_selector = "";
                                                        $stock = $item->getProduct()->getStock();
                                                        if($stock > 15) $stock = 15;
                                                        for($i=1; $i<=$stock; $i++){
                                                            if($i == $product_quantity) $quantity_selector = $quantity_selector . "<option value='$i' selected>$i</option>";
                                                            else $quantity_selector = $quantity_selector . "<option value='$i'>$i</option>";
                                                        }
                                                        echo $quantity_selector ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical payed-by">
                                <p>Payé par <?php echo $item->getBillingAddress()->getFirstname(); ?> <?php echo substr($item->getBillingAddress()->getSurname(), 0, 1) ."."; ?></p>
                            </div>
                        </div>
                    <?php }
                } ?>
                <button id='button-apply-modification-birthlist' type="submit" disabled="disabled"><i class="far fa-check-circle"></i> J'ai choisi les produits que j'achète</button>
            </form>
            <div class="price hidden" style="text-align: center; margin-top: 1em;">
                <p>Nombre de produits selectionnés : 0</p>
                <p>Prix total : 0.00 €</p>
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

