<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 05/12/2018
 * Time: 15:44
 */

?>

<!DOCTYPE html>
<html>
<head>
    <title>Nos produits - Bébés Lutins</title>
    <meta name="description" content="Découvrez les couches lavables éco-citoyennes de Bébés Lutins ! Fabriquées en France, elles sont écologiques et sans produits toxiques pour le bien-être de bébé."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <?php UtilsModel::load_swiper();?>
    <?php UtilsModel::load_categories_display();?>
    <?php UtilsModel::load_certifications();?>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
</html>