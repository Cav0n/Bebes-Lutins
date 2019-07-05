<?php

$reviews = ReviewGateway::GetAllAcceptedReview();

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
                <a class="selected" href="https://www.bebes-lutins.fr/dashboard/tab/reviews/validated">Avis validés</a>
                <a href="https://www.bebes-lutins.fr/dashboard/tab/reviews/declined">Avis refusés</a>
            </div>
            <table id="result-container">
                <tr class="result-header">
                    <th class="name-user"><p class="pointer">Utilisateur</p></th>
                    <th class="name-product"><p class="pointer">Produit</p></th>
                    <th class="comment"><p class="pointer">Commentaire</p></th>
                    <th class="mark"><p class="pointer">Note</p></th>
                    <th class="review-link">Afficher</th>
                    <th class="delete">Supprimer</th>
                </tr>
                <?php foreach ($reviews as $review) { $review = ReviewContainer::GetReview($review); ?>
                    <tr class="result" style="text-align: center;">
                        <td class="name-user"><a href="https://www.bebes-lutins.fr/dashboard/page-client-<?php echo $review->getCustomer()->getId(); ?>"><?php echo $review->getCustomerName(); ?></a></td>
                        <td class="name-product"><a href="https://www.bebes-lutins.fr/produit/<?php echo $review->getProduct()->getId(); ?>"><?php echo $review->getProduct()->getName(); ?></a></td>
                        <td class="comment"><?php echo $review->getText(); ?></td>
                        <td class="mark"><?php echo $review->getMark(); ?></td>
                        <td class="review-link"><a href="https://www.bebes-lutins.fr/produit/<?php echo $review->getProduct()->getId(); ?>"><i class="fas fa-link"></i></a></td>
                        <td class="delete"><a href="https://www.bebes-lutins.fr/dashboard/commentaire/supprimer/<?php echo $review->getId();?>"><i class="fas fa-trash-alt"></i></a></td>
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
        var input, filter, table, tr, td_name, td_mail, i, txtValue;
        input = document.getElementById("search-text");
        filter = input.value.toUpperCase();
        table = document.getElementById("result-container");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td_name = tr[i].getElementsByTagName("td")[1];
            td_mail = tr[i].getElementsByTagName("td")[2];

            if (td_name && td_mail) {
                txtValue = td_name.textContent + td_mail.textContent || td_name.innerText + td_mail.innerText;
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
</html>