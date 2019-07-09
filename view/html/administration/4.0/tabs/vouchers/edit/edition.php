<?php

$voucher = VoucherGateway::GetVoucherByID($_REQUEST["voucher_id"]);

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
        <a href="https://www.bebes-lutins.fr/dashboard4/reductions/"><i class="fas fa-angle-left"></i> Réductions</a>
    </div>
    <div class="page-title-container horizontal between">
        <h2>Modifier un code de réduction</h2>
    </div>
    <form id="edition-wrapper" class="horizontal"  action="https://www.bebes-lutins.fr/dashboard4/reductions/sauvegarder/" method="post">
        <input type='hidden' name='voucher_id' value='<?php echo $voucher->getId();?>'>
        <div class="column-big vertical">
            <div class="code-name-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Code</p>
                </div>
                <div class="code vertical">
                    <input id="code" type="text" name="name" placeholder="par ex. SOLDESPRINTEMPS" value='<?php echo $voucher->getName(); ?>' disabled>
                    <label class="help" for="code">Les clients saisiront ce code promotionnel lors de leur passage à la caisse.</label>
                </div>
            </div>
            <div class="code-options-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Options</p>
                </div>
                <div class="horizontal">
                    <div class="type vertical" style="width: 100%;margin-right: 1rem;">
                        <label for="type">Type de réduction</label>
                        <select id="type" name="type">
                            <option value="1" <?php if($voucher->getType() == 1) echo 'selected'; ?>>Pourcentage</option>
                            <option value="2" <?php if($voucher->getType() == 2) echo 'selected'; ?>>Montant fixe</option>
                            <option value="3" <?php if($voucher->getType() == 3) echo 'selected'; ?>>Livraison gratuite</option>
                        </select>
                    </div>
                    <div class="value vertical" style="width: 100%;">
                        <label for="value">Valeur de la réduction</label>
                        <input id="value" type="number" name="discount" value="<?php echo $voucher->getDiscount(); ?>">
                    </div>
                </div>
            </div>
            <div class="code-dates-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Dates d'activités</p>
                </div>
                <div id="beginning-date-container" class="horizontal">
                    <div class="beginning-date vertical" style="width: 100%;margin-right: 1rem;">
                        <label for="beginning-date">Date de début</label>
                        <input id="beginning-date" type="date" name="date_beginning" value='<?php echo $voucher->getDateBeginning(); ?>'>
                    </div>
                    <div class="beginning-date-hour vertical" style="width: 100%;">
                        <label for="beginning-date-hour">Heure de début</label>
                        <input id="beginning-date-hour" type="time" name="time_beginning" value='<?php echo $voucher->getTimeBeginning();?>'>
                    </div>
                </div>
                <div id="end-date-container" class="horizontal">
                    <div class="end-date vertical" style="width: 100%;margin-right: 1rem;">
                        <label for="end-date">Date de fin</label>
                        <input id="end-date" type="date" name="date_end" value='<?php echo $voucher->getDateEnd(); ?>'>
                    </div>
                    <div class="end-date-hour vertical" style="width: 100%;">
                        <label for="end-date-hour">Heure de fin</label>
                        <input id="end-date-hour" type="time" name="time_end" value='<?php echo $voucher->getTimeEnd(); ?>'>
                    </div>
                </div>
            </div>
        </div>
        <div class="column-tiny vertical">
            <div class='minimal-purchase-container edition-window'>
                <div class="container-title horizontal between">
                    <p class="section-title">Montant minimal d'achat</p>
                </div>
                <div class='minimal-purchase vertical'>
                    <input id="minimal-purchase" type="number" name="minimal-purchase" value='0' placeholder='0' min="0" step="0.01">
                </div>
            </div>
            <div class='number-per-user-container edition-window'>
                <div class="container-title horizontal between">
                    <p class="section-title">Nombre d'utilisation max</p>
                </div>
                <div class='number-per-user vertical'>
                    <input id="number-per-user" type="number" name="number_per_user" value='<?php echo $voucher->getNumberPerUser(); ?>' placeholder='1' min="1" step="1">
                </div>
            </div>
            <div class="code-summary-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Résumé</p>
                </div>
                <div class="summary vertical">
                    <label class="help">Aucune information saisie.</label>
                </div>
                <div class="container-title horizontal between" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #cccccc;">
                    <p class="section-title">Performance</p>
                </div>
                <div class="summary vertical">
                    <label class="help">La réduction n'est pas active.</label>
                </div>
            </div>
            <span id='deleting-button' class='vertical centered' onclick="delete_voucher('<?php echo $voucher->getId(); ?>')">Supprimer</span>
        </div>
    </form>
</main>
</body>
<script>
function delete_voucher(id){
    document.location.href='https://www.bebes-lutins.fr/dashboard4/reductions/supprimer/' + id;
}
</script>
</html>