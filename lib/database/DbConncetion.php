<?php
namespace lib\database;
include_once ( __DIR__."../../../config.php");


class DbConncetion{

    public static function setDbConncetion(){
        $conn = mysqli_connect(DB_host,DB_username,DB_password,DB_name) or die("connection failed check config file");
        return $conn;
    }
}