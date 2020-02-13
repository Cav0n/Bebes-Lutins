<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 08/03/2019
 * Time: 15:06
 */

if(isset($_SESSION['password_lost_message_ok'])) $message_ok = $_SESSION['password_lost_message_ok'];
else $message_ok = null;

if(isset($_SESSION['password_lost_message_error'])) $message_error = $_SESSION['password_lost_message_error'];
else $message_error = null;

unset ($_SESSION['password_lost_message_ok']);
unset ($_SESSION['password_lost_message_error']);
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
    <?php if($message_error!=null){
        echo $message_error;
    } ?>
    <div id="password-lost" class="vertical">
        <h1>Mot de passe oublié</h1>
        <div id="password-lost-inner" class="vertical">
            <?php if($message_ok == null){ ?>
            <p class="information-text">Un lien de reinitialisation vous sera envoyé par mail si un compte existe bien avec cette adresse mail.</p>
            <form class="vertical" method="post" action="https://www.bebes-lutins.fr/envoyer-lien-mot-de-passe_perdu">
                <label for="mail">Email :</label>
                <input id="mail" type="email" name="mail" placeholder="Votre email"/>
                <button type="submit" class="horizontal"><p>Valider</p></button>
            </form>
            <?php } else {
                echo $message_ok;
            }?>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
</html>
