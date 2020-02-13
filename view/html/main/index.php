<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:11
 */

if(!isset($_SESSION['limit_product_display'])) $_SESSION['limit_product_display'] = 8;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Bebes Lutins - couche lavable écologique pour bébé</title>
    <meta name="description" content="Découvrez les couches lavables éco-citoyennes de Bébés Lutins ! Fabriquées en France, elles sont écologiques et sans produits toxiques pour le bien-être de bébé."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
    <header>
        <?php UtilsModel::load_header();?>
    </header>
    <main>
        <!-- <div id='alert-container' class='horizontal mobile'>
            <div class='vertical'>
                <p id='title'>CONGÉS ANNUELS</h1>
                <p>Chers clients, nous vous informons que les commandes passées à partir du 13 juillet seront expédiées à partir du 29 juillet. <BR>Merci pour votre compréhension.</p>
            </div>
        </div> -->
        <?php UtilsModel::load_swiper();?>
        <div id='homepage-container' class='vertical'>
            <div id="website-infos" class="horizontal center desktop">
                <h1>Bébés Lutins, le spécialiste de la couche lavable écologique et écocitoyenne pour bébé.</h1>
                <p>Bébés Lutins vous propose sa gamme de couches lavables pour bébé et accessoires, confectionnés en France par nos couturières.<BR>
                    Nous sélectionnons soigneusement les tissus certifiés Oeko-Tex pour offrir une couche lavable écologique qui respecte la peau de bébé. Nos modèles sont conçus pour s'adapter à la morphologie de bébé, tout en lui offrant confort et bien-être.</p>
            </div>
            <div id='website-infos' class="vertical center mobile">
            <h1>Bébés Lutins, le spécialiste de la couche lavable écologique et écocitoyenne pour bébé.</h1>
                <p>Bébés Lutins vous propose sa gamme de couches lavables pour bébé et accessoires, confectionnés en France par nos couturières.<BR>
                    Nous sélectionnons soigneusement les tissus certifiés Oeko-Tex pour offrir une couche lavable écologique qui respecte la peau de bébé. Nos modèles sont conçus pour s'adapter à la morphologie de bébé, tout en lui offrant confort et bien-être.</p>
            </div>
            <?php UtilsModel::load_products_display();?>
            <form method="post" action="#" class="product-display-button-form horizontal centered">
                <button type="submit" formaction="https://www.bebes-lutins.fr/afficher-tout" class="<?php if($_SESSION['limit_product_display'] == -1) echo 'hidden';?> transition-fast">Afficher tous les produits</button>
                <button type="submit" formaction="https://www.bebes-lutins.fr/afficher-moins" class="<?php if($_SESSION['limit_product_display'] != -1) echo 'hidden';?> transition-fast">Afficher moins de produits</button>
            </form>
            <?php UtilsModel::load_certifications();?>
        </div>
    </main>

    <footer>
        <?php UtilsModel::load_footer();?>
    </footer>

    <div class="popup hidden" id="popup-add-to-shopping-cart">
        <div class="popup-background" onclick="hide_product_popup()">

        </div>
        <div class="popup-inner horizontal">
            <img id="product-image" src="">
            <div class="popup-texts vertical">
                <p id="product-name">Nom du produit</p>
                <p id="product-description">Petite description du produit</p>
                <form method="post" class="horizontal between" action="https://www.bebes-lutins.fr/panier/ajout-produit">
                    <p id="product-price">00,00€</p>
                    <div class="quantity-button horizontal">
                        <div class="vertical">
                            <label for="quantity">Quantité : </label>
                            <select id="quantity" name="quantity">
                                <?php for($i=1; $i<=15; $i++){?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <input id="product-id" type="hidden" name="product_id" value="0">
                        <button type="submit">Ajouter au panier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    function show_product_popup(id, image, name, description, price){
        $("#popup-add-to-shopping-cart").removeClass("hidden").addClass("display");
        document.getElementById("product-id").value = id;
        document.getElementById("product-name").innerHTML = name;
        document.getElementById("product-description").innerHTML = description;
        document.getElementById("product-image").src = "https://www.bebes-lutins.fr/view/assets/images/products/"+image
        document.getElementById("product-price").innerHTML = price;
    }

    function hide_product_popup(){
        $("#popup-add-to-shopping-cart").removeClass("display").addClass("hidden");
    }
</script>
</html>