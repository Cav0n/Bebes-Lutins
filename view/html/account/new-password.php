<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 26/02/2019
 * Time: 09:13
 */

$user_container = new UserContainer(unserialize($_SESSION['connected_user']));
$user = $user_container->getUser();

$id = $user->getId();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Espace client - Mot de passe - Bebes Lutins</title>
    <meta name="description" content="Changez votre mot de passe à tout moment."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <div id="user-orders-mobile" class="mobile vertical">
        <a href="https://www.bebes-lutins.fr/espace-client"><H1><i class="fas fa-arrow-left"></i> Mon compte</H1></a>
        <div class="orders">
            <H2>Mon mot de passe</H2>
            <form class="password-modification vertical" action="https://www.bebes-lutins.fr/espace-client/modifier-mot-de-passe" method="post">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <label for="old_password">Ancien mot de passe : </label>
                <input id="old_password" type="password" name="old_password">
                <label for="new_password">Nouveau mot de passe : </label>
                <input id="new_password" type="password" name="new_password">
                <label for="password_verify">Retapez le mot de passe : </label>
                <input id="password_verify" type="password" name="password_verify">
                <p style="font-size: 0.8em; color: red;" id="password-message"></p>
                <button id="password_change" type="submit" disabled>Modifier</button>
            </form>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>

<script>
    var password = document.getElementById("new_password")
        , confirm_password = document.getElementById("password_verify")
        , old_password = document.getElementById("old_password")
        , submit_button = document.getElementById("password_change")
        , password_message = document.getElementById("password-message");

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Les mots de passe ne correspondent pas.");
            password_message.innerHTML = "Les mots de passe ne correspondent pas.";
            submit_button.disabled = true;
        } else {
            if(old_password.value != '') {
                confirm_password.setCustomValidity('');
                password_message.innerHTML = "";

                submit_button.disabled = false;
            }
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
</body>
</html>