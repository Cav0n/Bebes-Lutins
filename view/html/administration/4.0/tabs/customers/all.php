<?php

$users = UserGateway::getAllUsers();

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
        <h2>Clients</h2>
    </div>
    <div class="window">
        <div class="window-header">
            <div class="window-tabs">
                <a href="https://www.bebes-lutins.fr/dashboard4/clients/tous-les-clients" class="tab vertical centered selected">Tous</a>
            </div>
        </div>
        <div class="window-inner">
            <div class="search-container">
                <div class="search-input-container">
                    <label for="search-text" class="hidden">Rechercher : </label>
                    <input onkeyup="search()" id="search-text" type="text" name="search-text" placeholder="Rechercher un client">
                </div>
            </div>
            <div class="table-container">
                <table>
                    <tr class="first-row">
                        <th class="date center">Date d'inscription</th>
                        <th class="name left">Nom</th>
                        <th class="mail right">Email</th>
                        <th class="phone right">Téléphone</th>
                    </tr>
                    <?php
                    foreach ($users as $user) {
                        if($user->getPrivilege() == 0) {
                            ?>
                            <tr onclick="open_customer_page('<?php echo $user->getId(); ?>')">
                                <td class="date center"><?php echo $user->getRegistrationDateString()?></td>
                                <td class="name left"><a href="https://www.bebes-lutins.fr/dashboard/page-client/<?php echo $user->getId(); ?>"><?php echo ucfirst($user->getFirstname()) . " " . strtoupper($user->getSurname()); ?></a></td>
                                <td class="mail right"><a href="mailto:<?php echo strtolower($user->getMail());?>"><?php echo strtolower($user->getMail()); ?></a></td>
                                <td class="phone right"><?php echo $user->getPhone(); ?></td>
                            </tr>
                        <?php } } ?>
                </table>
            </div>
        </div>
    </div>
</main>
</body>
<script>
    function open_customer_page(id) {
        document.location.href = "https://www.bebes-lutins.fr/dashboard/page-client/"+id;
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
            td_name = tr[i].getElementsByTagName("td")[1];
            td_mail = tr[i].getElementsByTagName("td")[2];
            td_phone = tr[i].getElementsByTagName("td")[3];

            if (td) {
                txtValue = td_name.textContent + td_mail.textContent + td_phone.textContent || td_name.innerText + td_mail.innerText + td_phone.innerText;
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