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
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>