<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 27/11/2018
 * Time: 12:06
 */


class UtilsGateway
{
    public static function getShippingPrice() : float {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query="SELECT value FROM utils WHERE id='shipping_price'";
        $con->executeQuery($query);
        return $con->getResults()[0]['value'];
    }

    public static function getFreeShippingPrice() : float {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT value FROM utils WHERE id='free_shipping_price'";
        $con->executeQuery($query);
        return $con->getResults()[0]['value'];
    }

    public static function calculateTurnover(string $beginning_date, string $end_date) : float{
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT total_price FROM orders WHERE status > 0 AND ordering_date >= :beginning_date AND ordering_date <= :end_date;";
        $con->executeQuery($query, array(
            ':beginning_date' => array($beginning_date, PDO::PARAM_STR),
            ':end_date' => array($end_date, PDO::PARAM_STR)
        ));
        $results = $con->getResults();

        $total = 0;
        foreach ($results as $result){
            $total += $result['total_price'];
        }

        return $total;
    }

    public static function calculateShippingPrice(string $beginning_date, string $end_date){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT shipping_price FROM orders WHERE status > 0 AND ordering_date >= :beginning_date AND ordering_date <= :end_date;";
        $con->executeQuery($query, array(
            ':beginning_date' => array($beginning_date, PDO::PARAM_STR),
            ':end_date' => array($end_date, PDO::PARAM_STR)
        ));
        $results = $con->getResults();

        $total = 0;
        foreach ($results as $result){
            $total += $result['shipping_price'];
        }

        return $total;
    }
}