<?php

$orders = OrderGateway::GetOrdersFromGateway();


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
        <h2>Commandes en cours</h2>
    </div>
    <?php if(!empty($orders)) { ?>
    <div class="window">
        <div class="window-header">
            <div class="window-tabs">
                <a href="https://www.bebes-lutins.fr/dashboard4/commandes/en-cours" class="tab vertical centered">Toutes</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/commandes/en-cours/en-attente-de-paiement" class="tab vertical centered">En attente de paiement</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/commandes/en-cours/en-preparation" class="tab vertical centered selected">En préparation</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/commandes/en-cours/en-cours-de-livraison" class="tab vertical centered">En cours de livraison</a>
            </div>
        </div>
        <div class="window-inner">
            <div class="search-container">
                <div class="search-input-container">
                    <label for="search-text" class="hidden">Rechercher : </label>
                    <input onkeyup="search()" id="search-text" type="text" name="search-text" placeholder="Rechercher un nom">
                </div>
            </div>
            <div class="orders-list-container">
                <table id="order-table">
                    <tr class="first-row">
                        <th class="date center">Date</th>
                        <th class="customer left">Client</th>
                        <th class="price right">Prix</th>
                        <th class="shipping-price right">Frais de port</th>
                        <th class="status right">Etat</th>
                    </tr>
                    <?php
                    foreach ($orders as $order) {
                        if($order->getStatus() == 1){
                            ?>
                            <tr>
                                <td onclick="load_bill('<?php echo $order->getId(); ?>')" class="date center"><?php echo $order->getDateString(); ?></td>
                                <td onclick="load_bill('<?php echo $order->getId(); ?>')"  class="customer"><a><?php echo ucfirst($order->getCustomer()->getFirstname()) . " " . strtoupper($order->getCustomer()->getSurname()); ?><BR><b style="font-weight:300; font-size:0.9rem;"><?php echo $order->getId(); ?></b></a></td>
                                <td onclick="load_bill('<?php echo $order->getId(); ?>')" class="price right"><?php echo UtilsModel::FloatToPrice($order->getPriceAfterDiscount()); ?></td>
                                <td onclick="load_bill('<?php echo $order->getId(); ?>')" class="shipping-price right"><?php echo UtilsModel::FloatToPrice($order->getShippingPrice()); ?></td>
                                <td class="status right"><form method="post" action="https://www.bebes-lutins.fr/dashboard4/commandes/modifier-etat"><input type="hidden" name="id" value="<?php echo $order->getId(); ?>">
                                        <select name="new_status" onchange='if(this.value != <?php echo $order->getStatus(); ?>) { this.form.submit(); }'>
                                            <option value='-1' <?php if($order->getStatus() == -1) echo "selected"; ?>>Annuler la commande</option>
                                            <option value='0' <?php if($order->getStatus() == 0) echo "selected"; ?>>En attente de paiement</option>
                                            <option value='1' <?php if($order->getStatus() == 1) echo "selected"; ?>>En cours de traitement</option>
                                            <option value='2' <?php if($order->getStatus() == 2) echo "selected"; ?>>En cours de livraison</option>
                                            <option value='3' <?php if($order->getStatus() == 3) echo "selected"; ?>>Livrée</option>
                                        </select>
                                    </form></td>
                            </tr>
                        <?php } }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <img id="empty-image" src="https://www.bebes-lutins.fr/view/assets/images/utils/customer.svg">
    <div id="empty" style="position: relative; z-index: 100;">
        <p class="empty-title">Aucune commande en cours</p>
        <p class="empty-description">Patience, patience... un client ne devrait pas tarder à commander</p>
    </div>
    <?php } ?>
</main>
</body>
<script>
    function load_bill(id) {
        window.open(
            "https://www.bebes-lutins.fr/dashboard/facture-"+id,
            '_blank' // <- This is what makes it open in a new window.
        );
    }

    function search() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-text");
        filter = input.value.toUpperCase();
        table = document.getElementById("order-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

    const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
            v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
    )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

    // do the work...
    document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
        const table = th.closest('table');
        Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
            .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
            .forEach(tr => table.appendChild(tr) );
    })));
</script>
</html>