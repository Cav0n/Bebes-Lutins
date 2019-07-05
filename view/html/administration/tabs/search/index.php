<?php

$users = UserGateway::getAllUsers();

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
                <a class="selected" href="https://www.bebes-lutins.fr/dashboard/tab/search/utilisateurs">Utilisateurs</a>
                <a href="https://www.bebes-lutins.fr/dashboard/tab/search/produits">Produits</a>
            </div>
            <table id="result-container">
                <tr class="result-header">
                    <th class="date-user"><p class="pointer">Date d'inscription</p></th>
                    <th class="name-user"><p class="pointer">Nom</p></th>
                    <th class="mail-user"><p class="pointer">Email</p></th>
                    <th class="phone-user"><p class="pointer">Téléphone</p></th>
                    <th class="customer-page-link">Fiche client</th>
                </tr>
                <?php foreach ($users as $user) { ?>
                <tr class="result" style="text-align: center;">
                    <td class="date-user"><?php echo $user->getRegistrationDateString(); ?></td>
                    <td class="name-user"><?php echo ucfirst($user->getFirstname()) . " " . strtoupper($user->getSurname())?></td>
                    <td class="mail-user"><?php echo "<a href='mailto:". $user->getMail() ."'> ". strtolower($user->getMail()) . "</a>"; ?></td>
                    <td class="phone-user"><?php echo $user->getPhone(); ?></td>
                    <td class="customer-page-link"><a href="https://www.bebes-lutins.fr/dashboard/page-client/<?php echo $user->getId(); ?>" target='_blank'><i class="fas fa-link"></i></a></td>
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