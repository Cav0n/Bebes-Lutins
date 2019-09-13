<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 05/12/2018
 * Time: 15:50
 */

$categories = CategoryGateway::GetCategories();
?>

<div id="categories" class="vertical centered">
    <div id="categories-container" class="horizontal wrap centered">
    <?php foreach ($categories as $category){
        if(!$category->getPrivate()){
            $category = (new CategoryContainer($category))->getCategory();
            $category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category->getName())));?>
            <div class="category" onclick="show_category_page('<?php echo $category_url;?>')">
                <img class="transition-medium" src="view/assets/images/categories/<?php echo $category->getImage() . "?=" . filemtime("view/assets/images/categories/" . $category->getImage()->getName());?>">
                <p class="vertical centered transition-fast"><?php echo $category->getName();?></p>
            </div>
        <?php } ?>
    <?php } ?>
    </div>
</div>

<script>
    function show_category_page(category){
        document.location.href="categorie/"+category;
    }
</script>