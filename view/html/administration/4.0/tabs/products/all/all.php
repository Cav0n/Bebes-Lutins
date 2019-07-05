<?php

$products = ProductGateway::GetProducts2();


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
        <h2>Produits</h2>
        <form id="top-button-form" class="vertical centered" method="post" action="https://www.bebes-lutins.fr/dashboard4/produits/nouveau">
            <button type="submit">Ajouter un produit</button>
        </form>
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
                        <th class="image"></th>
                        <th class="custom-id center">Référence</th>
                        <th class="name left">Nom</th>
                        <th class="category left">Catégorie</th>
                        <th class="stock center">Stock</th>
                        <th class="price right">Prix</th>
                    </tr>
                    <?php
                    foreach ($products as $product) { ?>
                            <tr onclick="load_product('<?php echo $product->getId(); ?>')">
                                <td class="image center"><img src="https://www.bebes-lutins.fr/view/assets/images/products/<?php echo $product->getImage();?>" alt="<?php echo $product->getName();?>"></td>
                                <td class="custom-id center"><?php echo $product->getReference(); ?></td>
                                <td class="name left"><a href="https://www.bebes-lutins.fr/dashboard4/produits/edition/<?php echo $product->getId(); ?>"><?php echo $product->getName(); ?></a></td>
                                <td class="category left"><?php foreach ($product->getCategory() as $category) echo $category->getName() . '<BR>'; ?></td>
                                <td class="stock center"><?php echo $product->getStock(); ?></td>
                                <td class="price right"><?php echo UtilsModel::FloatToPrice($product->getPrice()); ?></td>
                            </tr>
                        <?php } ?>
                </table>
            </div>
        </div>
    </div>
</main>
</body>
<script>
    function load_product(id){
        document.location.href = "https://www.bebes-lutins.fr/dashboard4/produits/edition/"+id;
    }

    function search() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-text");
        filter = input.value.toUpperCase();
        table = document.getElementById("product-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[2];
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
</script>
</html>