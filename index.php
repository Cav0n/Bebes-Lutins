<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 19:45
 */

require_once(__DIR__.'/config/config.php');

//chargement autoloader pour autochargement des classes
require_once(__DIR__.'/config/Autoload.php');
Autoload::charger();

$cont = new FrontController();
?>

