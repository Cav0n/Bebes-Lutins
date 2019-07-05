<?php

?>

<!DOCTYPE html>
<html style="background: #3b3f4d;">
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
    <div id="display-windows">
        <div id="disp-various" class="horizontal between windows-container selected">
            <?php if(isset($_POST['error-message-various'])) echo $_POST['error-message-various'];?>
            <div class="vertical window" id="various-window">
                <div id="window-tabs-various" class="horizontal window-tabs">
                    <p id="turnover" class="tab non-selected transition-fast" onclick="tab_selection_changed_various('chiffre')">Chiffre d'affaire</p>
                    <p id="vouchers" class="tab non-selected transition-fast" onclick="tab_selection_changed_various('coupons')">Coupons</p>
                    <p id="product-backup" class="tab selected transition-fast" onclick="tab_selection_changed_various('restauration')">Restauration</p>
                </div>
                    <div id="disp-product-backup" class="non-selected vertical various-element">
                        <p>La restauration des produits n'est pas encore mis en place, patientez encore un peu ;-).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
<script>
    function tab_selection_changed_various(option){
        document.location.href="https://www.bebes-lutins.fr/dashboard/tab/various/"+option;
    }
</script>
</html>
