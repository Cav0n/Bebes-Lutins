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
<!-- <div id='extra' class='desktop horizontal centered' style="z-index: 100;height: 2rem;color: white;background: rgb(229, 89, 84);font-family: Roboto, sans-serif;">
    <p class='vertical centered'>"CONGES ANNUELS" Les commandes passées à partir du 13 juillet seront expédiées à partir du 29 juillet.</p>
</div> -->
<div id="top" class="desktop horizontal">
    <div id="left">
        <a href="https://www.bebes-lutins.fr/contact" class="contact transition-fast">
            <p>CONTACTEZ-NOUS</p>
            <div class="horizontal centered icons">
            <?php echo file_get_contents("view/assets/images/utils/icons/call.svg"); ?>
            <?php echo file_get_contents("view/assets/images/utils/icons/email.svg"); ?>
            <?php echo file_get_contents("view/assets/images/utils/icons/map-location.svg"); ?>
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
        <div id="categories" onmouseover='show_categories_popup()' onmouseleave='hide_categories_popup()'>
            <p class="tab vertical centered transition-fast" id="categories-tab" onclick='display_categories_popup()'>Nos produits</p>

            <div id='categories-popup2' class='popup horizontal' style='top: calc(8rem - 1px);left: 0;background: white;position: fixed;max-width:100vw;box-sizing:border-box;border-top:1px solid;box-shadow:black 0px 1px 10px -5px;padding:1rem 0;'>
                <div id='parent-categories' class='vertical' style='max-width:15rem;min-width:15rem;'>
                    
                    <?php foreach($categories as $category) { if($category->getParent() == null && !$category->getPrivate()) {?>
                        <div class='category-container' onclick='select_category($(this))' style='padding: 0.5rem;border: 1px solid rgb(202, 202, 202);margin:0.3rem 0.5rem;  -webkit-touch-callout: none; /* iOS Safari */-webkit-user-select: none; /* Safari */-khtml-user-select: none; /* Konqueror HTML */-moz-user-select: none; /* Firefox */-ms-user-select: none; /* Internet Explorer/Edge */user-select: none; /* Non-prefixed version, currentlysupported by Chrome and Opera */cursor:pointer;font-weight: 400;font-size: 0.95rem;border-radius: 2px;'>
                            <?php echo $category->getName(); ?>
                        </div>
                    <?php } } ?>

                </div>
                <div id='child-categories' class='horizontal' style='width:calc(100vw - 14rem);'>
                    <?php foreach($categories as $category) { if($category->getParent() == null && !$category->getPrivate()) { ?>
                        <div id='<?php echo $category->getNameForURL(); ?>-container' class="category-child horizontal wrap hidden" >
                            <?php foreach($sub_categories_list as $sub_category) { if(!$sub_category->getPrivate()) {
                                if($sub_category->getParent() == $category->getName()) { ?>
                                <div class='vertical category-child-container' onclick="load_category('<?php echo $sub_category->getNameForURL(); ?>')" style='margin: 0.5rem;border: 1px solid rgb(202, 202, 202);height:max-content;cursor:pointer;'>
                                    <p class='child-name' style='width:13rem;box-sizing:border-box;padding:0.3rem;border-bottom:1px solid rgb(202, 202, 202);'><?php echo $sub_category->getName();?></p>
                                    <img class='child-image' src='https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $sub_category->getImage();?>' style='width:13rem;'>
                                </div>
                            <?php } } } ?>
                        </div>
                    <?php } } ?>
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
        <div id="nav-icon4" onclick="display_menu_mobile()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <a id="link-logo" href="https://www.bebes-lutins.fr" class='vertical centered'><img src="https://www.bebes-lutins.fr/view/assets/images/logo.png" id="img-logo" class="transition-fast not-shrink-logo"></a>
        <a id="shopping-cart-logo" href="https://www.bebes-lutins.fr/panier" class='vertical centered'><?php echo file_get_contents("view/assets/images/utils/icons/shopping-bag.svg"); ?></a>
    </div>
    <?php UtilsModel::load_menu_mobile();?>
</div>


<script>
    $(document).ready(function(){
        $("#child-categories").hide();
        $('#categories-popup2').hide();
        console.log('<?php foreach($categories as $category) echo $category->getName(); ?>');
    });

    function load_category(category) {
        document.location.href = "https://www.bebes-lutins.fr/categorie/" + category;
    }

    function load_shopping_cart(){
        document.location.href="panier";
    }

    function display_menu_mobile(){
        document.getElementById("menu-mobile").style.marginLeft = 0;
        document.getElementsByTagName("body")[0].style.overflow = 'hidden';

        $('#nav-icon4').attr('onclick', 'hide_menu_mobile()');
    }
    
    function hide_menu_mobile(){
        document.getElementById("menu-mobile").style.marginLeft = "-100%";
        document.getElementsByTagName("body")[0].style.overflow = 'auto';
        document.getElementsByTagName("html")[0].style.overflow = 'auto';

        $('#nav-icon4').attr('onclick', 'display_menu_mobile()');

    }

    function display_categories_popup(){
        categories_popup = $('#categories-popup');
        if ( categories_popup.is(':visible') ){
            categories_popup.hide();
        } else {
            categories_popup.show();
        }
        
    }

    function select_category(category_selected){
        $('.category-container').removeClass('category-selected');
        $('.category-container').css('background', 'white');

        category_selected.addClass('category-selected');
        console.log(category_selected);
        category = category_selected.text().trim().normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/\s/g,'');

        console.log("#" + category + '-container');

        $("#child-categories").show();

        $('.category-child').addClass('hidden')
        $('#' + category + '-container').removeClass('hidden');

        $('.category-selected').css('background','#b5e639');
    }

    function show_categories_popup(){
        $('#categories-popup2').slideDown(75);
    }
    
    function hide_categories_popup(){
        $('#categories-popup2').slideUp(75);
    }
</script>