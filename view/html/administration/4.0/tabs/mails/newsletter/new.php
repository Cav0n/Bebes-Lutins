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
    <link href='https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700' rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel="stylesheet">
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
    <div id="warning-message-container" class="horizontal" style="margin-top:1rem;padding: 1rem 5px;background: rgb(245, 243, 130);">
        <div style="width: 2rem;margin: 0 5px;"><?php echo file_get_contents("view/assets/images/utils/icons/warning.svg"); ?></div>
        <p style="margin: auto 0;">Cet outil vous permet de créer une newsletter qui sera envoyé à <b>TOUS</b> les clients abonnés aux newsletters.</p>
    </div>
    <form id="edition-wrapper" class="horizontal" method="post" action="https://www.bebes-lutins.fr/newsletter/envoyer" enctype="multipart/form-data">
        <input id="image-name" type="hidden" name="image_name">
        <div class="column-big vertical">
            <div class="product-title-description-container edition-window">
                <div class="title vertical">
                    <label for="title">Titre</label>
                    <input id="title" type="text" name="title" placeholder="Bonjour tout le monde !" onKeyUp="update_preview_title()">
                </div>
                <div class="text vertical">
                    <label for="text-instance">Texte</label>
                    <textarea id="text" name="text" style="width:100%;" onKeyUp="update_preview_text()"></textarea>
                </div>
            </div>
            <div class="newsletter-image-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Image de la newsletter</p>
                </div>
                <div id="main-dropzone" class="dropzone" style="border: 1px dashed;border-radius: 3px;">

                </div>
            </div>
            <div class="preview-container edition-window" style='-webkit-font-smoothing: antialiased;'>
                <div class="container-title horizontal between">
                    <p class="section-title">Prévisualisation</p>
                </div>
                <div class="preview vertical centered">
                    <div id='preview-header' class='centered'>
                        <a href="https://www.bebes-lutins.fr" style="border-style: none !important; border: 0 !important;" target="_blank">
                            <img id='logo' style="width: 150px;" src="https://www.bebes-lutins.fr/view/assets/images/utils/small-logo.png" alt="bebes-lutins.fr" />
                        </a>
                    </div>
                    <div id='preview-body' class='centered vertical' style='width: 590px;margin: 1.5rem auto 0 auto;'>
                        <div id='preview-image-container' class='centered'>
                            <img id='preview-image' src="" style="width: 590px;object-fit: cover;min-height: 300px;height:100%;" alt="" />
                        </div>
                        <div id='preview-texts-container' class='centered vertical'>
                            <div id='preview-title-container' class='centered' style='margin-top:2rem;'>
                                <h2 id='preview-title' style='color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;'>Bonsoir</h2>
                            </div>
                            <div id='border-container' style='width: 3rem;margin: 1rem auto;border-bottom: 2px solid rgba(232, 233, 234, 0.77);'></div>
                            <div id='preview-text-container' class='centered' style='color:grey;'>
                                <div id='preview-text' class='vertical' style="color: #888888; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;">Ceci est un jeune texte</div>
                            </div>
                        </div>
                        <div id='preview-button-container' class='centered' style='margin:2rem 0;'>
                            <a id='preview-button' href='https://www.bebes-lutins.fr' style="padding: 0.7rem 1.7rem;background: #5bd383;min-width: 7rem;max-width: 12rem;text-align:center;color: #ffffff; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 26px;text-decoration: none;"></a>
                        </div>
                    </div>
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
                        <input id='button-checkbox' type="checkbox" class='button-checkbox' name="has-button">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div id='button-container' class='vertical'>
                    <div class="button-title vertical">
                        <label for="button-title">Titre du bouton</label>
                        <div class="label-container horizontal">
                            <input id="button-title" name="button-title" type="text" onKeyUp='update_preview_button_title()'>
                        </div>
                    </div>
                    <div class="button-link vertical">
                        <label for="button-link">Lien</label>
                        <div class="label-container horizontal">
                            <p class="link-header vertical" style='margin: auto 0;padding: 0 5px;color: grey;'>https://</p>
                            <input id="button-link" name="button-link" type="text" onKeyUp='update_preview_button_href()'>
                        </div>
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
                $('#image-name').attr('value', namefile).trigger('change');

                done();
            },
            init: function() {
                this.on('removedfile', function (file) {
                    //alert(namefile);
                    $.ajax({
                        type: "POST",
                        url: "https://www.bebes-lutins.fr/view/html/administration/4.0/tabs/mails/newsletter/upload-image-newsletter.php",
                        data: {
                            target_file: namefile,
                            delete_file: 1
                        },
                        dataType: 'json',
                        success: function(d){
                            $('#image-name').attr('value', '').trigger('change');;
                            //alert(d.info); //will alert ok
                        }
                    });
                });

                this.on("addedfile", function() {
                    $('#image-name').attr('value', this.files[0].name);
                    if (this.files[1]!=null){
                        this.removeFile(this.files[0]);
                    }
                });
            }
        });
</script>
<script>

    $('#preview-title-container').hide();
    function update_preview_title(){
        console.log($('#title').val());
        if($('#title').val() != ''){
            $('#preview-title-container').show();
            $('#preview-title').text($('#title').val());
        } else $('#preview-title-container').hide();
    }

    $('#preview-text-container').hide();
    function update_preview_text(){
        text = $('#text').val();
        text.replace('\n', "<BR>");
        console.log(text);
        if($('#text').val() != ''){
            $('#preview-text-container').show();
            $('#preview-text').html(text);
        } else $('#preview-text-container').hide();
    }

    $('#preview-button-container').hide();
    function update_preview_button_title(){
        title = $('#button-title').val();
        if(title != ''){
            $('#preview-button-container').show();
            $('#preview-button').text(title);
        } else $('#preview-button-container').hide();
    }

    function update_preview_button_href(){
        href = $('#button-link').val();
        console.log('https://' + href);
        $('#preview-button').attr('href', 'https://' + href);
    }

    $('#preview-image-container').hide();
    $('#image-name').change(function(){
        $image_name = $('#image-name').val();
        console.log($image_name);
        if($image_name != ''){
            $('#preview-image-container').show();
            $('#preview-image').attr('src',('https://www.bebes-lutins.fr/view/assets/images/utils/newsletters/' + $('#image-name').val()));
        } else $('#preview-image-container').hide();
    })

    $("#preview-button-container").hide();
    $(".button-container").hide();
    $(".button-checkbox").change(function() {
        checked = this.checked;
        if(checked && $('#button-title').val() != '') {
            $(".button-container").show();
            $('#preview-button-container').show();
        } else {
            $(".button-container").hide();
            $('#preview-button-container').hide();
        }
    });

    /*bkLib.onDomLoaded(function() {
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
    }*/
</script>
</html>