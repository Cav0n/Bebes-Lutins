<?php

$product_id = $_REQUEST['product_id'];
$product = ProductGateway::SearchProductByID2($product_id);
$categories = CategoryGateway::GetCategories();

$error = $_POST['error-message-products'];

?>

<!DOCTYPE html>
<html style="background: #3b3f4d;" lang="fr">
<head>
    <title>ADMINISTRATION - BEBES LUTINS</title>
    <meta name="description" content="Bienvenue dans votre tout nouveau tableau de bord."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="dashboard4">
<?php AdminModel::load_administration4_header(); ?>
<main>
    <div class="pre-page-title horizontal between">
        <a href="https://www.bebes-lutins.fr/dashboard4/produits/"><i class="fas fa-angle-left"></i> Produits</a>
    </div>
    <div class="page-title-container horizontal between">
        <h2><?php echo $product->getName(); ?></h2>
    </div>
    <div id="error-product" class="vertical <?php if($error == null) echo 'hidden';?>">
        <p>Il y a des erreurs avec la mise à jour du produit :</p>
        <p class="message"><?php echo $error;?>Une petite erreur gentille.</p>
    </div>
    <form id="edition-wrapper" class="horizontal" method="post" action="https://www.bebes-lutins.fr/dashboard4/produits/sauvegarder/">
        <input type="hidden" name="product_id" value="<?php echo $product->getId();?>">
        <input type="hidden" name="id_copy" value="<?php echo $product->getIdCopy();?>">
        <input type="hidden" name="image_name" value="<?php echo $product->getImage()->getName();?>">
        <input class="hidden" type="file" id="uploadFile" name="uploadFile[]" required multiple/>
        <div class="column-big vertical">
            <div class="product-title-description-container edition-window">
                <div class="custom-id vertical">
                    <label for="custom-id">Référence</label>
                    <div class="label-container horizontal">
                        <p class="euro-sign vertical">#</p>
                        <input id="custom-id" type="text" name="reference" placeholder="000" value="<?php echo $product->getReference(); ?>">
                    </div>
                </div>
                <div class="title vertical">
                    <label for="title">Titre</label>
                    <input id="title" type="text" name="name" placeholder="Une petite couche mignonne" value="<?php echo $product->getName(); ?>">
                </div>
                <div class="description vertical">
                    <label for="big-description-instance">Description</label>
                    <textarea class="element" id="big-description-instance" name="description" ><?php echo $product->getDescription(); ?></textarea>
                </div>
            </div>
            <div class="product-images-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Images</p>
                    <label for="uploadFile"><a >Télécharger une image</a></label>
                </div>
                <?php if($product->getImage()->getName() == null) { ?>
                <div class="empty-product-images horizontal">
                    <img class="image-example" src="https://www.bebes-lutins.fr/view/assets/images/utils/picture.svg" alt="image-sample">
                </div>
                <?php } else { ?>
                <div class="product-images horizontal">
                    <input class="ajout-categorie-field" type="hidden" name="MAX_FILE_SIZE" value="10485760">
                    <input class="ajout-categorie-field" type="file" name="image" id="file-input" onchange="img_categorie(this);" style="display: none;">
                    <label for="file-input" id="categort-image-container">
                        <img class="product-image" src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage()->getName(); ?>" alt="Image du produit">
                    </label>
                    <div id="thumbnails-container" class="vertical wrap between">
                        <?php foreach ($product->getImage()->getThumbnails() as $thumbnail) { ?>
                            <img  class="thumbnail" src="https://www.bebes-lutins.fr/view/assets/images/thumbnails/<?php echo $thumbnail->getName(); ?>" alt="<?php echo $thumbnail->getName(); ?>">
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="ceo-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Référencement</p>
                </div>
                <div class="preview-container">
                    <p id="empty-preview" class="empty">Ajouter un titre et une description pour voir comment le produit apparaitra dans les moteurs de recherches.</p>
                    <div id="preview" class="not-empty vertical">
                        <p id="product-name"><?php echo $product->getCeoName(); ?></p>
                        <p id="product-link"><?php echo "https://www.bebes-lutins.fr/produit/".$product->getId(); ?></p>
                        <p id="product-description"><?php echo $product->getCeoDescription(); ?></p>
                    </div>
                </div>
                <div class="ceo-title-description-url-container">
                    <div class="ceo-title">
                        <div class="label-with-extra horizontal between">
                            <label for="ceo-title">Titre de la page</label>
                            <div class="horizontal">
                                <p id="counter-ceo-title">0</p>
                                <p>&nbsp;sur 70 caractères utilisés</p>
                            </div>
                        </div>
                        <input id="ceo-title" type="text"  name="ceo_name" maxlength="70" value="<?php echo $product->getCeoName(); ?>">
                        <div class="label-with-extra horizontal between">
                            <label for="ceo-description">Méta-description</label>
                            <div class="horizontal">
                                <p id="counter-ceo-description">0</p>
                                <p>&nbsp;sur 320 caractères utilisés</p>
                            </div>
                        </div>
                        <textarea id="ceo-description" name="ceo_description" maxlength="320"><?php echo $product->getCeoDescription(); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="column-tiny vertical">
            <div class="product-price-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Prix</p>
                </div>
                <div class="price vertical">
                    <label for="price">Prix</label>
                    <div class="label-container horizontal">
                        <p class="euro-sign vertical">€</p>
                        <input id="price" name="price" type="number" step="0.01" min="0" max="10000" value="<?php echo $product->getPrice(); ?>">
                    </div>
                </div>
            </div>
            <div class="product-stock-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Stocks</p>
                </div>
                <div class="stock vertical">
                    <label for="stock">Quantité</label>
                    <input id="stock" name="stock" type="number" step="1" min="0" max="10000" value="<?php echo $product->getStock(); ?>">
                </div>
            </div>
            <div class="product-organisation-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Organisation</p>
                </div>
                <div class="category vertical">
                    <div id="categories-add-container" class="vertical">
                        <div class="horizontal between">
                            <label for="category-select">Catégories</label>
                            <i class="fas fa-plus vertical centered" onclick="addSelectInput()"></i>
                        </div>
                        <?php foreach ($product->getCategory() as $product_category) { ?>
                        <div id="category-selector" class="category-selector horizontal">
                            <select id="category-select" name="category[]">
                                <?php foreach ($categories as $category) { if($category->getParent() != "none") {?>
                                    <optgroup label="<?php echo $category->getParent();?>">
                                        <option value="<?php echo $category->getName(); ?>" <?php if($category->getName() == $product_category->getName()){echo 'selected';}?>><?php echo $category->getName();?></option>
                                    </optgroup>
                                <?php } } ?>
                            </select>
                            <i class="fas fa-minus remove-parent vertical centered" style="margin-left: 10px;"></i>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="tags vertical">
                    <label for="tags">Tags</label>
                    <input id="tags" type="text" name="tags" placeholder="Couches, bébés..." value="<?php echo $product->getTags();?>">
                </div>
                <div class="hide vertical">
                    <label class="container vertical centered">Cacher le produit
                        <input type="checkbox" name="hide"<?php if($product->getHide()) echo "checked"; ?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>

            <span id="deleting-button" class="vertical centered" onclick="delete_product('<?php echo $product->getId(); ?>')">
                Supprimer le produit
            </span>
        </div>
    </form>
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
</script>
<script>
    $('#ceo-title').keyup(updateCountTitle);
    $('#ceo-title').keydown(updateCountTitle);

    function updateCountTitle() {
        var cs = $(this).val().length;
        $('#counter-ceo-title').text(cs);
        $('#product-name').text($('#ceo-title').val());
    }

    $('#ceo-description').keyup(updateCountDescription);
    $('#ceo-description').keydown(updateCountDescription);

    function updateCountDescription() {
        var cs = $(this).val().length;
        $('#counter-ceo-description').text(cs);
        $('#product-description').text($('#ceo-description').val());
    }
</script>
<script>
    bkLib.onDomLoaded(function() {
        var myNicEditor = new nicEditor({fullPanel : true, iconsPath: 'https://www.bebes-lutins.fr/view/assets/js/nicEditorIcons.gif'});
        myNicEditor.panelInstance('big-description-instance');
    });

    $(document).on("click", ".remove-parent", function(){
        if($("div[class*='category-selector']").length >1) {
            $(this).parent().remove();
        }
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

    function addSelectInput(){
        $("#category-selector").clone().appendTo("#categories-add-container");
    }

    function delete_product(id){
        document.location.href='https://www.bebes-lutins.fr/dashboard4/produits/supprimer/' + id;
    }
</script>
</html>