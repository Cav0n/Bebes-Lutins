<?php

try {
    $today_date = date('Y-m', mktime(0, 0, 0,date("m")+1, 0, date("Y")));
    $yesterday_date = date('Y-m', mktime(0, 0, 0, date("m"), 0, date("Y")));

    $min_date = date('Y-m', mktime(0,0,0,7, 0, 2017));
    $max_date = $today_date;
} catch (Exception $e) {

}

$orders = OrderGateway::GetOrdersFromGateway();
$turnover = 0;
foreach ($orders as $order){
    if($order->getStatus() >= 2) $turnover += ($order->getTotalPrice() + $order->getShippingPrice());
}

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
                    <p id="turnover" class="tab selected transition-fast" onclick="tab_selection_changed_various('chiffre')">Chiffre d'affaire</p>
                    <p id="vouchers" class="tab non-selected transition-fast" onclick="tab_selection_changed_various('coupons')">Coupons</p>
                    <p id="product-backup" class="tab non-selected transition-fast" onclick="tab_selection_changed_various('restauration')">Restauration</p>
                </div>
                <div id="display-various" class="tab-display">
                    <div id="disp-turnover" class="selected vertical various-element">
                        <h2>Chiffre d'affaire depuis le début du site : <?php echo UtilsModel::FloatToPrice($turnover); ?></h2>
                        <form id="turnover-calculation-form">
                            <label for="beginning-date">Date de début :</label>
                            <input id="beginning-date" name="beginning_date" type="month" value="<?php echo $yesterday_date?>" min="<?php echo $min_date?>" max="<?php echo $max_date?>">
                            <label for="end-date">Date de fin :</label>
                            <input id="end-date" name="end_date" type="month" value="<?php echo $today_date?>" min="<?php echo $min_date?>" max="<?php echo $max_date?>">
                            <p id="turnover-result"></p>
                        </form>
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
<script>
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("turnover-result").innerHTML = this.responseText;
        }
    };

    /* Date de début */
    let beginning_date = document.getElementById('beginning-date');
    beginning_date.valueAsDate = new Date();

    var previous_typed_beginning_date = new Date();

    // Sauvegarde de la date
    beginning_date.onfocus = function(){
        previous_typed_beginning_date = document.getElementById('beginning-date').value;
    };

    // Changement de la date dynamiquement
    beginning_date.onchange = function(){
        if(beginning_date.valueAsDate > end_date.valueAsDate){
            document.getElementById('beginning-date').value = previous_typed_beginning_date;
            alert("La date de début ne peut pas être après la date de fin.");
            //console.log(previous_typed_beginning_date);
        }
        else{
            console.log("https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");

            xhttp.open("GET", "https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");
            xhttp.send();
        }
    };

    /* ---- */

    /* Date de fin */
    let end_date = document.getElementById('end-date');
    end_date.valueAsDate = new Date();

    // Sauvegarde de la date
    end_date.onfocus = function(){
        previous_typed_end_date = document.getElementById('end-date').value;
    }

    // Changement de la date dynamiquement
    end_date.onchange = function(){
        if(end_date.valueAsDate < beginning_date.valueAsDate){
            document.getElementById('end-date').value = previous_typed_end_date;
            alert("La date de fin ne peut pas être avant la date de début.");
        }
        else {
            console.log("https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");


            xhttp.open("GET", "https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");
            xhttp.send();
        }
    };
    /* ---- */

    // Initialisation du chiffre d'affaire :
    xhttp.open("GET", "https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");
    xhttp.send();
    console.log("https://www.bebes-lutins.fr/?action=calculate_turnover&beginning_date="+beginning_date.valueAsDate.getFullYear()+"-"+(beginning_date.valueAsDate.getMonth()+1)+"-1"+"&end_date="+end_date.valueAsDate.getFullYear()+"-"+(end_date.valueAsDate.getMonth()+1)+"-31");

</script>
</html>