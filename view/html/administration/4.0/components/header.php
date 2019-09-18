<?php

$extra = null;

if($_GET['page'] == "nouveau" ||
     $_GET['page'] == "edition" || 
     $_GET['page'] == "creation" || 
     $_GET['page'] == "importer" ||
     $_GET['option'] == "nouveau" ||
     $_GET['option'] == "edition"){
    $extra = " nouveau";
}

?>

<header class="horizontal between<?php echo $extra; ?>">
    <a href='https://www.bebes-lutins.fr' class='vertical centered'><h1>BEBES LUTINS</h1></a>
    <a id="administrator-name" href="https://www.bebes-lutins.fr">Retour sur le site ></a>
    <div id="extra" class="between <?php if($extra == null || $_GET['page'] == "importer" || $_GET['section'] = 'newsletters') echo 'hidden';?>">
        <button class="remove-button" form='deletion-wrapper'>Supprimer</button>
        <button class="save-button" form="edition-wrapper">Enregistrer</button>
    </div>
    <div id="extra" class="between <?php if(!($_GET['section'] = 'newsletters' && $_GET['page'] == 'creation')) echo 'hidden';?>">
        <button class="save-button" form="edition-wrapper" style='margin-left:auto;'>Envoyer</button>
    </div>
</header>
<div id="left-header">
    <ul id="navigation-container">
        <li class="<?php if($_GET['section'] == "commandes" || $_GET['section'] == null) echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/commandes/en-cours"><div class="horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/box.svg"); ?></div><p>Commandes</p></a></li>
        <li class="sub-selection-container">
            <div class="sub-selection <?php if($_GET['page'] == "en-cours" || ($_GET['page'] == null && ($_GET['section'] == null || $_GET['section'] == 'commandes'))) echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/commandes/en-cours">En cours</a></div>
            <div class="sub-selection <?php if($_GET['page'] == "terminees") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/commandes/terminees">Terminées</a></div>
            <div class="sub-selection <?php if($_GET['page'] == "refusees") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/commandes/refusees">Refusées</a></div>
        </li>
        <li class="<?php if($_GET['section'] == "produits") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/produits/tous-les-produits"><div class="horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/price-tag.svg"); ?></div><p>Produits</p></a></li>
        <li class="sub-selection-container">
            <div class="sub-selection <?php if($_GET['page'] == "tous-les-produits" || ($_GET['page'] == null && $_GET['section'] == "produits")) echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/produits/tous-les-produits">Tous les produits</a></div>
            <div class="sub-selection <?php if($_GET['page'] == "categories") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/produits/categories">Catégories</a></div>
            <div class="sub-selection <?php if($_GET['page'] == "stocks") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/produits/stocks">Stocks</a></div>
        </li>
        <li class="<?php if($_GET['section'] == "clients") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/clients/tous-les-clients"><div class="horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/team.svg"); ?></div><p>Clients</p></a></li>
        <li class="<?php if($_GET['section'] == "avis") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/avis/tous-les-avis"><div class="horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/testimonial.svg"); ?></div><p>Avis clients</p></a></li>
        <li class="<?php if($_GET['section'] == "reductions") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes"><div class="horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/coupon.svg"); ?></div><p>Réductions</p></a></li>
        <li class="<?php if($_GET['section'] == "newsletters") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/newsletters/creation"><div class="horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/newsletter.svg"); ?></div><p>Newsletters</p></a></li>
        <li class="<?php if($_GET['section'] == "analyses") echo 'selected'; ?>"><a href="https://www.bebes-lutins.fr/dashboard4/analyses/tableau-de-bord/tous"><div class="horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/analysis.svg"); ?></div><p>Analyses</p></a></li>
    </ul>
    <ul id="version-container">
        <li>Version : 4.3.5</li>
    </ul>
</div>

<script>
    function cancel_creation(section){
        document.location.href="https://www.bebes-lutins.fr/dashboard4/"+section+"/";
    }

    function save(section, id){
        document.location.href="https://www.bebes-lutins.fr/dashboard4/"+section+"/sauvegarder/"+id;
    }
</script>