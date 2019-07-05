<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 18/11/2018
 * Time: 11:56
 */

$error_message = $_SESSION['error-message'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Erreur - Bebes Lutins</title>
    <meta name="description" content="Il y a eu une erreur dans votre demande, nous en sommes désolé."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <?php echo $error_message;?>
</main>
<footer>

</footer>
</body>
</html>