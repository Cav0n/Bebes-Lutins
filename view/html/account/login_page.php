<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 19/11/2018
 * Time: 15:14
 */

if (isset($_POST['message'])){
    $message = $_POST['message'];
} else $message = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Espace client - Bebes Lutins</title>
    <meta name="description" content="Accedez a votre espace client pour suivre vos commandes et mettre a jour vos informations."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main class="vertical centered">
    <div id="connection-or-register-wrapper" class="vertical">
        <div id="connection-or-register" class="horizontal centered">
            <div id="already-client" class="choice vertical">
                <h2>Connexion</h2>
                <div class="choice-inner vertical">
                    <p class="information-text">Si vous avez déjà un compte client chez Bébés Lutins vous pouvez vous connecter avec le formulaire ci-dessous.</p>
                    <form id="connection-form" class="vertical" method="post" action="https://www.bebes-lutins.fr/espace-client/auth">
                        <label for="mail">Email :</label>
                        <input id="mail" type="email" name="mail" placeholder="Votre email">
                        <label for="password">Mot de passe :</label>
                        <input id="password" type="password" name="password" placeholder="Votre mot de passe">
                        <?php echo $message?>
                        <button type="submit" class="horizontal"><p>S'identifier</p><?php echo file_get_contents("view/assets/images/utils/icons/avatar.svg"); ?></button>
                        <a class="medium" href="https://www.bebes-lutins.fr/mot-de-passe-perdu" style="margin: 0 auto;font-size:0.9rem;margin-top:1rem;">Mot de passe perdu ?</a>
                    </form>
                </div>
            </div>

            <div id="new-client" class="choice vertical">
                <h2>Enregistrement</h2>
                <div class="choice-inner vertical">
                    <p class="information-text">Si vous n'avez pas encore de commpte chez Bébés Lutins vous pouvez en créer un en quelques secondes.</p>
                    <form id="register-form" class="vertical" method="post" action="https://www.bebes-lutins.fr/espace-client/enregistrement">
                        <button type="submit" class="horizontal"><p>Créer votre compte</p><?php echo file_get_contents("view/assets/images/utils/icons/security.svg"); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
</html>
