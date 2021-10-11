<?php
namespace lib\fileManagent;

use lib\database\DbConncetion;
use lib\session\session_management;

include_once ( __DIR__."../../../config.php");
include_once Base_url."/lib/session/session_management.php";
include_once Base_url."/lib/database/DbConncetion.php";

class fileHandler{

    private $category , $fileName , $tempName , $uploadLocation;

    public function __construct(){
        session_management::init();
    }
    public function varification($request): bool
    {
        if ( $request['category'] == ""  || $_FILES['fileup']['size'] == 0){
            session_management::set("error","Fill the form first!!");
            return false;
        }

        if ($_FILES['fileup']['size'] > ( Max_file_size * 1024 * 1024)) {
            session_management::set("error","file size must be less then ". Max_file_size . " Mb") ;
            return false;
        }

        return true;
    }

    private function init($request){
        $this->category = $request['category'];
        $this->fileName = $_FILES["fileup"]["name"];
        $this->tempName = $_FILES["fileup"]["tmp_name"];
        $this->uploadLocation = "file/".$this->fileName;
    }


    public function store($request): bool
    {
        $this->init($request);

        $user = session_management::get(Session_variable_for_username);

        move_uploaded_file($this->tempName, $this->uploadLocation);
        date_default_timezone_set("Asia/dhaka");
        $format="%d/%m/%Y %H:%M:%S";
        $time=strftime($format);

        $query = "INSERT INTO file_collection VALUES (NULL, '$this->fileName','$this->uploadLocation','$user','$this->category','$time')";
        $data =  DbConncetion::setDbConncetion()->query($query);

        if ($data){
            return true;
        }else{
            session_management::set("error","Something went wrong!!");
            return false;
        }
    }

    public function deleteFile($id){

        $query = "SELECT fileloc FROM file_collection WHERE id='$id'";
        $result =  DbConncetion::setDbConncetion()->query($query);
        $file = mysqli_fetch_assoc($result);
        unlink($file['fileloc']);

        $query = "DELETE FROM file_collection WHERE id='$id'";
        $output = DbConncetion::setDbConncetion()->query($query);

        if ($output){
            return true;
        }else{
            return false;
        }
    }


}