<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 22:15
 */

$category_name = str_replace("_", "’", str_replace( "="," ", $_GET['category']));

//$category_name = str_replace("eee", "é",  str_replace("_", "’", str_replace("-", " ", $_GET['category'])));
$category = CategoryGateway::SearchCategoryByName($category_name);
$categories_list = CategoryGateway::GetCategories();
$product_list = ProductGateway::SearchProductsByCategory($category);
$_SESSION['category'] = serialize($category);

$name = $category->getName();
$category_name = $category->getName();
$description = $category->getDescription();
$parent_category = $category->getParent();

$category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category->getName())));
$parent_category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($parent_category)));

if($parent_category != "none" && $parent_category != null) $breadcrump = "<a href='https://www.bebes-lutins.fr/'>Accueil</a> <i class=\"fas fa-angle-right\"></i> <a href='https://www.bebes-lutins.fr/categorie/$parent_category_name_url'>$parent_category</a> <i class=\"fas fa-angle-right\"></i> <a href='https://www.bebes-lutins.fr/categorie/$category_name_url'>$name</a>";
else $breadcrump = "<a href='https://www.bebes-lutins.fr/'>Accueil</a> <i class=\"fas fa-angle-right\"></i> <a href='https://www.bebes-lutins.fr/categorie/$category_name_url'>$name</a>";

$category_subcategories_display = "";
foreach ($categories_list as $sub_category) {
    $sub_category = (new CategoryContainer($sub_category))->getCategory();

    if($sub_category->getParent() == $category->getName()){
        $image = $sub_category->getImage();
        $sub_category_name = $sub_category->getName();
        $sub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($sub_category->getName())));

        $category_subcategories_display = $category_subcategories_display . "
            <div class='sub-category' onclick='show_subcategory_page(\"$sub_category_url\")'>
                <h2>$sub_category_name</h2>
                <img src='https://www.bebes-lutins.fr/view/assets/images/categories/$image' class='transition-fast'>
            </div>
        ";
    }
}

$category_products_display = "";
foreach ($product_list as $product) {
    $product = (new ProductContainer($product))->getProduct();
    $id = $product->getId();
    $name = $product->getName();
    $price = str_replace("EUR", "€", money_format("%.2i", $product->getPrice()));
    $image = $product->getImage();

    if($product->getStock() < 1) {$out_of_stock = 1; $class_out_of_stock = "out-of-stock"; $disabled = "disabled"; $link = "";}
    else {$out_of_stock = 0; $class_out_of_stock = ""; $disabled = ""; $link = $product->getId();}

    if(!$product->getHide()) {
        $category_products_display = $category_products_display . "
    <div class=\"product vertical $class_out_of_stock\" onclick=\"show_product_page('$link')\">
        <img src=\"https://www.bebes-lutins.fr/view/assets/images/products/$image\" alt=\"$name\" title=\"$name\">
        <div class=\"text horizontal centered\">
            <p class=\"name vertical centered\">$name</p>
            <p class=\"price vertical centered\">$price</p>
        </div>
        <button class=\"transition-fast\" $disabled>Ajouter au panier</button>
    </div>
    ";
    }
}

$category_products_display_mobile = "";
foreach ($product_list as $product) {
    $product = (new ProductContainer($product))->getProduct();
    $id = $product->getId();
    $name = $product->getName();
    $price = str_replace("EUR", "€", money_format("%.2i", $product->getPrice()));
    $image = $product->getImage();

    if($product->getStock() < 1) {$out_of_stock = 1; $class_out_of_stock = "out-of-stock"; $disabled = "disabled"; $link = "";}
    else {$out_of_stock = 0; $class_out_of_stock = ""; $disabled = ""; $link = $product->getId();}

    $category_products_display_mobile = $category_products_display_mobile . "
    <div class=\"product vertical $class_out_of_stock\" onclick=\"show_product_page('$link')\">
        <img src=\"https://www.bebes-lutins.fr/view/assets/images/products/$image\" alt=\"$name\" title=\"$name\">
         <p class=\"name vertical centered\">$name</p>
         <p class=\"price vertical centered\">$price</p>
    </div>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $category_name;?> - Bebes Lutins</title>
    <meta name="description" content="<?php echo $description;?>"/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <div id="category-page">
        <div id="breadcrumb" class="desktop">
            <p><?php echo $breadcrump;?></p>
        </div>
        <div id="category-container" class="desktop vertical">
            <div id="category-texts-container">
                <h1><?php echo $category_name;?></h1>
                <p id="category-description"><?php echo $description?></p>
            </div>
            <div id="category-items-container">
                <div class="category-subcategories-container horizontal wrap">
                            <?php
                            foreach ($categories_list as $sub_category) {
                                $sub_category = (new CategoryContainer($sub_category))->getCategory();
                                if($sub_category->getParent() == $category->getName()) {
                                    $image = $sub_category->getImage();
                                    $sub_category_name = $sub_category->getName();
                                    $sub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($sub_category->getName())));
                                    ?>
                                        <div class='sub-category' onclick='show_subcategory_page("<?php echo $sub_category_url;?>")'>
                                            <h2><?php echo $sub_category_name; ?></h2>
                                            <img src='https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $image;?>' class='transition-fast'>
                                        </div>
                                    <?php
                                }
                            }
                            ?>
                </div>
                <div class="category-products-container horizontal wrap">
                    <?php echo $category_products_display;?>
                </div>
            </div>
        </div>

        <div id="categories-container-mobile" class="mobile vertical">
            <div id="category-texts" class="vertical">
                <h1 class="category-name"><?php echo $category_name;?></h1>
                <p class="category-description"> <?php echo $description?></p>
            </div>
            <div id="category-items-container">
                <div class="category-subcategories-container vertical">
                    <?php
                    foreach ($categories_list as $sub_category) {
                        $sub_category = (new CategoryContainer($sub_category))->getCategory();
                        if($sub_category->getParent() == $category->getName()) {
                            $image = $sub_category->getImage();
                            $sub_category_name = $sub_category->getName();
                            $sub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($sub_category->getName())));
                        ?>
                            <div class='sub-category' onclick='show_subcategory_page("<?php echo $sub_category_url;?>")'>
                                <h2><?php echo $sub_category_name; ?></h2>
                                <img src='https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $image;?>' class='transition-fast'>
                            </div>
                        <?php }
                    }
                    ?>
                </div>
                <div class="category-products-container vertical">
                    <?php echo $category_products_display_mobile;?>
                </div>
            </div>
        </div>
    </div>
    <?php UtilsModel::load_certifications();?>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
<script>
    function show_product_page(id){
        if(id != ""){
            document.location.href="https://www.bebes-lutins.fr/produit/"+id;
        }
    }

    function show_subcategory_page(name){
        document.location.href="https://www.bebes-lutins.fr/categorie/"+name;
    }
</script>
</html>