<?php

$categories = CategoryGateway::GetCategories();
$products = ProductGateway::GetProducts();
$highlighted_products = ProductGateway::GetHighlightedProducts();
usort($categories, function(Category $a, Category $b)
{
    if($a->getRank() - $b->getRank() == $b->getRank() - $a->getRank()) return strcmp( $b->getName(), $a->getName());
    return $a->getRank() - $b->getRank();
});
?>

<!DOCTYPE html>
<html style="background: #3b3f4d;" lang="fr">
<head>
    <title>ADMINISTRATION - BEBES LUTINS</title>
    <meta name="description" content="Bienvenue dans votre tout nouveau tableau de bord."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="administration">
<?php AdminModel::load_administration_header(); ?>

<main>
    <div id="options">

    </div>
    <div id="disp-products" class="vertical between windows-container selected">
        <?php if(isset($_POST['error-message-products'])) echo $_POST['error-message-products'];?>
        <?php if(isset($_POST["ErreurUpload"])) echo $_POST["ErreurUpload"];?>
        <?php if(isset($_SESSION['test'])) echo $_SESSION['test'];?>
        <?php if(isset($_SESSION['name'])) echo $_SESSION['name'];?>

        <div class="vertical window" id="product-window">
            <form id="clone-popup" class="vertical hidden" method="post">
                <h2 style="font-size: 1.2em;" id="product-name-popup"></h2>
                <input id="product-id-popup-clone" type="hidden" name="product_id" value="">
                <input id="product-id-copy-popup-clone" type="hidden" name="product_id_copy" value="">
                <label for="clone-category-select">Choix de la catégorie : </label>
                <select id="clone-category-select" name="clone_category">
                    <?php
                    foreach($categories as $category){
                        $category = (new CategoryContainer($category))->getCategory();
                        ?>
                        <option value="<?php echo $category->getName();?>"><?php echo $category->toString();?></option>
                        <?php
                    }
                    ?>
                </select>
                <button class='button' formaction="https://www.bebes-lutins.fr/dashboard/clone" type="submit">Cloner le produit</button>
                <button class='button' formaction="https://www.bebes-lutins.fr/dashboard/copier" type="submit">Copier le produit</button>
                <button class='button' formaction="https://www.bebes-lutins.fr/dashboard/deplacer" type="submit">Deplacer le produit</button>
                <p class="button" onclick="close_popup_clone_product()">Annuler</p>
            </form>
            <div class="category-container">
                <form action="https://www.bebes-lutins.fr/dashboard/ajout-categorie-page" method="post" class="category horizontal centered">
                    <input type="hidden" name="category_parent" value="none">
                    <button class="add-category transition-fast">Ajouter une catégorie</button>
                </form>
            </div>
            <?php
            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();
                /*if($category->getParent() != "none") {
                    $category_parent = $category->getParent();
                    $category_parent_string =  $category_parent . " - ";
                }else {
                    $category_parent = null;
                    $category_parent_string = null;
                }*/

                if($category->getParent() == "none"){
                    $category_name_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($category->getName())));
                    ?>
                    <div id="category-<?php echo str_replace(" ","-",$category->getName());?>" class="category-container <?php if($category_parent == null) echo "border-bottom";?>">
                        <div id="category-header-<?php echo str_replace(" ","-",$category->getName());?>" class="category horizontal" onclick="display_details_category('<?php echo str_replace(" ","-",$category->getName());?>')">
                            <img src="https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $category->getImage() . "?" . filemtime("view/assets/images/categories/" . $category->getImage()->getName());?>">
                            <div class="vertical between texts">
                                <p class="name"><?php echo $category->getRank() . " " . $category->getName();?></p>
                                <p class="category-description"><?php echo $category->getDescription();?></p>
                            </div>
                            <form class="vertical between buttons" method="post" action="https://www.bebes-lutins.fr/dashboard/modifier-categorie-page">
                                <input type="hidden" name="category_name" value="<?php echo $category->getName();?>">
                                <button type="submit" class="modify transition-fast" formaction="https://www.bebes-lutins.fr/dashboard/modifier-categorie-page">Modifier</button>
                                <a onclick="avertissement_categorie('<?php echo $category_name_url;?>')" class="delete transition-fast">Supprimer</a>
                            </form>
                        </div>
                        <div id="category-details-<?php echo str_replace(" ","-",$category->getName())?>" class="category-details-container vertical hidden">
                            <div class="category-management-buttons horizontal centered">
                                <div class="category-container">
                                    <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajout-categorie-page" class="category horizontal centered">
                                        <input type="hidden" name="category_parent" value="<?php echo $category->getName();?>">
                                        <button type='submit' class="add-category transition-fast">Ajouter une sous-catégorie</button>
                                    </form>
                                </div>
                                <div class="category-container">
                                    <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajouter-produit-page" class="category horizontal centered">
                                        <input type="hidden" name="category_parent" value="<?php echo$category->getName();?>">
                                        <button type='submit' class="add-product transition-fast">Ajouter un produit</button>
                                    </form>
                                </div>
                            </div>


                            <?php
                            foreach ($categories as $sub_category) {
                                $sub_category = (new CategoryContainer($sub_category))->getCategory();
                                if ($sub_category->getParent() == $category->getName()) {
                                    $sub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($sub_category->getName())));

                                    ?>
                                    <div id="category-<?php echo str_replace(" ","-",$sub_category->getName());?>" class="category-container">
                                        <div id="category-header-<?php echo str_replace(" ","-",$sub_category->getName());?>" class="category horizontal" onclick="display_details_category('<?php echo str_replace(" ","-",$sub_category->getName());?>')">
                                            <img src="https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $sub_category->getImage() . "?" . filemtime("view/assets/images/categories/" . $sub_category->getImage()->getName());?>">
                                            <div class="vertical between texts">
                                                <p class="name"><?php echo $sub_category->getRank() . " " . $sub_category->getName();?></p>
                                                <p class="category-description"><?php echo $sub_category->getDescription();?></p>
                                            </div>
                                            <form class="vertical between buttons" method="post" action="#">
                                                <input type="hidden" name="category_name" value="<?php echo $sub_category->getName();?>">
                                                <button type="submit" class="modify transition-fast" formaction="https://www.bebes-lutins.fr/dashboard/modifier-categorie-page">Modifier</button>
                                                <a onclick="avertissement_categorie('<?php echo $sub_category_url;?>')" class="delete transition-fast">Supprimer</a>
                                            </form>
                                        </div>
                                        <div id="category-details-<?php echo str_replace(" ","-",$sub_category->getName())?>" class="category-details-container vertical hidden">
                                            <div class="category-management-buttons horizontal centered">
                                                <div class="category-container">
                                                    <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajout-categorie-page" class="category horizontal centered">
                                                        <input type="hidden" name="category_parent" value="<?php echo $sub_category->getName();?>">
                                                        <button type='submit' class="add-category transition-fast">Ajouter une sous-catégorie</button>
                                                    </form>
                                                </div>
                                                <div class="category-container">
                                                    <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajouter-produit-page" class="category horizontal centered">
                                                        <input type="hidden" name="category_parent" value="<?php echo $sub_category->getName();?>">
                                                        <button type='submit' class="add-product transition-fast">Ajouter un produit</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <?php
                                            foreach ($categories as $subsub_category) {
                                                $subsub_category = (new CategoryContainer($subsub_category))->getCategory();
                                                if ($subsub_category->getParent() == $sub_category->getName()) {
                                                    $subsub_category_url = str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($subsub_category->getName())));

                                                    ?>
                                                    <div id="category-<?php echo str_replace(" ","-",$subsub_category->getName());?>" class="category-container">
                                                        <div id="category-header-<?php echo str_replace(" ","-",$subsub_category->getName());?>" class="category horizontal" onclick="display_details_category('<?php echo str_replace(" ","-",$subsub_category->getName());?>')">
                                                            <img src="https://www.bebes-lutins.fr/view/assets/images/categories/<?php echo $subsub_category->getImage() . "?" . filemtime("view/assets/images/categories/" . $sub_category->getImage()->getName());?>">
                                                            <div class="vertical between texts">
                                                                <p class="name"><?php echo $subsub_category->getRank() . " " . $subsub_category->getName();?></p>
                                                                <p class="category-description"><?php echo $subsub_category->getDescription();?></p>
                                                            </div>
                                                            <form class="vertical between buttons" method="post" action="#">
                                                                <input type="hidden" name="category_name" value="<?php echo $subsub_category->getName();?>">
                                                                <button type="submit" class="modify transition-fast" formaction="https://www.bebes-lutins.fr/dashboard/modifier-categorie-page">Modifier</button>
                                                                <a onclick="avertissement_categorie('<?php echo $subsub_category_url;?>')" class="delete transition-fast">Supprimer</a>
                                                            </form>
                                                        </div>
                                                        <div id="category-details-<?php echo str_replace(" ","-",$subsub_category->getName())?>" class="category-details-container vertical hidden">
                                                            <div class="category-management-buttons horizontal centered">
                                                                <div class="category-container">
                                                                    <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajout-categorie-page" class="category horizontal centered">
                                                                        <input type="hidden" name="category_parent" value="<?php echo $subsub_category->getName();?>">
                                                                        <button type='submit' class="add-category transition-fast">Ajouter une sous-catégorie</button>
                                                                    </form>
                                                                </div>
                                                                <div class="category-container">
                                                                    <form method="post" action="https://www.bebes-lutins.fr/dashboard/ajouter-produit-page" class="category horizontal centered">
                                                                        <input type="hidden" name="category_parent" value="<?php echo $subsub_category->getName();?>">
                                                                        <button type='submit' class="add-product transition-fast">Ajouter un produit</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            foreach ($products as $product){
                                                                $product = (new ProductContainer($product))->getProduct();
                                                                if($product->getCategory()->getName() == $subsub_category->getName()){?>
                                                                    <div class="product-container horizontal">
                                                                        <div class="product horizontal">
                                                                            <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage(). "?=" . filemtime("view/assets/images/categories/" . $product->getImage()->getName());?>">
                                                                            <div class="text vertical between">
                                                                                <p class="product_name"><?php echo $product->getName();?></p>
                                                                                <div class="numbers">
                                                                                    <p><?php echo "Stock : ". $product->getStock();?></p>
                                                                                    <p><?php echo "Prix : ".str_replace("Eu", "€", money_format('%.2n', $product->getPrice()));?></p>
                                                                                    <p><?php echo "Référence : " . $product->getReference();?></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <form action="#" method="post" class="buttons vertical">
                                                                            <input type="hidden" name="id_product" value="<?php echo $product->getId();?>">
                                                                            <i class="far fa-star empty-star" onclick="highlight_product('<?php echo $product->getId();?>')"></i>
                                                                            <button type="submit" name="action" value="edit_product_page" formaction="https://www.bebes-lutins.fr/dashboard/modifier-produit-page" class="modify transition-fast"><i class="fas fa-edit"></i></button>
                                                                            <i class="fas fa-clone" onclick="open_popup_clone_product('<?php echo $product->getId();?>','<?php echo $product->getIdCopy();?>', '<?php echo $product->getName();?>')"></i>
                                                                            <button type="submit" name="action" value="delete_product" formaction="https://www.bebes-lutins.fr/dashboard/supprimer-produit" class="delete transition-fast"><i class="fas fa-trash-alt"></i></button>
                                                                        </form>
                                                                    </div>
                                                                <?php }
                                                            }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } ?>
                                            <?php
                                            foreach ($products as $product){
                                                $product = (new ProductContainer($product))->getProduct();
                                                if($product->getCategory()->getName() == $sub_category->getName()){?>
                                                    <div class="product-container horizontal">
                                                        <div class="product horizontal">
                                                            <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage(). "?=" . filemtime("view/assets/images/categories/" . $product->getImage()->getName());?>">
                                                            <div class="text vertical between">
                                                                <p class="product_name"><?php echo $product->getName();?></p>
                                                                <div class="numbers">
                                                                    <p><?php echo "Stock : ". $product->getStock();?></p>
                                                                    <p><?php echo "Prix : ".str_replace("Eu", "€", money_format('%.2n', $product->getPrice()));?></p>
                                                                    <p><?php echo "Référence : " . $product->getReference();?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form action="#" method="post" class="buttons vertical">
                                                            <input type="hidden" name="id_product" value="<?php echo $product->getId();?>">
                                                            <i class="far fa-star empty-star" onclick="highlight_product('<?php echo $product->getId();?>')"></i>
                                                            <button type="submit" name="action" value="edit_product_page" formaction="https://www.bebes-lutins.fr/dashboard/modifier-produit-page" class="modify transition-fast"><i class="fas fa-edit"></i></button>
                                                            <i class="fas fa-clone" onclick="open_popup_clone_product('<?php echo $product->getId();?>','<?php echo $product->getIdCopy();?>', '<?php echo $product->getName();?>')"></i>
                                                            <button type="submit" name="action" value="delete_product" formaction="https://www.bebes-lutins.fr/dashboard/supprimer-produit" class="delete transition-fast"><i class="fas fa-trash-alt"></i></button>
                                                        </form>
                                                    </div>
                                                <?php }
                                            }?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } ?>
                            <?php
                            foreach ($products as $product){
                                $product = (new ProductContainer($product))->getProduct();
                                if($product->getCategory()->getName() == $category->getName()){?>
                                    <div class="product-container horizontal">
                                        <div class="product horizontal">
                                            <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage(). "?=" . filemtime("view/assets/images/categories/" . $category->getImage()->getName());?>">
                                            <div class="text vertical between">
                                                <p class="product_name"><?php echo $product->getName();?></p>
                                                <div class="numbers">
                                                    <p><?php echo "Stock : ". $product->getStock();?></p>
                                                    <p><?php echo "Prix : ".UtilsModel::FloatToPrice($product->getPrice());?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="#" method="post" class="buttons vertical">
                                            <input type="hidden" name="id_product" value="<?php echo $product->getId();?>">
                                            <i class="far fa-star empty-star" onclick="highlight_product('<?php echo $product->getId()?>')"></i>
                                            <button type="submit" name="action" value="edit_product_page" formaction="https://www.bebes-lutins.fr/dashboard/modifier-produit-page" class="modify transition-fast"><i class="fas fa-edit"></i></button>
                                            <i class="fas fa-clone" onclick="open_popup_clone_product('<?php echo $product->getId();?>','<?php echo $product->getIdCopy();?>', '<?php echo $product->getName();?>')"></i>
                                            <button type="submit" name="action" value="delete_product" formaction="https://www.bebes-lutins.fr/dashboard/supprimer-produit" class="delete transition-fast"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                <?php }}?>
                        </div>
                    </div>
                <?php }} ?>
        </div>
        <div class="vertical window" id="highlighted-products-window">
            <div class="window-header centered">
                <h3>Produits à mettre en avant</h3>
            </div>
            <div class="highlighted-products-container centered horizontal">
                <?php
                foreach ($highlighted_products as $highlighted_product){
                    $hp = (new ProductContainer($highlighted_product))->getProduct();

                    $hp_id = $hp->getId();
                    $hp_image = $hp->getImage();
                    $hp_name = $hp->getName();?>

                    <div id="highlighted-product" class="vertical">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $hp_image. "?=" . filemtime("view/assets/images/categories/" . $hp_image->getName());?>">
                        <p><?php echo $hp_name;?></p>
                        <button class="delete_button" onclick="remove_highlight_product('<?php echo $hp_id;?>')">Retirer</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</main>
</body>
<script>
    function tab_selection_changed_users(option){
        document.location.href="https://www.bebes-lutins.fr/dashboard/tab/users/"+option;
    }

    function display_details_category(category_name){
        console.log("#category-details-"+category_name);
        $("#category-details-"+category_name).removeClass("hidden").addClass("display");
        document.getElementById("category-header-"+category_name).setAttribute("onClick", "hide_details_category('"+category_name+"')");
    }

    function hide_details_category(category_name){
        $("#category-details-"+category_name).removeClass("display").addClass("hidden");
        document.getElementById("category-header-"+category_name).setAttribute("onClick", "display_details_category('"+category_name+"')");
    }

    function open_popup_clone_product(product_id, product_id_copy, name){
        $("#clone-popup").removeClass('hidden').addClass('display');
        document.getElementById("product-id-popup-clone").value = product_id;
        document.getElementById("product-id-copy-popup-clone").value = product_id_copy;
        document.getElementById("product-name-popup").innerHTML = name;
    }

    function close_popup_clone_product(){
        $("#clone-popup").removeClass('display').addClass('hidden');
    }

    function avertissement_categorie(nom){
        if(confirm("Vous allez supprimer une catégorie.")){
            window.location.replace("https://www.bebes-lutins.fr/dashboard/supprimer-categ-"+nom);
        }
        else{
            confirm("Vous n'aller rien supprimer");
        }
    }

    function avertissement_produit(id, categorie){
        if(confirm("Vous allez supprimer un produit.")){
            window.location.replace("https://www.bebes-lutins.fr/?action=SupprimerProduit&id="+id+"&categorie="+categorie);
        }
        else{
            confirm("Vous n'aller rien supprimer");
        }
    }

    function highlight_product(product_id) {
        //document.location.href="https://www.bebes-lutins.fr/?action=add_highlight_product&product_id=" + product_id;

        $.ajax({
            url: 'https://www.bebes-lutins.fr',
            type: 'POST',
            data: {product_id:product_id, action:"add_highlight_product"},
            success: function() {
                document.location.href="https://www.bebes-lutins.fr/dashboard/tab/products";
            }
        });
    }

    function remove_highlight_product(product_id){
        $.ajax({
            url: 'https://www.bebes-lutins.fr',
            type: 'POST',
            data: {product_id:product_id, action:"remove_highlight_product"},
            success: function() {
                document.location.href="https://www.bebes-lutins.fr/dashboard/tab/products";
            }
        });
    }
</script>
</html>
