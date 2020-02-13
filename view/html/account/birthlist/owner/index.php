<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:30
 */

$user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();

$firstname = $user->getFirstname();
$surname = $user->getSurname();
$mail = $user->getMail();
$phone_number = $user->getPhone();

$birthlist = BirthlistGateway::GetBirthlistByCustomerID($user->getId());
$products = ProductGateway::GetProducts();
$categories = CategoryGateway::GetCategories();

if(isset($_SESSION['temp_step'])){
    $birthlist->setStep($_SESSION['temp_step']);
    unset($_SESSION['temp_step']);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ma liste de naissance - Bebes Lutins</title>
    <meta name="description" content="Accedez a votre liste de naissance et ajoutez-y des produits."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main class="vertical">
    <div id="customer-area2" class="vertical">
        <div id="customer-area-header" class="vertical">
            <div id="hello" class="vertical">
                <h2>Bonjour <?php echo $firstname;?></h2>
                <p>Bienvenue dans votre espace</p>
            </div>
            <div id="customer-area-tabs" class="horizontal">
                <a href="https://www.bebes-lutins.fr/espace-client">Mon profil</a>
                <a href="https://www.bebes-lutins.fr/espace-client/commandes">Mes commandes</a>
                <a href="https://www.bebes-lutins.fr/espace-client/adresses">Mes adresses</a>
                <a href="https://www.bebes-lutins.fr/espace-client/liste-de-naissance" class="selected">Ma liste de naissance</a>
            </div>
        </div>
        <div id="customer-area-inner" class="vertical">
            <div id="birthlist-container">
                <H3>MA LISTE DE NAISSANCE</H3>
                <?php if($birthlist == null){ ?>
                    <form id="new-birthlist" method="post" action="https://www.bebes-lutins.fr/espace-client/liste-de-naissance/initialiser">
                        <input type="hidden" name="user_id" value="<?php echo $user->getId();?>">
                        <p>Vous n'avez jamais crée de liste de naissance, cliquez sur le bouton ci-dessous pour commencer.</p>
                        <button type="submit">Commencer ma liste de naissance</button>
                    </form>
                <?php } else {
                    if ($birthlist->getStep() == 1) {
                        ?>
                        <p>Veuillez préciser le prénom des parents et un petit message :-).</p>
                        <form id="birthlist-init" method="post"
                              action="https://www.bebes-lutins.fr/espace-client/liste-de-naissance/creation"
                              class="vertical">
                            <input type="hidden" name="birthlist_id" value="<?php echo $birthlist->getId(); ?>">
                            <div class="horizontal">
                                <div class="vertical parent-name">
                                    <label for="father-name">Prénom de la mère :</label>
                                    <input id="father-name" type="text" name="mother_name" value=""
                                           placeholder="Prénom de la mère" required>
                                </div>
                                <div class="vertical parent-name">
                                    <label for="mother-name">Prénom du père :</label>
                                    <input id="mother-name" type="text" name="father_name" value=""
                                           placeholder="Prénom du père" required>
                                </div>
                            </div>
                            <label for="message">Message :</label>
                            <textarea id="message" name="message"
                                      placeholder="Entrez un message pour les personnes à qui vous partagerez votre liste de naissance."
                                      required></textarea>
                            <button type="submit">Créer ma liste</button>
                        </form>
                    <?php } else if ($birthlist->getStep() == 2) { ?>
                        <p>Choisissez les produits que vous souhaitez ajouter à votre liste de naissance : </p>
                        <form id="item-choice-birthlist" class="vertical"
                              action="https://www.bebes-lutins.fr/espace-client/liste-de-naissance/ajout-produits"
                              method="post">
                            <input type="hidden" name="birthlist_id" value="<?php echo $birthlist->getId(); ?>">
                            <?php foreach ($categories as $category) {
                                $contains_products = false;
                                $category = (new CategoryContainer($category))->getCategory();
                                $category_name = $category->getName();
                                $category_image = $category->getImage();
                                foreach ($products as $product) if ($product->getCategory()->getName() == $category_name) $contains_products = true;
                                ?>
                                <div id="category-container-<?php echo $category_name; ?>"
                                     class="category-container <?php if ($contains_products) echo 'horizontal'; else echo 'hidden'; ?>"
                                     onclick="show_products_of_category('<?php echo $category_name; ?>')">
                                    <div class="category-image-container">
                                        <img src='https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $category_image; ?>'
                                             class='transition-fast' alt="<?php echo $category_name; ?>">
                                    </div>
                                    <div class="category-name-container vertical centered">
                                        <p><?php echo $category_name; ?></p>
                                    </div>
                                </div>
                                <div id="items-container-<?php echo $category_name; ?>"
                                     class="category-items-container hidden">
                                    <?php foreach ($products as $product) {
                                        if ($product->getCategory()->getName() == $category_name) {
                                            $product_id = $product->getId();
                                            $product_name = $product->getName();
                                            $product_image = $product->getImage();
                                            ?>
                                            <div class="category-item horizontal">
                                                <div class="category-item-image-container">
                                                    <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" title="<?php echo $product_name; ?>">
                                                </div>
                                                <div class="category-item-texts-container horizontal transition-fast">
                                                    <div class="item-texts vertical">
                                                        <p class="item-name"><?php echo $product_name; ?></p>
                                                        <a target="_blank" rel="noopener noreferrer" href="https://www.bebes-lutins.fr/produit/<?php echo $product_id; ?>">Voir la fiche produit</a>
                                                    </div>
                                                    <div class="horizontal">
                                                        <label class="custom-checkbox">
                                                            <input id="item-select" type="checkbox" name="products[]" class="item-checkbox" value="<?php echo $product_id; ?>">
                                                            <span class="checkmark vertical"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>
                            <?php } ?>
                            <button id='submit-item-choice' type="submit">Valider les produits</button>
                        </form>
                    <?php } else if ($birthlist->getStep() == 3) {
                        $products = ProductGateway::GetProducts();
                        $father_name = $birthlist->getFatherName();
                        $mother_name = $birthlist->getMotherName();
                        $message = $birthlist->getMessage();
                        ?>
                        <p>Voici votre liste de naissance : </p>
                        <form id="birthlist-final" class="horizontal" method="post" action="https://www.bebes-lutins.fr/espace-client/liste-de-naissance/suppression-produits">
                            <input type="hidden" name="birthlist_id" value="<?php echo $birthlist->getId();?>">
                            <div id="birthlist-summary" class="vertical">
                                <p>Liste de naissance de <?php echo $mother_name; ?> et <?php echo $father_name; ?></p>
                                <p>Créée le <?php echo $birthlist->getCreationDate()->format('d-m-Y à H:i:s'); ?></p>
                                <p><BR>"<?php echo $message; ?>"</p>
                                <div id="birthlist-link-container">
                                    <p>Lien de votre liste :</p>
                                    <a id="birthlist_url" href="https://www.bebes-lutins.fr/liste-de-naissance/partage/<?php echo $birthlist->getId();?>"><?php echo "https://www.bebes-lutins.fr/liste-de-naissance/partage/".$birthlist->getId()?></a>
                                </div>
                            </div>
                            <div id="birthlist-items-container" class="vertical">
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
                                                            <select id="quantity" name='quantity' onchange='change_quantity(<?php echo "\"$item_id\""; ?>, this)'>
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
                                                    <a target="_blank" rel="noopener noreferrer" href="https://www.bebes-lutins.fr/produit/<?php echo $product_id; ?>">Voir la fiche produit</a>
                                                </div>
                                            </div>
                                            <label class="custom-checkbox">
                                                <input id="item-select" type="checkbox" name="products[]" class="item-checkbox" value="<?php echo $product_id; ?>">
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
                                                            <a class="payed" style="color: grey;" target="_blank" rel="noopener noreferrer" href="https://www.bebes-lutins.fr/produit/<?php echo $product_id; ?>">Voir la fiche produit</a>
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
                                <?php if(!empty($birthlist->getItems())){ ?>
                                    <div class="item item-add vertical centered" onclick="back_temporary_to_step2('<?php echo $birthlist->getId(); ?>')">
                                        <p><i class="fas fa-plus" style="margin-right: 10px"></i>Ajouter des produits</p>
                                    </div>
                                    <button type="submit" id="button-apply-modification-birthlist" disabled>Supprimer</button>
                                <?php } ?>
                                <?php if(empty($birthlist->getItems())) { ?>
                                    <div id="empty-birthlist-container">
                                        <p>Vous n'avez aucun produit dans votre liste de naissance... Quel dommage !</p>
                                    </div>
                                    <div class="item item-add vertical centered" onclick="back_to_step_2('<?php echo $birthlist->getId(); ?>')">
                                        <p><i class="fas fa-plus" style="margin-right: 10px"></i>Ajouter des produits</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </form>
                    <?php }
                }?>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
<script>
    /*$(".item-checkbox").change(function(){
        if ($('.item-checkbox:checked').length == $('.item-checkbox').length) {
            document.getElementById("button-apply-modification-birthlist").setAttribute("disabled", "disabled");
        }
        else {
            document.getElementById("button-apply-modification-birthlist").removeAttribute("disabled");
        }
    });*/

    $(".item-checkbox").change(function(){
        if ($('.item-checkbox:checked').length == 0) {
            document.getElementById("button-apply-modification-birthlist").setAttribute("disabled", "disabled");
        }
        else {
            document.getElementById("button-apply-modification-birthlist").removeAttribute("disabled");
        }
    });

    function back_temporary_to_step2(birthlist_id){
        document.location.href='http://www.bebes-lutins.fr/espace-client/liste-de-naissance/choix-produits-temporaire/'+birthlist_id;
    }

    function back_to_step_2(birthlist_id){
        document.location.href='http://www.bebes-lutins.fr/espace-client/liste-de-naissance/choix-produits/'+birthlist_id;
    }

    function show_products_of_category(category_name){
        document.getElementById("items-container-"+category_name).setAttribute("class", "category-items-container horizontal transition-fast");
        document.getElementById("category-container-"+category_name).setAttribute("onClick", "hide_products_of_category('"+category_name+"')");
    }

    function hide_products_of_category(category_name){
        document.getElementById("items-container-"+category_name).setAttribute("class", "category-items-container hidden transition-fast");
        document.getElementById("category-container-"+category_name).setAttribute("onClick", "show_products_of_category('"+category_name+"')");
    }

    var change_quantity = function(id, quantityObject) {
        var quantity = quantityObject.value;
        $.ajax({
            url: '../index.php',
            type: 'POST',
            data: {id:id, quantity:quantity, action:"birthlist_item_change_quantity"},
            success: function(quantity) {
                document.location.href="https://www.bebes-lutins.fr/espace-client/liste-de-naissance";
            }
        });
    };
</script>
</body>
</html>