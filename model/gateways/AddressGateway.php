<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 06/12/2018
 * Time: 08:40
 */

class AddressGateway
{
    public static function GetAllAddress(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $address_list = array();

        $query = 'SELECT id, user_id, civility, surname, firstname, street, city, postal_code, complement, company FROM address_backup';
        $con->executeQuery($query);
        $addresses = $con->getResults();

        foreach ($addresses as $address) {

            $query = 'SELECT id, mail, password, surname, firstname, phone, privilege, registration_date, shopping_cart_id, birthlist_id, verification_key, activated, newsletter FROM user WHERE id=:user_id;';
            $con->executeQuery($query, array(':user_id' => array($address['user_id'], PDO::PARAM_STR)));
            $user = $con->getResults()[0];

            if($user != null) {
                $user = new UserConnected($user['id'], $user['surname'], $user['firstname'], $user['mail'], $user['phone'], $user['privilege'], $user['registration_date'], $user['activated']);
                $address_list[] = new Address($address['id'], $user, $address['civility'], $address['surname'], $address['firstname'], $address['street'], $address['city'], $address['postal_code'], $address['complement'], $address['company']);
            }
        }
        return $address_list;
    }

    public static function GetBillingAndShippingAddress(String $billing_address_id, String $shipping_address_id, UserConnected $user){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $address_list = array();

        $query = "SElECT id, user_id, civility, surname, firstname, street, city, postal_code, complement, company FROM address WHERE id=:billing_address_id;";
        $con->executeQuery($query, array(':billing_address_id' => array($billing_address_id, PDO::PARAM_STR)));
        $billing_address_db = $con->getResults()[0];

        $query = "SElECT id, user_id, civility, surname, firstname, street, city, postal_code, complement, company FROM address WHERE id=:shipping_address_id;";
        $con->executeQuery($query, array(':shipping_address_id' => array($shipping_address_id, PDO::PARAM_STR)));
        $shipping_address_db = $con->getResults()[0];

        $billing_address = new Address($billing_address_db['id'],$user,$billing_address_db['civility'],$billing_address_db['surname'],$billing_address_db['firstname'],$billing_address_db['street'],$billing_address_db['city'],$billing_address_db['postal_code'],$billing_address_db['complement'],$billing_address_db['company']);
        $shipping_address = new Address($shipping_address_db['id'], $user, $shipping_address_db['civility'], $shipping_address_db['surname'], $shipping_address_db['firstname'], $shipping_address_db['street'], $shipping_address_db['city'], $shipping_address_db['postal_code'], $shipping_address_db['complement'], $shipping_address_db['company']);

        $address_list['billing'] = $billing_address;
        $address_list['shipping'] = $shipping_address;
        return $address_list;
    }

    public static function DeleteAddressByUserIDAndFirstLine(String $user_id, String $street){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "DELETE FROM address WHERE user_id=:user_id AND street=:street;";
        $con->executeQuery($query, array(
            ':user_id' => array($user_id, PDO::PARAM_STR),
            ':street' => array($street, PDO::PARAM_STR)
        ));
    }

    public static function DeleteAddressWithID(String $user_id, String $address_id)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "DELETE FROM address WHERE user_id=:user_id AND id=:address_id";
        $con->executeQuery($query, array(
            ':user_id' => array($user_id, PDO::PARAM_STR),
            ':address_id' => array($address_id, PDO::PARAM_STR)
        ));
    }
}