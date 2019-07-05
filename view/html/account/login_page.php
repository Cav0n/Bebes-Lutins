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
    <div id="connection" class="vertical">
        <h1>Connexion</h1>
        <div id="connection-inner" class="vertical">
            <form class="vertical" method="post" action="https://www.bebes-lutins.fr/espace-client/auth">
                <label for="mail">Email :</label>
                <input id="mail" type="email" name="mail" placeholder="Votre adresse mail">
                <label for="password">Mot de passe :</label>
                <input id="password" type="password" name="password" placeholder="Votre mot de passe">
                <?php echo $message?>
                <button type="submit">Se connecter</button>
            </form>
            <a class="medium" href="https://www.bebes-lutins.fr/mot-de-passe-perdu">Mot de passe perdu ?</a>
            <a class="medium" href="https://www.bebes-lutins.fr/espace-client/enregistrement">Pas encore de compte ?</a>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
</html>
