<?php
namespace lib\userManagement;
use lib\database\DbConncetion;
use lib\session\session_management;

include_once ( __DIR__."../../../config.php");
include_once Base_url."/lib/session/session_management.php";
include_once Base_url."/lib/database/DbConncetion.php";

class userManagement{
    public static function userInfo(){
        session_management::init();
       $user = session_management::check(Session_variable_for_username);
       if($user){
          return self::getUserInfo();
       }else{
           header("location:signin.php");
       }
    }

    public static function Authcheck(){
        session_management::init();
        $user = session_management::check(Session_variable_for_username);
        if($user){
            header("location:index.php");
        }else{
           return;
        }
    }
    private static function setUsername(){
        session_management::init();
        return session_management::get(Session_variable_for_username);
    }
    public static function getUserInfo(){
        $username= self::setUsername();
        $query = "SELECT * from members where username='$username'";
        $data =  DbConncetion::setDbConncetion()->query($query);
        return  mysqli_fetch_assoc($data);
    }

    public static function userFileCount(){
        $username = self::setUsername();

        $query = "SELECT * from file_collection where username='$username'";
        $data =  DbConncetion::setDbConncetion()->query($query);
        return mysqli_num_rows($data);
    }

    public static function getUserFile($this_page_first_result){
        $username = self::setUsername();
        $query = "select * from file_collection where username='$username' order by id desc
            limit ".$this_page_first_result .",".result_per_page;

        return DbConncetion::setDbConncetion()->query($query);
    }

    public static function changeUserPass($request): bool
    {
        $userInfo = self::getUserInfo();
        $user = $userInfo['username'];
        if ( strlen(trim($request['pass'])) === 0 || strlen(trim($request['rpass'])) === 0 || strlen(trim($request['oldpass'])) === 0 ){
            session_management::set("error","Please Fill the form!!");
            return false;
        }

        $pass = sha1($request['pass']);
        $rpass = sha1($request['rpass']);
        $oldPass = sha1($request['oldpass']);

        if ($oldPass != $userInfo['passwoard']){
            session_management::set("error","Current Password not Matched!!");
            return false;
        }
        if (strlen(trim($request['rpass'])) < min_pass_length){
            session_management::set("error","Password minimum 8 character required!!");
            return false;
        }
        if ($request['rpass']  !== $request['pass']){
            session_management::set("error","Password and Repeat Password not matched!!");
            return false;
        }

        $query="UPDATE members SET passwoard='$pass' WHERE username='$user'";
        $check = DbConncetion::setDbConncetion()->query($query);
        if ($check){
            return true;
        }else{
            session_management::set("error","Something went wrong!!");
            return false;
        }

    }

    public static function deleteUser(){
        $userInfo = self::getUserInfo();
        $userName = $userInfo['username'];
        $query ="SELECT * FROM  file_collection WHERE username='$userName'";
        $files = DbConncetion::setDbConncetion()->query($query);
        while ($file=mysqli_fetch_assoc($files)) {
            unlink($file['fileloc']);
        }
        $sql = "DELETE FROM file_collection WHERE username='$userName'";
        $result = DbConncetion::setDbConncetion()->query($sql);

        if ($userInfo['propic'] != "propic/female.png" && $userInfo['propic'] != "propic/male.png") {
            unlink($userInfo['propic']);
        }

        $profileDelete = "DELETE FROM  members WHERE username='$userName'";
        DbConncetion::setDbConncetion()->query($profileDelete);
        session_management::destroy();
        return true;
    }

    public static function updateProfilePicture($request){

        if ( $_FILES['fileup']['size'] == 0){
            session_management::set("error","Select the image!!");
            return false;
        }

        $userInfo = self::getUserInfo();
        $userName = $userInfo['username'];
        $ImageName = $_FILES["fileup"]["name"];

        if ( $userInfo['propic'] != "propic/female.png" && $userInfo['propic'] != "propic/male.png" ) {
            unlink($userInfo['propic']);
        }
        $tempName = $_FILES["fileup"]["tmp_name"];
        $location = "propic/".$ImageName;

        move_uploaded_file($tempName, $location);

        $query = "UPDATE members SET propic='$location' WHERE username='$userName'";
        DbConncetion::setDbConncetion()->query($query);

        return true;
    }

    public static function forgetPassword($request):bool
    {
        session_management::init();
        if( $request['uname'] == "" && $request['pass'] == "" && $request['rpass'] == '' && $request['security'] == '' ){
            session_management::set("error","Fill the form first!!");
            return false;
        }
        if (strlen(trim($request['pass'])) < min_pass_length){
            session_management::set("error","Password minimum 8 character required!!");
            return false;
        }

        if ( $request['security'] != $request['ans']){
            session_management::set("error","security answer not match!!");
            return false;
        }

        if ( $request['pass'] !=  $request['rpass']){
            session_management::set("error","Password not matched with repeat password!!");
            return false;
        }

        $username = $request['uname'];
        $email =  $request['email'];
        $pass = sha1($request['pass']);

        $query = "SELECT * FROM members WHERE username='$username' AND email='$email'";
        $result = DbConncetion::setDbConncetion()->query($query);
        $count = mysqli_num_rows($result);

        if ( $count != 1 ){
            session_management::set("error","User not found try again!!");
            return false;
        }

        $sql = "UPDATE members SET passwoard='$pass'";
        $result = DbConncetion::setDbConncetion()->query($sql);
        return true;
    }

}