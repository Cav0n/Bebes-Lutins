<?php

$product_id = $_REQUEST['product_id'];
$product = ProductGateway::SearchProductByID2($product_id);
$categories = CategoryGateway::GetCategories();
$thumbnails = $product->getImage()->getThumbnails();

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
    <div class='product-page-link-container horizontal'>
        <a href='https://www.bebes-lutins.fr/produit/<?php echo $product->getId(); ?>' class='horizontal'> 
            <?php echo file_get_contents("view/assets/images/utils/icons/eye.svg"); ?>
            <p>Voir la page du produit</p>
        </a>
    </div>
    <div id="error-product" class="vertical <?php if($error == null) echo 'hidden';?>">
        <p>Il y a des erreurs avec la mise à jour du produit :</p>
        <p class="message"><?php echo $error;?>Une petite erreur gentille.</p>
    </div>
    <form id="edition-wrapper" class="horizontal" method="post" action="https://www.bebes-lutins.fr/dashboard4/produits/sauvegarder/">
        <input type="hidden" name="product_id" value="<?php echo $product->getId();?>">
        <input type="hidden" name="id_copy" value="<?php echo $product->getName();?>">
        <input id="image-name" type="hidden" name="image_name" value="<?php echo $product->getImage()->getName(); ?>">
        <input id="thumbnails-name" type="hidden" name="thumbnails_name" value="">
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
                        <textarea id="ceo-description" name="ceo_description"><?php echo $product->getCeoDescription(); ?></textarea>
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

            <button style='margin:0;' class="save-button" class="vertical centered" type='submit'>
                Enregistrer le produit
            </button>
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
                var mockFile = { name: "<?php echo $product->getImage()->getName() ?>", type: 'image/jpeg' };
                this.addFile.call(this, mockFile);
                this.options.thumbnail.call(this, mockFile, "https://www.bebes-lutins.fr/view/assets/images/products/" + "<?php echo $product->getImage()->getName() ?>");
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
                        url: "https://www.bebes-lutins.fr/view/html/tests/test-upload-thumbnails.php",
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

                <?php foreach ($product->getImage()->getThumbnails() as $thumbnail) { ?>
                    var mockFile = { name: "<?php echo $thumbnail->getName(); ?>", type: 'image/jpeg' };
                    this.addFile.call(this, mockFile);
                    this.options.thumbnail.call(this, mockFile, "https://www.bebes-lutins.fr/view/assets/images/thumbnails/" + "<?php echo $thumbnail->getName(); ?>");
                <?php } ?>
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