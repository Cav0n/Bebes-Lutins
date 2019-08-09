<?php 
$product = ProductGateway::SearchProductByID2($_REQUEST['id']);
$reviews_list = ReviewGateway::GetAllReviewForProduct($product->getId());

/* Breadcrumb */
$category = CategoryGateway::GetCategory($product->getCategory()[0]->getName());
$category_parent = $category->getParent();

$category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category->getName())));
$parent_category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category_parent)));

if(isset($_SESSION['connected_user'])){
    $user_container = new UserContainer(unserialize($_SESSION['connected_user']));
    $user = $user_container->getUser();

    $whishlistID = $user->getWishListID();
} else {
    $whishlistID = '';
}
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
    <main id='product-page-main'>
        <div id='product-page-container'>
            <div id='breadcrumb-container' class='horizontal centered'>
                <p id='breadcrumb'><a href='https://www.bebes-lutins.fr'> Accueil </a> <b> / </b> <a href='https://www.bebes-lutins.fr/categorie/<?php echo $parent_category_name_url; ?>'><?php echo $category_parent; ?></a> <b> / </b> <a href='https://www.bebes-lutins.fr/categorie/<?php echo $category_name_url; ?>'><?php echo $category->getName(); ?></a> <b> / </b> <i><?php echo $product->getName(); ?></i></p>
            </div>
            <div id='product-presentation-container' class='horizontal'>
                <div id='product-informations' class='horizontal'>
                    <div id='left-column' class='vertical'>
                        <div id='images-container' class='horizontal'>
                            <div id='thumbnails-container' class='vertical'>
                                <img class="thumbnail transition-fast" src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage()->getName(); ?>" onclick="update_image('https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage()->getName(); ?>')">
                                <?php foreach($product->getImage()->getThumbnails() as $thumbnail) { ?>
                                <img class="thumbnail transition-fast" src="https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName();?>" onclick="update_image('https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName(); ?>')">
                                <?php } ?>
                            </div>
                            <div id='main-image-container'>
                                <div>
                                    <img id='big-image' class='desktop' src='https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage()->getName(); ?>' alt='<?php echo $product->getName(); ?>'>
                                </div>
                                <div>
                                    <img id='mobile-image' class='mobile' src='https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage()->getName(); ?>' alt='<?php echo $product->getName(); ?>'>
                                </div>
                            </div>
                        </div>
                        <div id='social-media-container' class='horizontal between'>
                            <a id='facebook-link' class='horizontal' target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.bebes-lutins.fr%2Fproduct-test%2Fproduct-5ce7f760c4eaf&amp;src=sdkpreparse">
                                <?php echo file_get_contents("https://www.bebes-lutins.fr/view/assets/images/utils/icons/facebook.svg"); ?>
                                <p class='vertical centered'>Partager sur FaceBook</p>
                            </a>
                            <a id='instagram-link' class='vertical centered' target="_blank" href="https://www.instagram.com/bebeslutins/">
                                <?php echo file_get_contents("https://www.bebes-lutins.fr/view/assets/images/utils/icons/instagram.svg"); ?>
                            </a>
                        </div>
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
                <div id='extra-column' class='vertical'>
                    <div class="vertical">
                        <div id='price-container' class='horizontal centered'>
                            <p id='price' class='vertical centered'><?php echo UtilsModel::FloatToPrice($product->getPrice()); ?></p>
                        </div>

                        <form id='add-to-cart-container' class='horizontal' method="post" action="https://www.bebes-lutins.fr/panier/ajout-produit" style="margin:0.5rem 0;">
                            <input type="hidden" name="product_id" value="<?php echo $product->getId();?>">
                            <input id='quantity-input' name='quantity' type='number' value='1' placeholder='1' min='1' max='<?php echo $product->getStock(); ?>' step='1' required>
                            <button id='add-to-cart-button' type='submit' style='padding:0 0.5rem;'>Ajouter au panier</button>
                        </form>
                        <form id='add-to-cart-container' class='horizontal' method="post" action="https://www.bebes-lutins.fr/espace-client/liste-envie/ajout-produit">
                            <input type="hidden" name="product_id" value="<?php echo $product->getId();?>">
                            <input type="hidden" name="wishlist_id" value="<?php echo $whishlistID; ?>">
                            <button id='add-to-cart-button' class='add-to-wishlist horizontal between' type='submit' <?php if(! isset($_SESSION['connected_user'])) echo 'disabled=\'disabled\''?>><?php echo file_get_contents("view/assets/images/utils/icons/heart.svg"); ?><p class='vertical centered'>Ajouter a ma liste</p></button>
                        </form>
                        <?php if(! isset($_SESSION['connected_user'])) echo '<p id="infos-buttons" style="font-size:0.8rem;">Vous devez être connecté pour ajouter un produit à votre liste d\'envie.</p>'?>
                    </div>
                </div>
            </div>
            <div id='product-description-container' class='vertical'>
                <h2>Description</h2>
                <div id='description'>
                    <?php echo $product->getDescription(); ?>
                </div>
            </div>

            <div id='product-review-container' class='vertical'>
                <h2 style='font-family: Roboto, sans-serif;margin-bottom: 1rem;'>Avis clients</h2>
                <?php if($product->getNumberOfReview() == 0) { ?>
                    <p>Il n'y a aucun avis sur le produit pour l'instant.</p>
                <?php } ?>
            </div>

            <?php UtilsModel::load_certifications(); ?>
        </div>
    </main>
    <footer>
        <?php UtilsModel::load_footer();?>
    </footer>
</body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.3"></script>
<script>
    $(document).ready(function(){
        $('#big-image')
            .css('border-radius', '2px')
            .parent()
            .zoom({magnify: 1.2});
    });

    function update_image(img) {
        $("#big-image").attr("src", img).trigger('zoom.destroy');
        $("#big-image")
            .css('border-radius', '2px')
            .parent()
            .zoom({magnify: 1.2});
        
        $("#mobile-image").attr("src", img)
    }
</script>
</html>