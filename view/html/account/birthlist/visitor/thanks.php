<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:33
 */

$products = ProductGateway::GetProducts();
$categories = CategoryGateway::GetCategories();

$birthlist = BirthlistGateway::GetBirthlistByID($_GET['birthlist_id']);

$total_items_count = 0;
$total_items_price = 0;
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Merci - Bebes Lutins</title>
    <meta name="description" content="Achetez les produits que vous souhaitez pour <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?> . Vous pouvez choisir la quantité à acheter,
                la quantité optimale a été choisis par <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?> ."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>

<main class="vertical">
    <div id="birthlist-visitor-container" class="vertical">
        <div id="birthlist-header" class="vertical">
            <h1>Liste de naissance de <?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?></h1>
            <h2><?php echo $birthlist->getMessage(); ?></h2>
        </div>
        <div id="birthlist-inner" class="vertical">
            <div id="birthlist-explanation">
                <p><?php echo $birthlist->getMotherName(); ?> et <?php echo $birthlist->getFatherName(); ?> vous remercie d'avoir participé à leur liste de naissance !</p>
                <a href="https://www.bebes-lutins.fr/liste-de-naissance/partage/<?php echo $birthlist->getId(); ?>">Retourner à la liste de naissance</a>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
<script>
    $(".item-checkbox").change(function(){
        if ($('.item-checkbox:checked').length == 0) {
            document.getElementById("button-apply-modification-birthlist").setAttribute("disabled", "disabled");
        }
        else {
            document.getElementById("button-apply-modification-birthlist").removeAttribute("disabled");
        }
    });
</script>
</body>
</html>