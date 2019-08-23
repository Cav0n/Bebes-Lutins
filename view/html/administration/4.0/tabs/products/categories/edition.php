<?php

$categories_list = CategoryGateway::GetCategories();

$new_category = true;
$category_name = str_replace("_", "’", str_replace( "="," ", $_REQUEST['category']));
if($category_name != null){
    $new_category = false;
    $category = CategoryGateway::GetCategory($category_name);

    $name = $category->getName();
    $image = $category->getImage();
    $description = $category->getDescription();
    $parent = $category->getParent();
    $rank = $category->getRank();
}

if(isset($_SESSION['error_message']) && $_SESSION['error_message'] != null){
    $new_category = false;
    $error_message = $_SESSION['error_message'];

    $name = $_SESSION['name'];
    $image = $_SESSION['image'];
    $description = $_SESSION['description'];
    $parent = $_SESSION['parent'];
    $rank = $_SESSION['rank'];
    
    unset($_SESSION['error_message']);
} else $error_message = null;

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
        <a href="https://www.bebes-lutins.fr/dashboard4/produits/categories"><i class="fas fa-angle-left"></i> Produits</a>
    </div>
    <div class="page-title-container horizontal between">
        <h2>Ajouter une catégorie</h2>
    </div>
    <div id="extra-buttons" class="horizontal">
        <button onclick="goToImportPage()">Importer une catégorie</button>
    </div>
    <?php if($error_message != null){ ?>
    <div id="error-message-container">
        <p id="error-title">Une erreur s'est produite</p>
        <p id="error-message"><?php echo $error_message; ?></p>
    </div>
    <?php } ?>
    <form id="edition-wrapper" class="horizontal" method="post" action="https://www.bebes-lutins.fr/dashboard4/produits/categorie/sauvegarder/" enctype="multipart/form-data">
        <input id="image-name" type="hidden" name="image" value="<?php echo $image;?>">
        <input id='new_category' type="hidden" name='new_category' value="<?php echo $new_category?>">
        <div class="column-big vertical">
            <div class="category-title-description-container edition-window">
                <div class="custom-id vertical">
                    <label for="reference">Rang</label>
                    <div class="label-container horizontal">
                        <p class="euro-sign vertical">#</p>
                        <input id="rank" type="number" min='0' step="1" name="rank" placeholder="000" value="<?php echo $rank; ?>">
                    </div>
                </div>
                <div class="title vertical">
                    <label for="title">Nom</label>
                    <input id="title" type="text" name="name" placeholder="Une petite couche mignonne" value="<?php echo $name; ?>">
                </div>
                <div class="description vertical">
                    <label for="big-description-instance">Description</label>
                    <textarea class="element" id="big-description-instance" name="description" style="width:100%;"><?php echo $description; ?></textarea>
                </div>
            </div>
            <div class="category-image-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Image de la catégorie</p>
                </div>
                <div id="main-dropzone" class="dropzone" style="border: 1px dashed;border-radius: 3px;">

                </div>
            </div>
        </div>
        <div class="column-tiny vertical">
            <div class="category-organisation-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Organisation</p>
                </div>
                <div id="categories-add-container" class="category vertical">
                    <div class="horizontal between">
                        <label for="category-select">Catégorie parente</label>
                    </div>
                    <div id="category-selector" class="category-selector horizontal">
                        <select id="category-select" name="parent">
                            <option value="none">Aucune</option>
                            <?php foreach ($categories_list as $category) { if($category->getParent() != "none") {?>
                                <optgroup label="<?php if ($category_search->getParent() == "none") echo "-----"; else echo $category_search->getParent();?>">
                                    <option value="<?php echo $category->getName(); ?>" ><?php echo $category->getName();?></option>
                                </optgroup>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="tags vertical">
                    <label for="tags">Tags</label>
                    <input id="tags" type="text" name="tags" placeholder="Couches, bébés..." value="<?php echo $tags; ?>">
                </div>
                <div class="hide vertical">
                    <label class="container vertical centered">Cacher la catégorie
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
            dictDefaultMessage: "Choisissez l'image de la catégorie.",
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
</script>
<script>
    function goToImportPage(){
        document.location.href = "https://www.bebes-lutins.fr/dashboard4/produits/importer";
    }
</script>
</html>