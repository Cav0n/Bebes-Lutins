<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:14
 */

if(isset($_SESSION['connected_user'])){
    $user_container = new UserContainer(unserialize($_SESSION['connected_user']));
    $user = $user_container->getUser();
    /*$shopping_cart = $user->getShoppingCart();*/

    $firstname = $user->getFirstname();
    $surname = $user->getSurname();
    $account_div = "
        <a href=\"https://www.bebes-lutins.fr/espace-client\" class=\"big minsize-centered\">MON COMPTE</a>
        <a href=\"https://www.bebes-lutins.fr/espace-client\" class=\"medium minsize-centered\">$firstname $surname</a>
        <a href=\"https://www.bebes-lutins.fr/espace-client/deconnexion\" class=\"medium minsize-centered\">Déconnexion</a>";

    /*if($shopping_cart->getShoppingCartItems() == null){
        $shopping_cart_popup_content = "<p class='small'>Vous n'avez aucun article dans votre panier.</p>";
    }*/


} else {
    $account_div = "
        <a href=\"https://www.bebes-lutins.fr/espace-client/connexion\" class=\"big minsize-centered\">MON COMPTE</a>
        <a href=\"https://www.bebes-lutins.fr/espace-client/connexion\" class=\"medium minsize-centered\">Se connecter</a>
        <a href=\"https://www.bebes-lutins.fr/espace-client/enregistrement\" class=\"medium minsize-centered\">Créer mon compte</a>";

    /*$shopping_cart_popup_content = "<p class='small'>Vous n'avez aucun article dans votre panier.</p>";*/
}

$categories = CategoryGateway::GetCategories();
$products = ProductGateway::GetProducts();
$category_popup_content = "";
$sub_categories_list = array();

foreach ($categories as $category){
    $category = (new CategoryContainer($category))->getCategory();
    if($category->getParent() != null && $category->getParent() != "none"){
        $sub_categories_list[] = $category;
    }
}

foreach ($categories as $category){
    $category = (new CategoryContainer($category))->getCategory();
    $category_name = $category->getName();
    //$category_name_url = str_replace("à","%a1", str_replace("ê","%e3",str_replace("è","%e2",str_replace("é", "%e1",  str_replace("’", "_", str_replace(" ", "-", $category_name))))));
    $category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category->getName())));
    $category_image = $category->getImage();

    $sub_category_display = "";
    foreach ($sub_categories_list as $sub_category){
        $sub_category = (new CategoryContainer($sub_category))->getCategory();
        if($sub_category->getParent() == $category->getName()){
            //$sub_category_url = str_replace("à","%a1", str_replace("ê","%e3",str_replace("è","%e2",str_replace("é", "%e1",  str_replace("’", "_", str_replace(" ", "-", $sub_category->getName()))))));
            $sub_category_name = $sub_category->getName();
            $sub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($sub_category->getName())));
            $sub_category_display = $sub_category_display . "<a href='https://www.bebes-lutins.fr/categorie/$sub_category_url'>$sub_category_name</a>";
        }

    }

    if(!in_array($category, $sub_categories_list)) {
        $category_popup_content = $category_popup_content . "
        <div class='vertical category'>
            <a href='https://www.bebes-lutins.fr/categorie/$category_name_url' class='name'>$category_name</a>
            <div class='category_products vertical'>
                $sub_category_display
            </div>
        </div>
    ";
    }
}

$shopping_cart = (new ShoppingCartContainer(unserialize($_SESSION['shopping_cart'])))->getShoppingCart();
$shopping_cart_items = $shopping_cart->getShoppingCartItems();
$total_price = str_replace('EUR', '€', money_format('%.2n', $shopping_cart->getTotalPrice()));

$total_elements = 0;
$shopping_cart_popup_content = "";
foreach ($shopping_cart_items as $shopping_cart_item) {
    $shopping_cart_item = (new ShoppingCartItemContainer($shopping_cart_item))->getShoppingCartItem();
    $name = $shopping_cart_item->getProduct()->getName();
    $quantity = $shopping_cart_item->getQuantity();
    $image = $shopping_cart_item->getProduct()->getImage();

    $shopping_cart_popup_content = $shopping_cart_popup_content . "
    <div class='horizontal item'>
    <img width='50px' height='50px' src='https://www.bebes-lutins.fr/view/assets/images/products/$image'>
    <p>$name x $quantity</p>
    </div>
    ";

    $total_elements += $quantity;
}
?>
<div id='extra' class='desktop horizontal centered' style="z-index: 100;height: 2rem;color: white;background: rgb(229, 89, 84);font-family: Roboto, sans-serif;">
    <p class='vertical centered'>"CONGES ANNUELS" Les commandes passées à partir du 13 juillet seront expédiées à partir du 29 juillet.</p>
</div>
<div id="top" class="desktop horizontal">
    <div id="left">
        <a href="https://www.bebes-lutins.fr/contact" class="contact transition-fast">
            <p>CONTACTEZ-NOUS</p>
            <div class="horizontal centered icons">
            <?php echo file_get_contents("view/assets/images/utils/icons/call.svg"); ?>
            <?php echo file_get_contents("view/assets/images/utils/icons/email.svg"); ?>
            <?php echo file_get_contents("view/assets/images/utils/icons/location.svg"); ?>
            </div>
        </a>
    </div>
    <div id="logo">
        <a id="link-logo" href="https://www.bebes-lutins.fr"><img src="https://www.bebes-lutins.fr/view/assets/images/logo.png" id="img-logo" class="transition-fast not-shrink-logo"></a>
    </div>
    <div id="right">
        <div class="account vertical centered transition-fast">
            <?php echo $account_div;?>
        </div>
        <div class="shoppingcart vertical centered transition-fast" onclick="load_shopping_cart()">
            <a href="https://www.bebes-lutins.fr/panier">
            <a class="big">MON PANIER</a>
            <p class="medium"><?php echo $total_price;?></p>
            <p class="medium"><?php echo $total_elements;?> articles</p>
                <div id="shopping-cart-popup" class="popup vertical">
                    <?php echo $shopping_cart_popup_content;?>
                    <?php if($total_elements == 0) echo "<p>Votre panier est vide 😢</p>"; else echo "<button>Voir mon panier</button>";?>
                </div>
        </div>
    </div>
</div>
<div id="navbar" class="desktop horizontal">
    <div id="left" class="horizontal">
        <a href="https://www.bebes-lutins.fr" class="home-link vertical centered transition-fast"><i class="tab fas fa-home vertical centered transition-fast"></i></a>
        <div id="categories">
            <a href="https://www.bebes-lutins.fr/nos-produits" class="tab vertical centered transition-fast" id="categories-tab">Nos produits</a>
            <div id="categories-popup" class="popup centered">
                <div class="horizontal" style='width:100%;'>
                    <div id='parent-categories' class='vertical'>
                        <?php $index_parent = 0; foreach($categories as $category) { if($category->getParent() == 'none') {?>
                            <p id='<?php echo $category->getNameForURL(); ?>-selector' class='category <?php if ($index_parent == 0) echo 'selected-category'; ?>'><?php echo $category->getName();?></p>
                        <?php } $index_parent++; } ?>
                    </div>
                    <div id='child-categories'>
                        <?php $index_child = 0; foreach($categories as $category) { if($category->getParent() == 'none') { ?>
                            <div id='<?php echo $category->getNameForURL(); ?>-container' class="category-child horizontal wrap <?php if ($index_child != 0) echo "hidden"; ?>">
                                <?php foreach($sub_categories_list as $sub_category) {
                                    if($sub_category->getParent() == $category->getName()) { ?>
                                    <div class='vertical between category-child-container' onclick="load_category('<?php echo $sub_category->getNameForURL(); ?>')">
                                        <p class='child-name'><?php echo $sub_category->getName();?></p>
                                        <img class='child-image' src='https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $sub_category->getImage();?>'>
                                    </div>
                                <?php } $index_child ++; } ?>
                            </div>
                        <?php } } ?>
                    </div>
                    <div id='image-parent-container'>
                        <?php $index_child = 0; foreach($categories as $category) { if($category->getParent() == 'none') { ?>
                            <img id='<?php echo $category->getNameForURL(); ?>-image' class='category-image <?php if ($index_child != 0) echo "hidden"; ?>' src='https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $category->getImage(); ?>' onclick='load_category("<?php echo $category->getNameForURL(); ?>")'>
                        <?php } $index_child ++; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="right" class="horizontal">
        <a href="https://www.bebes-lutins.fr/en-savoir-plus/qui-sommes-nous" class="tab vertical centered transition-fast" >Qui sommes-nous ?</a>
        <a href="https://www.bebes-lutins.fr/en-savoir-plus/guide-et-conseils" class="tab vertical centered transition-fast">Guide et conseils</a>
    </div>
</div>

<div id="top-mobile" class="mobile horizontal">
    <div id="header-container" class="between">
        <a class="vertical centered" onclick="display_menu_mobile()"><?php echo file_get_contents("view/assets/images/utils/icons/menu.svg"); ?></a>
        <a id="link-logo" href="https://www.bebes-lutins.fr" class='vertical centered'><img src="https://www.bebes-lutins.fr/view/assets/images/logo.png" id="img-logo" class="transition-fast not-shrink-logo"></a>
        <a id="shopping-cart-logo" href="https://www.bebes-lutins.fr/panier" class='vertical centered'><?php echo file_get_contents("view/assets/images/utils/icons/shopping-bag.svg"); ?></a>
    </div>
    <?php UtilsModel::load_menu_mobile();?>
</div>


<script>
    function load_category(category) {
        document.location.href = "https://www.bebes-lutins.fr/categorie/" + category;
    }

    function load_shopping_cart(){
        document.location.href="panier";
    }

    function display_menu_mobile(){
        document.getElementById("menu-mobile").style.marginLeft = 0;
        document.getElementsByTagName("body")[0].style.overflow = 'hidden';
    }

    $(document).ready(function() {
        $('.category').click(function() {
            $('.category').removeClass('selected-category');
            $(this).addClass('selected-category');
            category = $(this).attr('id').replace('-selector', '');
            console.log(category);
            $('.category-child').addClass('hidden');
            $('.category-image').addClass('hidden');
            $('#' + category + "-container").removeClass('hidden');
            $('#' + category + "-image").removeClass('hidden');
        });
    });
</script>