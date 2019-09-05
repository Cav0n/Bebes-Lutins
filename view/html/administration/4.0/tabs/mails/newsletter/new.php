<?php

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
        <a href="https://www.bebes-lutins.fr/dashboard4/produits/"><i class="fas fa-angle-left"></i> Newsletters</a>
    </div>
    <div class="page-title-container horizontal between">
        <h2>Créer une newsletter</h2>
    </div>
    <?php if($success != null) { ?>
    <div id='success' class="vertical">
        <p>La newsletter a bien été créée.</p>
    </div>
    <?php } ?>
    <?php if($error_message != null){ ?>
    <div id="error-message-container">
        <p id="error-title">Une erreur s'est produite</p>
        <p id="error-message"><?php echo $error_message; ?></p>
    </div>
    <?php } ?>
    <form id="edition-wrapper" class="horizontal" method="post" action="https://www.bebes-lutins.fr/newsletter/envoyer" enctype="multipart/form-data">
        <input id="image-name" type="hidden" name="image_name">
        <div class="column-big vertical">
            <div class="product-title-description-container edition-window">
                <div class="title vertical">
                    <label for="title">Titre</label>
                    <input id="title" type="text" name="title" placeholder="Bonjour tout le monde !">
                </div>
                <div class="text vertical">
                    <label for="text-instance">Texte</label>
                    <div id="myNicPanel"></div>
                    <textarea class="element" id="text-instance" name="text" style="width:100%;"></textarea>
                </div>
            </div>
            <div class="newsletter-image-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Image de la newsletter</p>
                </div>
                <div id="main-dropzone" class="dropzone" style="border: 1px dashed;border-radius: 3px;">

                </div>
            </div>
            <div class="preview-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Prévisualisation</p>
                </div>
                <div class="preview">
                    <p>En cours de création</p>
                </div>
            </div>
        </div>
        <div class="column-tiny vertical">
            <div class="newsletter-button-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Action</p>
                </div>
                <div class='vertical'>
                    <label class="container vertical centered">Ajout d'un bouton
                        <input type="checkbox" class='button-checkbox' name="has-button">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="button-title vertical">
                    <label for="button-title">Titre du bouton</label>
                    <div class="label-container horizontal">
                        <input id="button-title" name="button-title" type="text">
                    </div>
                </div>
                <div class="button-link vertical">
                    <label for="button-link">Lien</label>
                    <div class="label-container horizontal">
                        <p class="link-header vertical" style='margin: auto 0;padding: 0 5px;color: grey;'>https://</p>
                        <input id="button-link" name="button-link" type="text">
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
<script src="https://www.bebes-lutins.fr/view/assets/js/dropzone.js"></script>
<script>
    Dropzone.autoDiscover = false;


    var mainDropzone = new Dropzone("div#main-dropzone",
        {
            url: "https://www.bebes-lutins.fr/view/html/administration/4.0/tabs/mails/newsletter/upload-image-newsletter.php",
            addRemoveLinks: true,
            maxFiles: 1,
            dictDefaultMessage: "Vous pouvez cliquer ici pour ajouter une image.",
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
                        url: "https://www.bebes-lutins.fr/view/html/administration/4.0/tabs/mails/newsletter/upload-image-newsletter.php",
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
    $(".button-title").hide();
    $(".button-link").hide();
    $(".button-checkbox").change(function() {
        if(this.checked) {
            $(".button-title").show();
            $(".button-link").show();
        } else {
            $(".button-title").hide();
            $(".button-link").hide();
        }
    });

    bkLib.onDomLoaded(function() {
        var myNicEditor = new nicEditor({fullPanel : true, iconsPath: 'https://www.bebes-lutins.fr/view/assets/js/nicEditorIcons.gif'});
        myNicEditor.panelInstance('text-instance');
    });

    function validate()
    {
        var nicInstance = nicEditors.findEditor('text-instance');
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