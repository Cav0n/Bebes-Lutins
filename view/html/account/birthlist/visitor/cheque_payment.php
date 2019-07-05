<?php

$birthlist = BirthlistGateway::GetBirthlistByID($_GET['birthlist_id']);

$selected_items = unserialize($_SESSION['selected_items']);
foreach ($selected_items as $item)
{
    $item = (new BirthListItemContainer($item))->getBirthlistItem();
    $total_price += ($item->getProduct()->getPrice() * $item->getQuantity());
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Liste de naissance - Bebes Lutins</title>
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
            <form id="birthlist-explanation" method="post" action="https://www.bebes-lutins.fr/liste-de-naissance/merci/<?php echo $birthlist->getId(); ?>">
                <p>Merci d'établir votre chèque à l'ordre de : <em>ACTYPOLES</em>.<BR>
                    <BR>
                    Le paiement est à nous faire parvenir à :<BR>
                    Actypoles / Bébés Lutins<BR>
                    4, rue du 19 mars 1962<BR>
                    63300 THIERS<BR>
                    <BR>
                    Montant de votre commande : <b><?php echo UtilsModel::FloatToPrice($total_price);?></b>.<BR>
                    <BR>
                    Votre commande sera remise aux parents une fois votre chèque reçu et une fois la liste close par les parents.</p>
                <button type="submit">Valider le paiement</button>
            </form>
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