<?php

$products = ProductGateway::GetProducts2();
$outofstock = [];

foreach ($products as $product){
    if ($product->getStock() <= 0 && !$product->getHide()){
        $outofstock[] = $product;
    }
}
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
        <a href="https://www.bebes-lutins.fr/dashboard4/produits/tous-les-produits"><i class="fas fa-angle-left"></i> Produits</a>
    </div>
    <div class="page-title-container horizontal between">
        <h2>Stocks</h2>
        <form id="top-button-form" class="vertical centered" method="post" action="https://www.bebes-lutins.fr/dashboard4/produit/nouveau">
            <button type="submit">Ajouter un produit</button>
        </form>
    </div>
    <div id="warning-stock" class="vertical <?php if(empty($outofstock)) echo 'hidden';?>">
        <p>Plusieurs produits n'ont plus de stocks !</p>
        <ul>
        <?php
        foreach ($outofstock as $product) {
            ?>
            <li><a onclick="load_product('<?php echo $product->getId(); ?>')"><?php echo $product->getName();?></a>
            <?php
        }
        ?>
        </ul>
    </div>
    <div class="window">
        <div class="window-header">
            <div class="window-tabs">
                <a href="https://www.bebes-lutins.fr/dashboard4/produits/tous-les-produits" class="tab vertical centered selected">Tous</a>
            </div>
        </div>
        <div class="window-inner">
            <div class="search-container">
                <div class="search-input-container">
                    <label for="search-text" class="hidden">Rechercher : </label>
                    <input onkeyup="search()" id="search-text" type="text" name="search-text" placeholder="Rechercher un produit">
                </div>
            </div>
            <div class="table-container">
                <table id="product-table">
                    <tr>
                        <th class="custom-id center">Référence</th>
                        <th class="name left">Nom</th>
                        <th class="quantity center">Quantité</th>
                        <th class="update-quantity center">Mettre à jour la quantité</th>
                    </tr>
                    <?php $index = 0;
                    foreach ($products as $product) { ?>
                        <tr>
                            <td class="custom-id center"><?php echo $product->getReference(); ?></td>
                            <td class="name left"><?php echo $product->getName(); ?></td>
                            <td class="quantity center"><?php echo $product->getStock(); ?></td>
                            <td class="update-quantity center">
                                <form id="update-quantity-form" class="horizontal" action="https://www.bebes-lutins.fr/dashboard4/produit/mise-a-jour-stock" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                                    <label for="add-quantity-checkbox-<?php echo $index; ?>" class="add-button">Ajouter</label>
                                    <label for="add-quantity-checkbox-<?php echo $index; ?>" class="add-button-selected">Ajouter</label>
                                    <input id="add-quantity-checkbox-<?php echo $index; ?>" class="add-checkbox hidden" type="checkbox" name="quantity-checkbox" value="add">
                                    <label for="set-quantity-checkbox-<?php echo $index; ?>" class="define-button">Définir</label>
                                    <label for="set-quantity-checkbox-<?php echo $index; ?>" class="define-button-selected">Définir</label>
                                    <input id="set-quantity-checkbox-<?php echo $index; ?>" class="define-checkbox hidden" type="checkbox" name="quantity-checkbox" value="define">
                                    <label for="quantity-number" class="hidden">Quantité :</label>
                                    <input id="quantity-number" type="number" step="1" max="1000" value="0" name="quantity">
                                    <button class="save-button" type="submit">Enregistrer</button>
                                </form>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </table>
            </div>
        </div>
    </div>
</main>
</body>
<script>
    $('.add-button-selected').hide();
    $('.define-button-selected').hide();
</script>
<script>
    function search() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-text");
        filter = input.value.toUpperCase();
        table = document.getElementById("product-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            td2 = tr[i].getElementsByTagName("td")[1];
            if (td && td2) {
                txtValue = td.textContent + td2.textContent || td.innerText + td2.innerText;
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

    function load_product(id){
        document.location.href = "https://www.bebes-lutins.fr/dashboard4/produits/edition/"+id;
    }

    $(document).on("click", ".add-button", function(){
        $(this).hide();
        $(this).parent().children('.add-button-selected').show();
        $(this).parent().children('.define-button-selected').hide();
        $(this).parent().children('.define-button').show();
        $(this).parent().children('.define-checkbox').prop('checked', false);
    });

    $(document).on("click", ".add-button-selected", function(){
        $(this).hide();
        $(this).parent().children('.add-button').show();

    })

    $(document).on("click", ".define-button", function(){
        $(this).hide();
        $(this).parent().children('.define-button-selected').show();
        $(this).parent().children('.add-button-selected').hide();
        $(this).parent().children('.add-button').show();
        $(this).parent().children('.add-checkbox').prop('checked', false);

    });

    $(document).on("click", ".define-button-selected", function(){
        $(this).hide();
        $(this).parent().children('.define-button').show();
    });
</script>
</html>