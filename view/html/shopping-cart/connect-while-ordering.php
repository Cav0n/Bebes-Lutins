<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 15/03/2019
 * Time: 14:37
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
<main class="vertical">
    <div id="connection-or-register-wrapper" class="vertical">
        <?php UtilsModel::load_shopping_cart_stepper();?>
        <div id="connection-or-register" class="horizontal centered">
            <div id="already-client" class="choice vertical">
                <h2>Vous êtes déjà client</h2>
                <div class="choice-inner vertical">
                    <p class="information-text">Nous sommes ravis de vous revoir ! Identifiez vous pour continuer votre commande.</p>
                    <form id="connection-form" class="vertical" method="post" action="https://www.bebes-lutins.fr/espace-client/auth">
                        <label for="mail">Email :</label>
                        <input id="mail" type="email" name="mail" placeholder="Votre email">
                        <label for="password">Mot de passe :</label>
                        <input id="password" type="password" name="password" placeholder="Votre mot de passe">
                        <?php echo $message?>
                        <button type="submit" class="horizontal"><img src="https://www.bebes-lutins.fr/view/assets/images/utils/user.png" alt="" class="vertical centered"><p>S'identifier</p></button>
                    </form>
                </div>
            </div>

            <div id="new-client" class="choice vertical">
                <h2>Vous n'êtes pas encore client</h2>
                <div class="choice-inner vertical">
                    <p class="information-text">Pour continuer votre commande vous devez créer un compte, cela prend moins d'une minute.</p>
                    <form id="register-form" class="vertical" method="post" action="https://www.bebes-lutins.fr/espace-client/enregistrement">
                        <button type="submit" class="horizontal"><img src="https://www.bebes-lutins.fr/view/assets/images/utils/security.png" alt="" class="vertical centered"><p>Créer votre compte</p></button>
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

