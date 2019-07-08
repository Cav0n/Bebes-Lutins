<?php

//$vouchers = VoucherGateway::GetAllVoucher();
$vouchers = VoucherGateway::GetAllVoucher();

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
                <a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes/" class="tab vertical centered selected">Tous</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes/actifs" class="tab vertical centered">Actifs</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes/programmes" class="tab vertical centered">Programmés</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/reductions/tous-les-codes/expires" class="tab vertical centered">Expirés</a>
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
                    foreach ($vouchers as $voucher) { $voucher = (new VoucherContainer($voucher))->getVoucher()
                        ?>
                        <div class="voucher vertical" onclick="load_voucher('<?php echo $voucher->getId(); ?>')">
                            <label class="container vertical centered"><?php echo $voucher->getName(); ?>
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                            <p class="description">Du <?php echo $voucher->getDateBeginningString()?> au <?php echo $voucher->getDateEndString();?> - <?php echo $voucher->getDiscountAndTypeString();?></p>
                            <p class="status"><?php if($voucher->getDateEnd())?></p>
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