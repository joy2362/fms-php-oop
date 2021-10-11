<?php
namespace lib\login;

use lib\database\DbConncetion;
use lib\session\session_management;

include_once ( __DIR__."../../../config.php");
include_once Base_url."/lib/session/session_management.php";
include_once Base_url."/lib/database/DbConncetion.php";

class LoginHandler
{
    private $name,$pass;
    public function __construct($name , $pass ){
        $this->name = $name;
        $this->pass = $pass;
        session_management::init();
    }

    public function varification(){
        if (strlen(trim($this->name)) === 0 and strlen(trim($this->pass)) === 0){
            session_management::set("error","please insert username and password!!");
            return false;
        }
        if (strlen(trim($this->name)) === 0){
            session_management::set("error","please insert username!!");
            return false;
        }
        if (strlen(trim($this->pass)) === 0){
            session_management::set("error","please insert Password!!");
            return false;
        }
        return true;
    }

    public function signin(){
        $pass = sha1($this->pass);

        $query = "SELECT * FROM members WHERE username='$this->name' AND passwoard='$pass'";
        $data =  DbConncetion::setDbConncetion()->query($query);
        $count = mysqli_num_rows($data);

        if($count == 1){
            session_management::set(Session_variable_for_username,$this->name);
            return true;
        }
        session_management::set("error","Username or Password not Matched!!");
        return false;

    }
}