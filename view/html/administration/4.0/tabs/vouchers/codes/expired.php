<?php

$vouchers = VoucherGateway::GetExpiredVoucher();

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
    <div class="page-title-container horizontal between">
        <h2>Code promotionnels</h2>
        <form id="top-button-form" class="vertical centered" method="post" action="https://www.bebes-lutins.fr/dashboard4/reductions/creation">
            <button type="submit">Créer un code de réduction</button>
        </form>
    </div>
    <div class="window">
        <div class="window-header">
            <div class="window-tabs">
                <a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes/" class="tab vertical centered ">Tous</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes/actifs" class="tab vertical centered">Actifs</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes/programmes" class="tab vertical centered ">Programmés</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes/expires" class="tab vertical centered selected">Expirés</a>
            </div>
        </div>
        <div class="window-inner">
            <div class="search-container">
                <div class="search-input-container">
                    <label for="search-text" class="hidden">Rechercher : </label>
                    <input id="search-text" type="text" name="search-text" placeholder="Rechercher une réduction">
                </div>
            </div>
            <div id="voucher-list-container">
                <div id="voucher-list-header">
                    <label class="container vertical centered">Tout selectionner
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div id="voucher-list">
                    <?php
                    foreach ($vouchers as $voucher) { $voucher = (new VoucherContainer($voucher))->getVoucher();
                        if($voucher->getDateBeginning() > date('Y-m-d')) {$status = "Programmé"; $status_css = "programmed"; }
                        else if($voucher->getDateEnd() < date('Y-m-d')) {$status = "Expiré"; $status_css = "expired"; }
                        else {$status = "Actif"; $status_css = "active"; }
                        ?>
                        <div class="voucher vertical">
                            <label class="container vertical centered"><div class='horizontal'><p><?php echo $voucher->getName(); ?> - </p><a onclick="load_voucher('<?php echo $voucher->getId(); ?>')" class="edition-link">Editer</a></div>
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                            <p class="discount margin-left">Réduction : <?php echo $voucher->getDiscountAndTypeString();?></p>
                            <p class="minimal_purchase margin-left">Montant minimum d'achat :  <?php echo UtilsModel::FloatToPrice($voucher->getMinimalPurchase()); ?></p>
                            <p class="usage_per_user margin-left" style='margin-bottom: 10px;'>Nombre d'utilisations par personne : <?php echo $voucher->getNumberPerUser(); ?></p>
                            <div class="horizontal">
                                <div class="vertical">
                                    <p class="first-date margin-left">Du <?php echo $voucher->getDateBeginningString()?> à <?php echo $voucher->getTimeBeginning(); ?></p>
                                    <p class="last-date margin-left">Au <?php echo $voucher->getDateEndString();?> à <?php echo $voucher->getTimeEnd(); ?></p>
                                </div>
                                <p class="status <?php echo $status_css; ?>"><?php echo $status; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
<script>
function load_voucher(id) {
        document.location.href = "https://www.bebes-lutins.fr/dashboard4/reductions/edition/"+id;
    }
</script>
</html>