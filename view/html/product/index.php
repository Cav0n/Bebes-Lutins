<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:35
 */

$isAdmin = false;

if(isset($_SESSION['connected_user'])){
    $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
    $customer_name = $user->getFirstname() . " " . substr($user->getSurname(), 0, 1) . ".";
    $customer_id = $user->getId();
    $allow_new_review = "vertical";

    if($user->getPrivilege() > 2) {
        $isAdmin = true;
    }
}
else {
    $customer_id = null;
    $allow_new_review = "hidden";
}

if(isset($_SESSION['review-message'])) {
    $review_message = $_SESSION['review-message'];
    unset($_SESSION['review-message']);
}

$product_id = $_GET['id'];
$product = ProductGateway::SearchProductByID2($product_id);
$_SESSION['product'] = serialize($product);

$reviews_list = ReviewGateway::GetAllReviewForProduct($product_id);
if(empty($reviews_list)) {
    $display_reviews = 'hidden';
    if (!isset($_SESSION['connected_user'])) {
        $display_nothing = 'hidden';
    } else $display_nothing = 'vertical';
}
else {
    $display_reviews = 'vertical';
    if(isset($_SESSION['connected_user'])) {
        foreach ($reviews_list as $review) {
            $review = ReviewContainer::GetReview($review);
            if ($review->getCustomer()->getId() == $user->getId()){
                $allow_new_review = "hidden";
            }
        }
    }
}

$average_mark = $product->getAverageMark();
$number_of_reviews = $product->getNumberOfReview();

$name = $product->getName();
$small_description = $product->getCeoDescription();
$big_description = $product->getDescription();
$price = $product->getPrice();
$price_string = str_replace("EUR", "€", money_format('%.2n', $price));
$image = $product->getImage()->getName();
$image_component = "<img id='big-image'  src='https://www.bebes-lutins.fr/view/assets/images/products/$image' alt='$name'>";

$thumbnails = $product->getImage()->getThumbnails();


$category = (new CategoryContainer($product->getCategory()[0]))->getCategory();
$category_name = $category->getName();
$category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category_name)));
$parent_category = $category->getParent();
$parent_category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($parent_category)));

if($parent_category != "none" && $parent_category != null) $breadcrump = "<p><a href='https://www.bebes-lutins.fr/'> Accueil </a> <i class=\"fas fa-angle-right\"></i> <a href='https://www.bebes-lutins.fr/categorie/$parent_category_name_url'> $parent_category </a> <i class=\"fas fa-angle-right\"></i> <a href='https://www.bebes-lutins.fr/categorie/$category_name_url' > $category_name </a> <i class=\"fas fa-angle-right\"></i> <a href='https://www.bebes-lutins.fr/produit/$product_id'> $name </a></p>";
else $breadcrump = "<p><a href='https://www.bebes-lutins.fr/'> Accueil </a> <i class=\"fas fa-angle-right\"></i> <a href='https://www.bebes-lutins.fr/categorie/$category_name_url'> $category_name </a> <i class=\"fas fa-angle-right\"></i> <a href='https://www.bebes-lutins.fr/produit/$product_id'> $name </a></p>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $name;?> - Bebes Lutins</title>
    <meta name="description" content="<?php echo $small_description;?>"/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <div id="product-page" class="desktop vertical">
        <div id="breadcrumb" class="desktop">
            <?php echo $breadcrump;?>
        </div>
        <div id="top" class="horizontal centered">
            <div class="thumbnails vertical top desktop">
                <img class="thumbnail transition-fast" src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $image;?>" alt="<?php echo $product->getName();?>" title="<?php echo $product->getName();?>" onclick="update_image('https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $image;?>')">
                <?php if($thumbnails != null){foreach ($thumbnails as $thumbnail){ ?>
                    <img class="thumbnail transition-fast" src="https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName();?>" onclick="update_image('https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName();?>')">
                <?php }}?>
            </div>
            <div class="product horizontal">
                <div class="product_image">
                    <?php echo $image_component;?>
                </div>
                <div class="text vertical">
                    <h1><?php echo $name;?></h1>
                    <?php if($average_mark > 0) {
                        ?>
                        <div class="average-mark horizontal">
                            <p class="starability-result" data-rating="<?php echo round($average_mark);?>"></p>
                            <a href="#reviews" class="vertical centered js-scrollTo"><?php echo $average_mark?> - <?php echo $number_of_reviews?> avis</a>
                        </div><?php
                    }?>
                    <p class="horizontal price end mobile"><?php echo $price_string;?></p>
                    <p class="medium description-small"><?php echo $small_description;?></p>
                    <form class="horizontal price desktop" method="post" action="https://www.bebes-lutins.fr/panier/ajout-produit">
                        <p class="vertical centered"><?php echo $price_string;?></p>
                        <label class="vertical centered" for="quantity">Quantité : </label>
                        <select id="quantity" name="quantity">
                            <?php
                            if($product->getStock() > 15) $stock = 15;
                            else $stock = $product->getStock();
                            for($i=1; $i<=$stock; $i++){?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php }?>
                        </select>
                        <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                        <button type="submit">Ajouter au panier</button>
                    </form>
                    <form class="vertical buttons mobile" method="post" action="https://www.bebes-lutins.fr/panier/ajout-produit">
                        <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="bottom" class="vertical centered">
            <div class="big-description vertical">
                <h2 style="    margin-bottom: 10px;
    border-bottom: 1px solid #888888;
    width: fit-content;
width: max-content;
    padding-right: 10px;">Descriptif</h2>
                <div id="big-description">
                    <?php echo $big_description;?>
                </div>
            </div>
            <div id="reviews" class="<?php echo $display_nothing; ?> vertical">
                <h2>Commentaires</h2>
                <form id="product-review" method="post" action="https://www.bebes-lutins.fr/produit/<?php echo $product_id?>/ajouter-avis" class="<?php echo $allow_new_review;?>">
                    <p><?php echo $review_message;?></p>
                    <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                    <input type="hidden" name="customer_name" value="<?php echo $customer_name;?>">
                    <input type="hidden" name="customer_id" value="<?php echo $customer_id?>">
                    <fieldset class="starability-checkmark">
                        <legend>Note :</legend>
                        <input type="radio" id="rate1" name="rating" value="1" />
                        <label for="rate1" title="Mauvais">1 star</label>

                        <input type="radio" id="rate2" name="rating" value="2" />
                        <label for="rate2" title="Passable">2 stars</label>

                        <input type="radio" id="rate3" name="rating" value="3" />
                        <label for="rate3" title="Bien">3 stars</label>

                        <input type="radio" id="rate4" name="rating" value="4" />
                        <label for="rate4" title="Très bien">4 stars</label>

                        <input type="radio" id="rate5" name="rating" value="5" checked/>
                        <label for="rate5" title="Incroyable">5 stars</label>
                    </fieldset>
                    <div class="vertical">
                        <textarea class="review-text" name="review-text" placeholder="Ecrivez votre avis sur le produit."></textarea>
                        <button type="submit">Valider</button>
                    </div>
                </form>
                <div id="product-reviews" class="<?php echo $display_reviews?> vertical">
                    <?php foreach ($reviews_list as $review){
                        if(!$review->isDeclined()) {

                            $product_review = ReviewContainer::GetReview($review);
                            $review_id = $product_review->getId();
                            $rating = $product_review->getMark();
                            $review_text = $product_review->getText();
                            $review_customer_name = $product_review->getCustomerName();
                            $review_customer_id = $product_review->getCustomer()->getId();

                            if ($review_customer_id == $customer_id) $button = "<button onclick='delete_review(\"$review_id\", \"$product_id\")'>Supprimer</button>"
                            ?>
                            <div class="product-review">
                                <div class="review-header horizontal">
                                    <p class="starability-result" data-rating="<?php echo $rating ?>">
                                        Note: <?php echo $rating; ?> stars
                                    </p>
                                    <p class="review-customer-name vertical">
                                        - <?php echo $review_customer_name; ?>
                                    </p>
                                </div>
                                <p class="review-text"><?php echo $review_text; ?></p>
                                <?php echo $button; ?>
                            </div>
                            <?php
                        }
                    } ?>
                </div>
            </div>
        </div>
        <?php if($isAdmin){?>
            <form id="admin-edit-product" method="post" action="https://www.bebes-lutins.fr/dashboard4/produits/edition/<?php echo $product->getId();?>" class="horizontal centered desktop">
                <button type="submit" class="transition-fast">Editer le produit</button>
            </form>
        <?php }?>
    </div>
    <div id="product-page-mobile" class="vertical mobile">
        <div class="product-images vertical">
            <div class="big-image">
                <img id='big-image-mobile' src='https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $image;?>'>
            </div>
            <div class="thumbnails horizontal">
                <img class="thumbnail transition-fast" src='https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $image;?>' onclick="update_image_mobile('https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $image;?>')">
                <?php if($thumbnails != null){
                    foreach ($thumbnails as $thumbnail){ ?>
                    <img class="thumbnail transition-fast" src="https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName();?>" onclick="update_image_mobile('https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName();?>')">
                <?php }
                }?>
            </div>
        </div>
        <div class="product-texts">
            <div id="product-summary">
                <h1><?php echo $name;?></h1>
                <p class="small-description"><?php echo $small_description;?></p>
                <form class="button-and-price horizontal" method="post" action="https://www.bebes-lutins.fr/panier/ajout-produit">
                    <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit">Acheter</button>
                    <p class="price"><?php echo $price_string;?></p>
                </form>
            </div>
            <div id="product-description">
                <h2>Description</h2>
                <p class="big-description"><?php echo $big_description;?></p>
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
    function delete_review(review_id, product_id) {
        $.ajax({
            url: 'https://www.bebes-lutins.fr',
            type: 'POST',
            data: {review_id:review_id, action:"delete_review"},
            success: function(){
                document.location.href="https://www.bebes-lutins.fr/produit/"+product_id;
            }
        });
    }

    function update_image(img) {
        $("#big-image").attr("src", img).trigger('zoom.destroy');
        $("#big-image")
            .wrap('<span style="display:flex;border-radius: 9px 0 0 9px;"></span>')
            .css('display', 'block')
            .parent()
            .zoom({magnify: 1.2});
    }
    $(document).ready(function(){
        $('#big-image')
            .parent()
            .zoom({magnify: 1.2});
    });

    function update_image_mobile(img){
        $("#big-image-mobile").attr("src", img);
    }
</script>

<script>
    $(document).ready(function() {
        $('.js-scrollTo').on('click', function() { // Au clic sur un élément
            var page = $(this).attr('href'); // Page cible
            var speed = 750; // Durée de l'animation (en ms)
            $('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
            return false;
        });
    });
</script>
</html>