<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 19/11/2018
 * Time: 15:16
 */

if (isset($_POST['message'])){
    $message = $_POST['message'];
}
else $message = null;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Espace client - Bebes Lutins</title>
    <meta name="description" content="Accedez a votre espace client pour suivre vos commandes et mettre a jour vos informations."/>
    <?php UtilsModel::load_head();?>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main class="vertical centered">
    <div id="registration" class="vertical">
        <h1>Créer votre compte</h1>
        <div id="registration-inner">
            <form class="vertical" method="post" action="https://www.bebes-lutins.fr/espace-client/new-user">
                <label for="surname">Nom :</label>
                <input id="surname" type="text" name="surname" placeholder="Votre nom" required>
                <label for="surname">Prénom :</label>
                <input id="firstname" type="text" name="firstname" placeholder="Votre prénom" required>
                <label for="mail">Email :</label>
                <input id="mail" type="email" name="mail" placeholder="Votre adresse mail" required>
                <label for="phone">Votre numéro de téléphone :</label>
                <input id="phone" type="tel" name="phone" placeholder="Votre numéro de téléphone">
                <label for="password">Mot de passe :</label>
                <input id="password" type="password" name="password" placeholder="Votre mot de passe" required>
                <lable for="confirm_password">Confirmer le mot de passe :</lable>
                <input id="confirm_password" type="password" name="confirm_password" placeholder="Retapez le mot de passe" required>
                <div class="horizontal centered">
                    <label style="all:unset;" for="newsletter-checkbox">Je souhaite recevoir la newsletter de Bébés Lutins :</label>
                    <input id="newsletter-checkbox" type="checkbox" name="newsletter" value="yes" checked>
                </div>
                <div class="g-recaptcha" data-sitekey="6Ldj9p4UAAAAAAY_KU7zSzFiAIvfLagBc4WXHaEt" style="margin: 10px auto 0 auto;"></div>

                <?php echo $message;?>
                <button type="submit">Créer mon compte</button>
            </form>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
<script>
    var password = document.getElementById("password")
        , confirm_password = document.getElementById("confirm_password");

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Les mots de passe ne correspondent pas.");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
</body>
</html>
