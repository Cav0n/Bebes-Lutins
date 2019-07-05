<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:56
 */

$category_parent = $_POST['category_parent'];

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
        <button id="orders" class="header-button <?php if($selection_tab_header != 'orders') echo 'non-';?>selected" onclick="tab_selection_changed_header('orders')">
            <div class="horizontal tab">
                <i class="fas fa-boxes fa-2x"></i>
                <p>Commandes</p>
            </div>
        </button>
        <button id="products" class="header-button <?php if($selection_tab_header != 'products') echo 'non-';?>selected" onclick="tab_selection_changed_header('products')">
            <div class="horizontal tab">
                <i class="fas fa-sitemap fa-2x"></i>
                <p>Produits</p>
            </div>
        </button>
        <button id="users" class="header-button <?php if($selection_tab_header != 'users') echo 'non-';?>selected" onclick="tab_selection_changed_header('users')">
            <div class="horizontal tab">
                <i class="fas fa-users fa-2x"></i>
                <p>Utilisateurs</p>
            </div>
        </button>
        <button id="various" class="header-button <?php if($selection_tab_header != 'various') echo 'non-';?>selected" onclick="tab_selection_changed_header('various')">
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
        <h1>Création d'un produit</h1>
        <p style="text-align: center;">(<?php echo $category_parent; ?>)</p>
        <form class="category-add-form" method="post" action="https://www.bebes-lutins.fr/dashboard/ajouter-produit" enctype="multipart/form-data">
            <input type="hidden" name="category" value="<?php echo $category_parent;?>">
            <div id="categorie-image-texte" class="horizontal centered">
                <input class="ajout-categorie-field" type="hidden" name="MAX_FILE_SIZE" value="10485760">
                <input class="ajout-categorie-field" type="file" name="image" id="file-input" onchange="img_categorie(this);" style="display: none;" required>
                <label for="file-input" id="categort-image-container">
                    <img  width="300px" height="300px" id="category-image" src="https://placehold.it/300" alt="Image de la categorie" title="Image de la categorie">
                </label>
                <div class="vertical category-text centered">
                    <label class="text-label" for="product-name">Nom :</label>
                    <input class="ajout-categorie-field ajout-categorie-text" type="text" name="name" id="product-name" placeholder="Nom" required>
                    <label class="text-label" for="product-price">Prix :</label>
                    <input class="ajout-categorie-field ajout-categorie-text" type="number" min='0' step="0.01" name="price" id="product-price" placeholder="Prix" required>
                    <label class="text-label" for="product-stock">Stock :</label>
                    <input class="ajout-categorie-field ajout-categorie-text" type="number" min="0" step="1" name="stock" id="product-stock" placeholder="Stock" required>
                </div>
            </div>
            <div id="product-descriptions" class="vertical">
                <label class="text-label" for="category-description"> Description courte :</label>
                <textarea class="ajout-categorie-field ajout-categorie-text" name="description_small" id="category-description" placeholder="Une courte description qui décrit rapidement le produit." required></textarea>
                <label class="text-label" for="big-description-instance"> Description longue :</label>
                <textarea class="element" id="big-description-instance" name="description_big" ></textarea>
            </div>
            <div id="category-add-button" class="horizontal centered">
                <button type="submit">Ajouter le produit</button>
            </div>
        </form>
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