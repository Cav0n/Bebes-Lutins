<?php

$users = UserGateway::getAllUsers();

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
    <div class="page-title-container horizontal between" style="position: relative; z-index: 100;">
        <h2>Tableau de bord</h2>
    </div>
    <img id="in-construction-image" src="https://www.bebes-lutins.fr/view/assets/images/utils/in-construction.svg">
    <div id="in-construction" style="position: relative; z-index: 100;">
        <p class="construct-title">En cours de construction</p>
        <p class="construct-description">Encore un petit peu de patience...</p>
    </div>
</main>
</body>
</html>