<?php

$vouchers = VoucherGateway::GetAllVoucher();

?>

<!DOCTYPE html>
<html style="background: #3b3f4d;" lang="fr">
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
                    <p id="vouchers" class="tab selected transition-fast" onclick="tab_selection_changed_various('coupons')">Coupons</p>
                    <p id="product-backup" class="tab non-selected transition-fast" onclick="tab_selection_changed_various('restauration')">Restauration</p>
                </div>
                <div id="display-various" class="tab-display">
                    <div id="disp-vouchers" class="selected vertical various-element">
                        <div id="voucher-container" class="horizontal wrap">
                            <a class="vertical centered voucher" href="https://www.bebes-lutins.fr/dashboard/creation-code-coupon">Ajouter un code coupon</a>
                            <?php foreach ($vouchers as $voucher){
                                $voucher = (new VoucherContainer($voucher))->getVoucher();
                                if($voucher->isExpire()) {
                                    $date = "<p class='expired-voucher-message'>Le coupon n'est plus valable.</p>";
                                }
                                else {
                                    $beginning_date = $voucher->getDateBeginningString();
                                    $end_date = $voucher->getDateEndString();
                                    $date = "<p>Valable du $beginning_date au $end_date.</p>";
                                }
                                ?>
                                <form method="post" action="https://www.bebes-lutins.fr/dashboard/supprimer-coupon" class="voucher" <?php if($voucher->isExpire()) echo "style='color:red;'";?>>
                                    <p class="name"><?php echo $voucher->getName();?></p>
                                    <p class="reduction">Réduction : <?php echo $voucher->getDiscountAndTypeString().'.';?></p>
                                    <p class="number-of-usage">Nombre d'utilisation max : <?php echo $voucher->getNumberOfUsage();?></p>
                                    <p class><?php echo $date;?></p>

                                    <input type="hidden" name="voucher_id" value="<?php echo $voucher->getId();?>">
                                    <button type="submit" >Supprimer</button>
                                </form>
                            <?php }?>
                        </div>
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
