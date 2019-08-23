<?php

$categories = CategoryGateway::GetCategories();

if(isset($_SESSION['error_message']) && $_SESSION['error_message'] != null){
    $error_message = $_SESSION['error_message'];

    $reference = $_SESSION['reference'];
    $name = $_SESSION['name'];
    $description = $_SESSION['description'];
    $ceo_name = $_SESSION['ceo_name'];
    $ceo_description = $_SESSION['ceo_description'];
    $price = $_SESSION['price'];
    $stock = $_SESSION['stock'];
    $tags = $_SESSION['tags'];
    $hide = $_SESSION['hide'];
    $category_name = $_SESSION['category'];

    unset($_SESSION['error_message']);
} else $error_message = null;
$category_index = 0;

if($_REQUEST['product_id']!=null){
    $product = ProductGateway::SearchProductByID2($_REQUEST['product_id']);
    $name = $product->getName();
    $description = $product->getDescription();
    $image_name = $product->getImage()->getName();
    $thumbnails = $product->getImage()->getThumbnails();
    $ceo_name = $product->getCeoName();
    $ceo_description = $product->getCeoDescription();
    $price = $product->getPrice();
    $stock = $product->getStock();
    $product_categories = $product->getCategory();
    $hide = $product->getHide();
}

if(isset($_SESSION['success'])){
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
} else $success = null;

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
        <h2>Ajouter un produit</h2>
    </div>
    <div id="extra-buttons" class="horizontal">
        <button onclick="goToImportPage()">Importer un produit</button>
    </div>
    <?php if($success != null) { ?>
    <div id='success' class="vertical">
        <p>Le produit a bien été sauvegardé.</p>
    </div>
    <?php } ?>
    <?php if($error_message != null){ ?>
    <div id="error-message-container">
        <p id="error-title">Une erreur s'est produite</p>
        <p id="error-message"><?php echo $error_message; ?></p>
    </div>
    <?php } ?>
    <form id="edition-wrapper" class="horizontal" method="post" action="https://www.bebes-lutins.fr/dashboard4/produits/sauvegarder/" enctype="multipart/form-data">
        <input id="image-name" type="hidden" name="image_name" value="<?php echo $image_name;?>">
        <input id="thumbnails-name" type="hidden" name="thumbnails_name" value="">
        <div class="column-big vertical">
            <div class="product-title-description-container edition-window">
                <div class="custom-id vertical">
                    <label for="reference">Référence</label>
                    <div class="label-container horizontal">
                        <p class="euro-sign vertical">#</p>
                        <input id="reference" type="text" name="reference" placeholder="000" value="<?php echo $reference; ?>">
                    </div>
                </div>
                <div class="title vertical">
                    <label for="title">Titre</label>
                    <input id="title" type="text" name="name" placeholder="Une petite couche mignonne" value="<?php echo $name; ?>">
                </div>
                <div class="description vertical">
                    <label for="big-description-instance">Description</label>
                    <div id="myNicPanel"></div>
                    <textarea class="element" id="big-description-instance" name="description" style="width:100%;"><?php echo $description; ?></textarea>
                </div>
            </div>
            <div class="product-images-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Image du produit</p>
                </div>
                <div id="main-dropzone" class="dropzone" style="border: 1px dashed;border-radius: 3px;">

                </div>
            </div>
            <div class="product-images-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Miniatures du produit</p>
                </div>
                <div id="thumbnails-dropzone" class="dropzone" style="border: 1px dashed;border-radius: 3px;">

                </div>
            </div>
            <div class="ceo-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Référencement</p>
                </div>
                <div class="preview-container">
                    <p>Ajouter un titre et une description pour voir comment le produit apparaitra dans les moteurs de recherches.</p>
                    <div id="preview" class="not-empty vertical">
                        <p id="product-name"><?php echo $ceo_name; ?></p>
                        <p id="product-link">https://www.bebes-lutins.fr/produit/identifiant</p>
                        <p id="product-description"><?php echo $ceo_description; ?></p>
                    </div>
                </div>
                <div class="ceo-title-description-url-container">
                    <div class="ceo-title">
                        <div class="label-with-extra horizontal between">
                            <label for="ceo-title">Titre de la page</label>
                            <div class="horizontal">
                                <p id="counter-ceo-title"><?php echo strlen($ceo_name); ?></p>
                                <p>&nbsp;sur 70 caractères utilisés</p>
                            </div>
                        </div>
                        <input id="ceo-title" type="text"  name="ceo_name" maxlength="70" value="<?php echo $ceo_name; ?>">
                        <div class="label-with-extra horizontal between">
                            <label for="ceo-description">Méta-description</label>
                            <div class="horizontal">
                                <p id="counter-ceo-description"><?php echo strlen($ceo_description); ?></p>
                                <p>&nbsp;sur 320 caractères utilisés</p>
                            </div>
                        </div>
                        <textarea id="ceo-description" name="ceo_description"><?php echo $ceo_description; ?></textarea>
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
                        <input id="price" name="price" type="number" step="0.01" min="0" max="10000" value="<?php echo $price; ?>">
                    </div>
                </div>
            </div>
            <div class="product-stock-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Stocks</p>
                </div>
                <div class="stock vertical">
                    <label for="stock">Quantité</label>
                    <input id="stock" name="stock" type="number" step="1" min="0" max="10000" value="<?php echo $stock; ?>">
                </div>
            </div>
            <div class="product-organisation-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Organisation</p>
                </div>
                <div id="categories-add-container" class="category vertical">
                    <div class="horizontal between">
                        <label for="category-select">Catégories</label>
                        <i class="fas fa-plus vertical centered" onclick="addSelectInput()"></i>
                    </div>
                    <?php if($product_categories == null){
                        ?>
                        <div id="category-selector" class="category-selector horizontal">
                            <select id="category-select" name="category[]">
                                <?php foreach ($categories as $category) { if($category->getParent() != "none") {?>
                                    <optgroup label="<?php if($category->getParent() == 'none') echo '------'; else  echo $category->getParent();?>">
                                        <option value="<?php echo $category->getName(); ?>" ><?php echo $category->getName();?></option>
                                    </optgroup>
                                <?php } } ?>
                            </select>
                            <i class="fas fa-minus remove-parent vertical centered" style="margin-left: 10px;"></i>
                        </div>
                        <?php
                    } ?>
                    <?php foreach ($product_categories as $product_category) { ?>
                        <div id="category-selector" class="category-selector horizontal">
                            <select id="category-select" name="category[]">
                                <?php foreach ($categories as $category) { if($category->getParent() != "none") {?>
                                    <optgroup label="<?php if($category->getParent() == 'none') echo '------'; else  echo $category->getParent();?>">
                                        <option value="<?php echo $category->getName(); ?>" <?php if($category->getName() == $product_category->getName()){echo 'selected';}?>><?php echo $category->getName();?></option>
                                    </optgroup>
                                <?php } } ?>
                            </select>
                            <i class="fas fa-minus remove-parent vertical centered" style="margin-left: 10px;"></i>
                        </div>
                    <?php } ?>
                </div>
                <div class="tags vertical">
                    <label for="tags">Tags</label>
                    <input id="tags" type="text" name="tags" placeholder="Couches, bébés..." value="<?php echo $tags; ?>">
                </div>
                <div class="hide vertical">
                    <label class="container vertical centered">Cacher le produit
                        <input type="checkbox" name="hide" <?php if($hide) echo 'checked'; ?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </div>
    </form>
</main>
</body>
<script src="https://www.bebes-lutins.fr/view/assets/js/dropzone.js"></script>
<script>
    Dropzone.autoDiscover = false;

    var mainDropzone = new Dropzone("div#main-dropzone",
        {
            url: "https://www.bebes-lutins.fr/view/html/tests/test-upload.php",
            addRemoveLinks: true,
            maxFiles: 1,
            dictDefaultMessage: "Choisissez l'image principale du produit.",
            accept: function(file, done) {
                namefile = file.name
                namefile = namefile.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                $('#image-name').attr('value', namefile);

                done();
            },
            init: function() {
                this.on("addedfile", function() {
                    $('#image-name').attr('value', this.files[0].name);
                    if (this.files[1]!=null){
                        this.removeFile(this.files[0]);
                    }
                });

                this.on('removedfile', function (file) {
                    alert(namefile);
                    $.ajax({
                        type: "POST",
                        url: "../../view/html/tests/test-upload.php",
                        data: {
                            target_file: namefile,
                            delete_file: 1
                        },
                        dataType: 'json',
                        success: function(d){
                            $('#image-name').attr('value', '');
                            alert(d.info); //will alert ok
                        }
                    });
                });
            }
        });

    var thumbnailsDropzone = new Dropzone("div#thumbnails-dropzone",
        {
            url: "https://www.bebes-lutins.fr/view/html/tests/test-upload-thumbnails.php",
            addRemoveLinks: true,
            maxFiles: 4,
            dictDefaultMessage: "Déposez ici les vignettes du produit.",
            accept: function(file, done) {
                namefile = file.name;
                namefile = namefile.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                thumbnails_name = $('#thumbnails-name').val() + namefile + ";";
                $('#thumbnails-name').attr('value', thumbnails_name);

                done();
            },
            init: function() {
                this.on("addedfile", function() {
                    if (this.files[4]!=null){
                        this.removeFile(this.files[0]);
                    }
                });

                this.on('removedfile', function (file) {
                    namefile = file.name;
                    namefile = namefile.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    alert(namefile);
                    $.ajax({
                        type: "POST",
                        url: "../../view/html/tests/test-upload-thumbnails.php",
                        data: {
                            target_file: namefile,
                            delete_file: 1
                        },
                        dataType: 'json',
                        success: function(d){
                            thumbnails_name = $('#thumbnails-name').val();
                            alert("Input avant suppression : " + thumbnails_name);
                            thumbnails_name = thumbnails_name.replace(d.filename + ";", '');
                            alert("Input après suppression : " + thumbnails_name);
                            $('#thumbnails-name').attr('value', thumbnails_name);
                            alert(d.info + " - " + d.filename); //will alert ok
                        }
                    });
                });
            }
        });
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
        var myNicEditor = new nicEditor({
            fullPanel : true,
            iconsPath: 'https://www.bebes-lutins.fr/view/assets/js/nicEditorIcons.gif',
            nicURI:"https://www.bebes-lutins.fr/image.php",
            });
        myNicEditor.setPanel('myNicPanel');
        myNicEditor.addInstance('big-description-instance');
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

    function goToImportPage(){
        document.location.href = "https://www.bebes-lutins.fr/dashboard4/produits/importer";
    }
</script>
</html>