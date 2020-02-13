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
    <div id="disp-users" class="horizontal between windows-container selected">
        <div class="vertical window" id="users-window">
            <div id="window-tabs-users" class="horizontal window-tabs">
                <p id="verified-accounts" class="tab non-selected transition-fast" onclick="tab_selection_changed_users('utilisateurs')">Comptes validés</p>
                <p id="administrators" class="tab selected transition-fast" onclick="tab_selection_changed_users('administrateurs')">Administrateurs</p>
            </div>
            <div id="display-users" class="tab-display">
                <div id="disp-verified-accounts" class="selected vertical centered users-list">
                    <?php foreach ($users as $user) { if($user->getPrivilege() >= 1){
                        if($user->getPhone() == null) $user->setPhone("Aucun numéro de téléphone.");
                        elseif(substr($user->getPhone(), 0, 1) != 0) $user->setPhone(0 . $user->getPhone());

                        ?>
                        <div class='user horizontal between'>
                            <div class='infos vertical'>
                                <p class='name'><?php echo $user->getFirstname(). " " .$user->getSurname(); ?></p>
                                <p>Email : <a href='mailto:$mail'><?php echo strtolower($user->getMail()); ?></a></p>
                                <p>Téléphone : <?php echo $user->getPhone(); ?></p>
                            </div>
                            <div class='vertical between'>
                                <p>Date d'inscription : <?php echo $user->getRegistrationDateString(); ?></p>
                                <a href='https://www.bebes-lutins.fr/dashboard/page-client-<?php echo $user->getId(); ?>' target='_blank'>Afficher la fiche client</a>
                            </div>
                        </div>
                    <?php } } ?>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
<script>
    function tab_selection_changed_users(option){
        document.location.href="https://www.bebes-lutins.fr/dashboard/tab/users/"+option;
    }
</script>
</html>