<?php

$products = ProductGateway::GetProducts();

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
    <div id="display-windows" class="horizontal">
        <div id="search-window">
            <form id="search-container" class="horizontal">
                <label for="search-text" class="hidden">Recherche</label>
                <input id="search-text" type="text" placeholder="Tapez votre recherche" onkeyup="myFunction()">
                <button type="submit">Rechercher</button>
            </form>
            <div id="search-choice-container" class="horizontal centered">
                <a href="https://www.bebes-lutins.fr/dashboard/tab/search/utilisateurs">Utilisateurs</a>
                <a class="selected" href="https://www.bebes-lutins.fr/dashboard/tab/search/produits">Produits</a>
            </div>
            <table id="result-container">
                <tr class="result-header">
                    <th class="reference-product"><p class="pointer">Référence</p></th>
                    <th class="name-product"><p class="pointer">Nom</p></th>
                    <th class="price-product"><p class="pointer">Prix</p></th>
                    <th class="number-of-review"><p class="pointer">Nombre d'avis</p></th>
                    <th class="stock-product"><p class="pointer">Stock</p></th>
                    <th class="product-page-link"><p>Fiche produit</p></th>
                </tr>
                <?php foreach ($products as $product) { ?>
                    <tr class="result" style="text-align: center;">
                        <td class="reference-product"><?php echo $product->getReference(); ?></td>
                        <td class="name-product"><?php echo $product->getName(); ?></td>
                        <td class="price-product"><?php echo UtilsModel::FloatToPrice($product->getPrice()); ?></td>
                        <td class="number-of-review"><?php echo $product->getNumberOfReview(); ?></td>
                        <td class="stock-product"><?php echo $product->getStock(); ?></td>
                        <td class="product-page-link"><a href="https://www.bebes-lutins.fr/dashboard/modifier-produit-page/<?php echo $product->getId(); ?>" target='_blank'><i class="fas fa-link"></i></a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>

</body>
<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td_reference, td_mail, i, txtValue;
        input = document.getElementById("search-text");
        filter = input.value.toUpperCase();
        table = document.getElementById("result-container");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td_reference = tr[i].getElementsByTagName("td")[0];
            td_name = tr[i].getElementsByTagName("td")[1];

            if (td_reference && td_name) {
                txtValue = td_reference.textContent + td_name.textContent || td_reference.innerText + td_name.innerText;
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