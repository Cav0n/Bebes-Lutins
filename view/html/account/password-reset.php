<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 2019-03-19
 * Time: 13:12
 */

$key = $_GET['key'];
$mail = $_GET['mail'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mot de passe oublié - Bebes Lutins</title>
    <meta name="description" content="Vous pouvez reinitialiser votre mot de passe si vous l'avez perdu."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main class="vertical centered">
    <div id="password-reset" class="vertical">
        <h1>Votre nouveau mot de passe</h1>
        <div id="password-lost-inner" class="vertical">
            <p class="information-text">Vous pouvez désormais créer un nouveau mot de passe. Pour des raisons de sécurité vous devez le tapez deux fois.</p>
            <form class="vertical" method="post" action="https://www.bebes-lutins.fr/reinitialiser-mot-de-passe">
                <input type="hidden" name="mail" value="<?php echo $mail;?>">
                <input type="hidden" name="key" value="<?php echo $key;?>">
                <label for="mail">Nouveau mot de passe :</label>
                <input id="new_password" type="password" name="new_password" placeholder="Votre nouveau mot de passe"/>
                <label for="mail">Confirmation :</label>
                <input id="confirm_password" type="password" name="confirm_password" placeholder="Retapez votre nouveau mot de passe"/>
                <button type="submit" class="horizontal"><p>Valider</p></button>
            </form>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
<script>
    var password = document.getElementById("new_password")
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

