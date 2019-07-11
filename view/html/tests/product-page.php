<?php 
$product = ProductGateway::SearchProductByID2($_REQUEST['product_id']);
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <title><?php echo $product->getName();?> - Bebes Lutins</title>
    <meta name="description" content="<?php echo $product->getCeoDescription();?>"/>
    <?php UtilsModel::load_head();?>
</head>
<body>
    <header>
        <?php UtilsModel::load_header();?>
    </header>
    <main>
        <div id='product-page-container'>
            <div id='product-presentation-container' class='horizontal'>
                <div id='left-column' class='vertical'>
                    <div id='images-container' class='horizontal'>
                        <div id='thumbnails-container' class='vertical'>
                            <?php foreach($product->getImage()->getThumbnails() as $thumbnail) { ?>
                            <img class="thumbnail transition-fast" src="https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName();?>">
                            <?php } ?>
                        </div>
                        <div id='main-image-container'>
                            <img id='big-image'  src='https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage()->getName(); ?>' alt='<?php echo $product->getName(); ?>'>
                        </div>
                    </div>

                    <div id='price-container' class='horizontal centered'>
                        <p id='price'><?php echo UtilsModel::FloatToPrice($product->getPrice()); ?></p>
                    </div>

                    <form id='add-to-cart-container' class='horizontal'>
                        <input id='quantity-input' type='number' value='1' placeholder='1' min='1' max='<?php echo $product->getStock(); ?>' step='1' required>
                        <button id='add-to-cart-button' type='submit'>Ajouter au panier</button>
                    </form>
                </div>
                <div id='right-column' class='vertical'>
                    <div id='title-container'>
                        <h1><?php echo $product->getName(); ?></h1>
                    </div>
                    <div id='ceo-description-container'>
                        <p><?php echo $product->getCeoDescription();  ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php UtilsModel::load_footer();?>
    </footer>
</body>
</html>