<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:14
 */

class ThumbnailsGateway
{
    public static function GetAll(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'SELECT DISTINCT image, product_id FROM thumbnails;';
        $con->executeQuery($query);
        $images = $con->getResults();

        return $images;
    }
}
