<?php
$products = ProductGateway::GetProducts();
$categories = CategoryGateway::GetCategories();

$birthlist = BirthlistGateway::GetBirthlistByID($_GET['birthlist_id']);
$selected_items = unserialize($_SESSION['selected_items']);

$total_items_count = 0;
$total_items_price = 0;

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
                <p>Veuillez entrer vos informations de facturations pour que nous sachions qui a acheté le ou les produits en questions.</p>
            </div>
            <form id="billing-address-form" class="vertical" method="post" action="https://www.bebes-lutins.fr/liste-de-naissance/paiement/<?php echo $birthlist->getId(); ?>">
                <div class="input-container horizontal">
                    <div class="personnal-informations vertical centered">
                        <label for="civility_billing">Civilité * : </label>
                        <select id='civility_billing' name="civility_billing" required>
                            <option value="1">Monsieur</option>
                            <option value="2">Madame</option>
                        </select>
                        <label for="surname_billing">Nom * : </label>
                        <input type="text" name="surname_billing" placeholder="Nom du destinataire" id="surname_billing" required>
                        <label for="firstname_billing">Prénom * : </label>
                        <input type="text" name="firstname_billing" placeholder="Prénom du destinataire" id="firstname_billing" required>
                    </div>
                    <div class="address-informations vertical centered">
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
                </div>
                <button type="submit"><i class="far fa-check-circle"></i> Je passe au paiement</button>
            </form>
            <div id="selection-summary" class="vertical">
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
                <div class="summary-text" style="text-align: center">
                    <p>Nombre total de produits : <?php echo $total_items_count;?></p>
                    <p>Prix total : <?php echo UtilsModel::FloatToPrice($total_items_price);?></p>
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