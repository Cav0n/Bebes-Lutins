<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:56
 */

$category_name = $_POST['category_name'];
$category = CategoryGateway::GetCategory($category_name);
$categories_list = CategoryGateway::GetCategories();
$category_nb = 0;
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
        <h1>Modification d'une catégorie</h1>
        <p style="text-align: center;">(<?php echo $category->getName(); ?>)</p>
        <form class="category-add-form" method="post" action="https://www.bebes-lutins.fr/dashboard/modifier-categorie" enctype="multipart/form-data">
            <input type="hidden" name="old_name" value="<?php echo $category->getName();?>">
            <input type="hidden" name="old_image_name" value="<?php echo $category->getImage();?>">
            <div id="categorie-image-texte" class="horizontal centered">
                <input class="ajout-categorie-field" type="hidden" name="MAX_FILE_SIZE" value="10485760">
                <input class="ajout-categorie-field" type="file" name="image" id="file-input" onchange="img_categorie(this);" style="display: none;">
                <label for="file-input" id="categort-image-container">
                    <img  width="300px" height="300px" id="category-image" src="https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $category->getImage()?>" alt="Image de la categorie" title="Image de la categorie">
                </label>
                <div class="vertical category-text">
                    <label class="text-label" for="category-name">Nom :</label>
                    <input class="ajout-categorie-field ajout-categorie-text" type="text" name="name" id="category-name" placeholder="Nom" value="<?php echo $category->getName()?>">
                    <label class="rank-label" for="rank-select">Rang :</label>
                    <select id="rank-select" name="rank">
                        <?php foreach ($categories_list as $c){
                            $c = (new CategoryContainer($c))->getCategory();
                            $category_nb ++;
                            ?>
                            <option value="<?php echo $c->getRank();?>"><?php echo $c->getRank() . " - " . $c->getName();?></option>
                            <?php
                        }?>
                    </select>
                    <label class="text-label" for="category-description"> Description</label>
                    <textarea class="ajout-categorie-field ajout-categorie-text" name="description" id="category-description" placeholder="Description"><?php echo $category->getDescription()?></textarea>
                </div>
            </div>
            <div id="category-add-button" class="horizontal centered">
                <button type="submit">Modifier la catégorie</button>
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
</script>
</html>