<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 03/01/2019
 * Time: 11:49
 */

class RetailerGateway
{
    public static function GetAllRetailers(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT name, address, website_url, image FROM retailers;";
        $con->executeQuery($query);
        $retailers_db = $con->getResults();

        return $retailers_db;
    }
}