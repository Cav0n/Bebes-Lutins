<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 13/12/2018
 * Time: 13:20
 */

class VoucherGateway
{
    public static function AddVoucher(String $id, String $name, float $discount, String $type, String $date_beginning, String $time_beginning, String $date_end, String $time_end, int $number_per_user, float $minimal_purchase, bool $deleted){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "INSERT INTO voucher VALUES(:id, :name, :discount, :type, :date_beginning, :time_beginning, :date_end, :time_end, :number_per_user, :minimal_purchase, :deleted);";
        $con->executeQuery($query, array(
            ':id'=>array($id, PDO::PARAM_STR),
            ':name'=>array($name, PDO::PARAM_STR),
            ':discount'=>array($discount, PDO::PARAM_STR),
            ':type'=>array($type, PDO::PARAM_STR),
            ':date_beginning'=>array($date_beginning, PDO::PARAM_STR),
            ':time_beginning'=>array($time_beginning, PDO::PARAM_STR),
            ':date_end'=>array($date_end, PDO::PARAM_STR),
            ':time_end'=>array($time_end, PDO::PARAM_STR),
            ':number_per_user'=>array($number_per_user, PDO::PARAM_STR),
            ':minimal_purchase'=>array($minimal_purchase, PDO::PARAM_STR),
            ':deleted'=>array($deleted, PDO::PARAM_BOOL)
        ));
    }

    public static function UpdateVoucher(String $id, float $discount, String $type, String $date_beginning, String $time_beginning, String $date_end, String $time_end, int $number_per_user, float $minimal_purchase, bool $deleted){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'UPDATE voucher SET discount=:discount, type=:type_discount, date_beginning=:date_beginning, time_beginning=:time_beginning, date_end=:date_end, time_end=:time_end, number_per_user=:number_per_user, minimal_purchase=:minimal_purchase, deleted=:deleted WHERE id=:id';
        $con->executeQuery($query, array(
            ':id'=>array($id, PDO::PARAM_STR),
            ':discount'=>array($discount, PDO::PARAM_STR),
            ':type_discount'=>array($type, PDO::PARAM_STR),
            ':date_beginning'=>array($date_beginning, PDO::PARAM_STR),
            ':time_beginning'=>array($time_beginning, PDO::PARAM_STR),
            ':date_end'=>array($date_end, PDO::PARAM_STR),
            ':time_end'=>array($time_end, PDO::PARAM_STR),
            ':number_per_user'=>array($number_per_user, PDO::PARAM_STR),
            ':minimal_purchase'=>array($minimal_purchase, PDO::PARAM_STR),
            ':deleted'=>array($deleted, PDO::PARAM_BOOL)
        ));
    }

    public static function DeleteVoucher(String $id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "UPDATE voucher SET deleted=true WHERE id=:id;";
        $con->executeQuery($query, array(':id' => array($id, PDO::PARAM_STR)));
    }

    public static function GetAllVoucher(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $voucher_list = array();

        $query = 'SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_per_user, minimal_purchase, deleted FROM voucher';
        $con->executeQuery($query);
        $voucher_list_db = $con->getResults();

        foreach ($voucher_list_db as $voucher_db){
            if($voucher_db['number_per_user'] == null) $voucher_db['number_per_user'] = 0; 
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_per_user'], $voucher_db['minimal_purchase'], $voucher_db['deleted']);
            $voucher_list[] = $voucher;
        }

        return $voucher_list;
    }

    public static function GetActiveVoucher(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $voucher_list = array();

        $query = "SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_per_user, minimal_purchase, deleted FROM voucher WHERE date_end>=(SELECT CURRENT_DATE()) AND date_beginning<=(SELECT CURRENT_DATE()) AND deleted!=true;";
        $con->executeQuery($query);
        $voucher_list_db = $con->getResults();

        foreach ($voucher_list_db as $voucher_db){
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_per_user'], $voucher_db['minimal_purchase'], $voucher_db['deleted']);
            $voucher_list[] = $voucher;
        }

        return $voucher_list;
    }
    
    public static function GetScheduledVoucher(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $voucher_list = array();

        $query = "SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_per_user, minimal_purchase, deleted FROM voucher WHERE date_beginning>(SELECT CURRENT_DATE());";
        $con->executeQuery($query);
        $voucher_list_db = $con->getResults();

        foreach ($voucher_list_db as $voucher_db){
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_per_user'], $voucher_db['minimal_purchase'], $voucher_db['deleted']);
            $voucher_list[] = $voucher;
        }

        return $voucher_list;
    }

    public static function GetExpiredVoucher(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $voucher_list = array();

        $query = "SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_per_user, minimal_purchase, deleted FROM voucher WHERE date_end<(SELECT CURRENT_DATE());";
        $con->executeQuery($query);
        $voucher_list_db = $con->getResults();

        foreach ($voucher_list_db as $voucher_db){
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_per_user'], $voucher_db['minimal_purchase'], $voucher_db['deleted']);
            $voucher_list[] = $voucher;
        }

        return $voucher_list;
    }

    public static function SearchVoucherByName(String $voucher_name){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_per_user, minimal_purchase, deleted FROM voucher WHERE name=:voucher_name;";
        $con->executeQuery($query, array(':voucher_name' => array($voucher_name, PDO::PARAM_STR)));
        $voucher_db = $con->getResults()[0];

        if($voucher_db != null){
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_per_user'], $voucher_db['minimal_purchase'], $voucher_db['deleted']);
            return $voucher;
        }
        else return null;
    }

    public static function GetVoucherByID(String $voucher_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_per_user, minimal_purchase, deleted FROM voucher WHERE id=:voucher_id;";
        $con->executeQuery($query, array(':voucher_id' => array($voucher_id, PDO::PARAM_STR)));
        $voucher_db = $con->getResults()[0];

        if($voucher_db != null){
            if($voucher_db['number_per_user'] == null) $voucher_db['number_per_user'] = 0;
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_per_user'], $voucher_db['minimal_purchase'], $voucher_db['deleted']);
            return $voucher;
        }
        else return null;
    } 
}