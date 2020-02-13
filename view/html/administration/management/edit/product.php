<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:56
 */

if(isset($_SESSION['id_product'])){
    $product_id = $_SESSION['id_product'];
    unset($_SESSION['id_product']);
}else {
    $product_id = $_REQUEST['id_product'];
}

$product = ProductGateway::SearchProductByID($product_id);


?>
<!DOCTYPE html>
<html style="background: #3b3f4d;">
<head>
    <title>ADMINISTRATION - BEBES LUTINS</title>
    <meta name="description" content="Bienvenue dans votre tout nouveau tableau de bord."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="administration">
<header>
    <a href="https://www.bebes-lutins.fr" class="no-decoration"><h1>BEBES LUTINS</h1></a>
    <div id="header-tabs" class="tabs">
        <button id="orders" class="header-button non-selected" onclick="tab_selection_changed_header('orders')">
            <div class="horizontal tab">
                <i class="fas fa-boxes fa-2x"></i>
                <p>Commandes</p>
            </div>
        </button>
        <button id="products" class="header-button selected" onclick="tab_selection_changed_header('products')">
            <div class="horizontal tab">
                <i class="fas fa-sitemap fa-2x"></i>
                <p>Produits</p>
            </div>
        </button>
        <button id="users" class="header-button non-selected" onclick="tab_selection_changed_header('users')">
            <div class="horizontal tab">
                <i class="fas fa-users fa-2x"></i>
                <p>Utilisateurs</p>
            </div>
        </button>
        <button id="various" class="header-button non-selected" onclick="tab_selection_changed_header('various')">
            <div class="horizontal tab">
                <i class="fas fa-chart-line fa-2x"></i>
                <p>Divers</p>
            </div>
        </button>
    </div>
</header>
<main>
    <div id="options">

    </div>
    <div id="category-add-wrapper" class="vertical">
        <h1>Modification d'un produit</h1>
        <p style="text-align: center;">(<?php echo $product->getCategory()->getName(); ?>)</p>
        <form class="category-add-form" method="post" action="https://www.bebes-lutins.fr/dashboard/modifier-produit" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product->getId();?>">
            <input type="hidden" name="id_copy" value="<?php echo $product->getIdCopy();?>">
            <input type="hidden" name="old_image_name" value="<?php echo $product->getImage();?>">
            <input type="hidden" name="category" value="<?php echo $product->getCategory()->getName();?>">
            <div id="categorie-image-texte" class="horizontal centered">
                <input class="ajout-categorie-field" type="hidden" name="MAX_FILE_SIZE" value="10485760">
                <input class="ajout-categorie-field" type="file" name="image" id="file-input" onchange="img_categorie(this);" style="display: none;">
                <label for="file-input" id="categort-image-container">
                    <img  width="300px" height="300px" id="category-image" src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage();?>" alt="Image de la categorie" title="Image de la categorie">
                </label>
                <div class="vertical category-text centered">
                    <label class="text-label" for="custom_id">Référence :</label>
                    <input class="ajout-categorie-field ajout-categorie-text" type="text" name="custom_id" id="custom_id" value="<?php if($product->getReference() != null) echo $product->getReference(); ?>" placeholder="Référence du produit">
                    <label class="text-label" for="product-name">Nom :</label>
                    <input class="ajout-categorie-field ajout-categorie-text" type="text" name="name" id="product-name" value="<?php echo $product->getName();?>" required>
                    <label class="text-label" for="product-price">Prix :</label>
                    <input class="ajout-categorie-field ajout-categorie-text" type="number" min='0' step="0.01" name="price" id="product-price" placeholder="Prix" value="<?php echo $product->getPrice();?>" required>
                    <label class="text-label" for="product-stock">Stock :</label>
                    <input class="ajout-categorie-field ajout-categorie-text" type="number" min="0" step="1" name="stock" id="product-stock" placeholder="Stock" value="<?php echo $product->getStock();?>" required>
                </div>
            </div>
            <div id="product-descriptions" class="vertical">
                <label class="text-label" for="category-description"> Description courte :</label>
                <textarea class="ajout-categorie-field ajout-categorie-text" name="description_small" id="category-description" placeholder="Une courte description qui décrit rapidement le produit." required><?php echo $product->getCeoDescription();?></textarea>
                <label class="text-label" for="category-description"> Description longue :</label>
                <textarea class="element" id="big-description-instance" name="description_big" ><?php echo $product->getDescription();?></textarea>
            </div>
            <div id="category-add-button" class="horizontal centered">
                <button type="submit">Modifier le produit</button>
            </div>
        </form>
    </div>
    <div id="thumbnails-edition-wrapper" class="vertical">
        <h2 style="
    font-size: 2em;
    width: fit-content;
width: max-content;
    margin: 0 auto;
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px solid #999999;">Vignettes</h2>
        <div class="thumbnails horizontal centered wrap">
            <div class="thumbnail">
                <img  width="150px" height="150px" id="category-image" src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage();?>" alt="Image de la categorie" title="Image de la categorie">
            </div>

            <?php foreach ($product->getImage()->getThumbnails() as $thumbnail){
                $thumbnail = new Image($thumbnail->getName());
                ?>
                <form method="post" action="https://www.bebes-lutins.fr/dashboard/supprimer-thumbnail" class="thumbnail vertical">
                    <img  width="150px" height="150px" id="category-image" src="https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName();?>" alt="Une vignette" title="Une vignette">
                    <input type="hidden" name="thumbnail_name" value="<?php echo $thumbnail->getName();?>">
                    <input type="hidden" name="product_id" value="<?php echo $product->getId();?>">
                    <button type="submit">Supprimer</button>
                </form>
                <?php
            }?>
            <form id="add-thumbnail-form" class="thumbnail add" method="post" action="https://www.bebes-lutins.fr/dashboard/ajout-vignette" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $product->getId();?>">
                <input class="ajout-categorie-field" type="hidden" name="MAX_FILE_SIZE" value="10485760">
                <input class="thumbnail-add" type="file" name="image" id="thumbnails-add" onchange="thumbnail_new(this);" style="display: none;">
                <label for="thumbnails-add" id="categort-image-container">
                    <img  width="150px" height="150px" id="new-thumbnail-image" src="https://placehold.it/150" alt="Image de la categorie" title="Image de la categorie">
                </label>
            </form>
        </div>
    </div>
</main>
</body>
<script>
    function img_categorie(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#category-image').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function thumbnail_new(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#new-thumbnail-image').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

            document.getElementById("add-thumbnail-form").submit();
        }
    }

    function tab_selection_changed_header(new_selected_id){
        document.location.href="https://www.bebes-lutins.fr/dashboard/tab-"+new_selected_id;
    }


    bkLib.onDomLoaded(function() {
        var myNicEditor = new nicEditor({fullPanel : true, iconsPath: 'https://www.bebes-lutins.fr/view/assets/js/nicEditorIcons.gif'});
        myNicEditor.panelInstance('big-description-instance');
    });

    function validate()
    {
        var nicInstance = nicEditors.findEditor('big-description-instance');
        var messageContent = nicInstance.getContent();
        //since nicEditor sets default value of textarea as <br>
        //we are checking for it
        if(messageContent=="<br>") {
            alert("La description complète est vide.");
            document.mainfrm.big-description-instance.focus();
            return false;
        }
        else {
            alert("valid");
        }
        return true;
    }
</script>
</html>