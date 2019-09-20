<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 19/11/2018
 * Time: 10:21
 */

$products = ProductGateway::GetProducts2();
$highlighted_products = ProductGateway::GetHighlightedProducts2();
if(isset($_SESSION['limit_product_display']))
    $limit_product_display = $_SESSION['limit_product_display'];
else $limit_product_display = -1;

$product_number = 1;
?>


<div id="products-display" class="horizontal wrap centered">
<?php
if(($highlighted_products != null) && $limit_product_display != -1){
    foreach ($highlighted_products as $highlighted_product){
        $highlighted_product = (new ProductContainer($highlighted_product))->getProduct();
            if($highlighted_product->getStock() < 1) {$out_of_stock = 1; $class_out_of_stock = "out-of-stock"; $disabled = "disabled"; $link = "";}
            else {$out_of_stock = 0; $class_out_of_stock = ""; $disabled = ""; $link = $highlighted_product->getId();}

            if($highlighted_product->getImage()->getThumbnails() != null) {
                $thumbnail_image = $highlighted_product->getImage()->getThumbnails()[0];
                $product_name = $highlighted_product->getName();
                $product_id = $highlighted_product->getId();

                $thumbnail = "<img class='thumbnail transition-medium' src='view/assets/images/thumbnails/$thumbnail_image' alt='$product_name' title='$product_name' onclick='show_product_page(\"$link\")'>";

            } else $thumbnail = null;
            ?>
            <div class="product vertical <?php if($out_of_stock == 1) echo "out-of-stock" ?>">
                <img src="view/assets/images/products/<?php echo $highlighted_product->getImage()->getName(). "?=" . filemtime("view/assets/images/categories/" . $highlighted_product->getImage()->getName());?>" alt="<?php echo $highlighted_product->getName();?>" title="<?php echo $highlighted_product->getName();?>" onclick="show_product_page('<?php echo $link;?>')" >
                <?php echo $thumbnail;?>
                <div class="text horizontal centered" onclick="show_product_page('<?php echo $link;?>')" <?php echo $disabled?>>
                    <p class="name vertical centered"><?php echo $highlighted_product->getName();?></p>
                    <p class="price vertical centered"><?php echo number_format($highlighted_product->getPrice(), 2, ",", " "). " €";?></p>
                </div>
                <button class="transition-fast" onclick="show_product_popup(
                        '<?php echo $highlighted_product->getId();?>',
                        '<?php echo $highlighted_product->getImage()?>',
                        '<?php echo $highlighted_product->getName()?>',
                        '<?php echo str_replace("\r\n"," ",$highlighted_product->getCeoDescription());?>',
                        '<?php echo str_replace("EUR","€",money_format("%.2i", $highlighted_product->getPrice()));?>')"
                <?php echo $disabled;?>>Ajouter au panier</button>
            </div>
        <?php
    }
} else {

    foreach ($products as $product){
        $product = (new ProductContainer($product))->getProduct();
        if(!$product->getHide()) {
            $skip = false;
            foreach ($product->getCategory() as $category) {
                $category = (new CategoryContainer($category))->getCategory();
                if($category->getPrivate()){
                    $skip = true;
                }
            }
            if($skip == false){
                if ($product->getStock() < 1) {
                    $out_of_stock = 1;
                    $class_out_of_stock = "out-of-stock";
                    $disabled = "disabled";
                    $link = "";
                } else {
                    $out_of_stock = 0;
                    $class_out_of_stock = "";
                    $disabled = "";
                    $link = $product->getId();
                }

                if ($product->getImage()->getThumbnails() != null) {
                    $thumbnail_image = $product->getImage()->getThumbnails()[0];
                    $product_name = $product->getName();
                    $product_id = $product->getId();

                    $thumbnail = "<img class='thumbnail transition-medium' src='view/assets/images/thumbnails/$thumbnail_image' alt='$product_name' title='$product_name' onclick='show_product_page(\"$link\")'>";

                } else $thumbnail = null;
                ?>
                <div class="product vertical <?php if ($out_of_stock == 1) echo "out-of-stock" ?>">
                    <img src="view/assets/images/products/<?php echo $product->getImage()->getName() . "?=" . filemtime("view/assets/images/categories/" . $product->getImage()->getName()); ?>"
                        alt="<?php echo $product->getName(); ?>" title="<?php echo $product->getName(); ?>"
                        onclick="show_product_page('<?php echo $link; ?>')">
                    <?php echo $thumbnail; ?>
                    <div class="text horizontal centered"
                        onclick="show_product_page('<?php echo $link; ?>')" <?php echo $disabled ?>>
                        <p class="name vertical centered"><?php echo $product->getName(); ?></p>
                        <p class="price vertical centered"><?php echo number_format($product->getPrice(), 2, ",", " ") . " €"; ?></p>
                    </div>
                    <button class="transition-fast" onclick="show_product_popup(
                            '<?php echo $product->getId(); ?>',
                            '<?php echo $product->getImage() ?>',
                            '<?php echo $product->getName() ?>',
                            '<?php echo str_replace("\r\n", " ", $product->getCeoDescription()); ?>',
                            '<?php echo str_replace("EUR", "€", money_format("%.2i", $product->getPrice())); ?>')"
                        <?php echo $disabled; ?>>Ajouter au panier
                    </button>
                </div>
                <?php
                if ($product_number == $limit_product_display) break;
                else $product_number++;
            }            
        }
    }
}?>
</div>

<script>
    function show_product_page(id){
        if(id != ""){
            document.location.href="produit/"+id;
        }

    }
</script>