<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 13/12/2018
 * Time: 13:20
 */

class VoucherGateway
{
    public static function AddVoucher(String $id, String $name, float $discount, String $type, String $date_beginning, String $time_beginning, String $date_end, String $time_end, int $usage_per_user){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "INSERT INTO voucher VALUES(:id, :name, :discount, :type, :date_beginning, :time_beginning, :date_end, :time_end, :number_of_usage);";
        $con->executeQuery($query, array(
            ':id'=>array($id, PDO::PARAM_STR),
            ':name'=>array($name, PDO::PARAM_STR),
            ':discount'=>array($discount, PDO::PARAM_STR),
            ':type'=>array($type, PDO::PARAM_STR),
            ':date_beginning'=>array($date_beginning, PDO::PARAM_STR),
            ':time_beginning'=>array($time_beginning, PDO::PARAM_STR),
            ':date_end'=>array($date_end, PDO::PARAM_STR),
            ':time_end'=>array($time_end, PDO::PARAM_STR),
            ':number_of_usage'=>array($usage_per_user, PDO::PARAM_STR)
        ));
    }

    public static function UpdateVoucher(String $id, String $name, float $discount, String $type, String $date_beginning, String $time_beginning, String $date_end, String $time_end, int $usage_per_user){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'UPDATE voucher SET name=:name, discount=:discount, type=:type, date_beginning:date_beginning, time_beginning:time_beginning, date_end:date_end, time_end:time_end, number_of_usage:number_of_usage WHERE id=:id';
        $con->executeQuery($query, array(
            ':id'=>array($id, PDO::PARAM_STR),
            ':name'=>array($name, PDO::PARAM_STR),
            ':discount'=>array($discount, PDO::PARAM_STR),
            ':type'=>array($type, PDO::PARAM_STR),
            ':date_beginning'=>array($date_beginning, PDO::PARAM_STR),
            ':time_beginning'=>array($time_beginning, PDO::PARAM_STR),
            ':date_end'=>array($date_end, PDO::PARAM_STR),
            ':time_end'=>array($time_end, PDO::PARAM_STR),
            ':number_of_usage'=>array($usage_per_user, PDO::PARAM_STR)
        ));
    }

    public static function DeleteVoucher(String $id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "DELETE FROM voucher WHERE id=:id;";
        $con->executeQuery($query, array(':id' => array($id, PDO::PARAM_STR)));
    }

    public static function GetAllVoucher(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $voucher_list = array();

        $query = "SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_per_user FROM voucher;";
        $con->executeQuery($query);
        $voucher_list_db = $con->getResults();

        foreach ($voucher_list_db as $voucher_db){
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['usage_per_user']);
            $voucher_list[] = $voucher;
        }

        return $voucher_list;
    }

    public static function GetActiveVoucher(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $voucher_list = array();

        $query = "SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_of_usage FROM voucher WHERE date_end>=(SELECT SYSDATE()) AND date_beginning<=(SELECT SYSDATE());";
        $con->executeQuery($query);
        $voucher_list_db = $con->getResults();

        foreach ($voucher_list_db as $voucher_db){
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_of_usage']);
            $voucher_list[] = $voucher;
        }

        return $voucher_list;
    }

    public static function SearchVoucherByName(String $voucher_name){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT id, name, discount, type, date_beginning, time_beginning, date_end, time_end, number_of_usage FROM voucher WHERE name=:voucher_name;";
        $con->executeQuery($query, array(':voucher_name' => array($voucher_name, PDO::PARAM_STR)));
        $voucher_db = $con->getResults()[0];

        if($voucher_db != null){
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_of_usage']);
            return $voucher;
        }
        else return null;
    }
}