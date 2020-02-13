<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 25/02/2019
 * Time: 08:19
 */

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
            $sub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category->getName())));
            $sub_category_display = $sub_category_display . "<a href='https://www.bebes-lutins.fr/categorie/$sub_category_url'>$sub_category_name</a>";
        }

    }

    /*$products_display = "";
    $i = 0;
    foreach ($products as $product){
        $product = (new ProductContainer($product))->getProduct();
        if($product->getCategory()->getName() == $category->getName()){
            $i++;
            $name = $product->getName();
            $id = $product->getId();
            $products_display = $products_display . "
                <a href='https://www.bebes-lutins.fr/produit/$id'>$name</a>
            ";
        }
    }*/

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


?>
<div id="menu-mobile" class="menu-mobile vertical transition-fast">
    <div class="links-container vertical">
        <div class="links vertical">
            <a href="https://www.bebes-lutins.fr/en-savoir-plus/qui-sommes-nous">A propos</a>
            <a id='categories-button' onclick="display_categories()" class="horizontal"><p>Catégories</p><i id="arrow-button" class="fas fa-angle-down"></i></a>
            <div id="categories-mobile" class="transition-fast" style="display: none">
            <?php echo $category_popup_content;?>
            </div>
            <a href="https://www.bebes-lutins.fr/panier">Panier</a>
            <?php
            if(isset($_SESSION['connected_user'])){
                ?>
                <a href="https://www.bebes-lutins.fr/espace-client">Mon compte</a>
                <a href="https://www.bebes-lutins.fr/espace-client/deconnexion">Déconnexion</a>
                <?php
            } else {?>
                <a href="https://www.bebes-lutins.fr/espace-client/connexion">Se connecter</a>
            <?php }?>
        </div>
    </div>
    <div class="categories-swiper-container">

    </div>
    <div class="social-media-container vertical">
        <div class="horizontal social-media-icons">
            <a href="https://www.facebook.com/bebes.lutins/" class="facebook"><?php echo file_get_contents("view/assets/images/utils/icons/facebook.svg"); ?></a>
            <a href="https://www.instagram.com/bebeslutins/" class="instagram"><?php echo file_get_contents("view/assets/images/utils/icons/instagram.svg"); ?></a>
        </div>
    </div>
</div>

<script>
    function display_categories(){
        document.getElementById("categories-button").setAttribute('onClick', "close_categories()");
        document.getElementById("arrow-button").setAttribute("class", "fas fa-angle-up");
        document.getElementById("categories-mobile").style.display = "unset";

    }

    function close_categories(){
        document.getElementById("categories-button").setAttribute('onClick', "display_categories()");
        document.getElementById("arrow-button").setAttribute("class", "fas fa-angle-down");
        document.getElementById("categories-mobile").style.display = "none";
    }
</script>