<?php


class NotificationGateway
{
    public static function GetNumberOfNewNotifications(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT new_orders, new_users, new_reviews FROM notifications WHERE key_number=0;";
        $con->executeQuery($query);
        $notifications = $con->getResults()[0];

        return $notifications;
    }
}