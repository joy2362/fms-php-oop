<?php

namespace lib\registation;
use lib\database\DbConncetion;
use lib\session\session_management;

include_once ( __DIR__."../../../config.php");
include_once Base_url."/lib/session/session_management.php";
include_once Base_url."/lib/database/DbConncetion.php";

class userRegistation{

    private $userName,$pass,$fullName,$email,$gender,$fileName, $repeatPassword;

    public function __construct($request){
        $this->userName = $request["uname"];
        $this->fullName = $request['fname'];
        $this->email = $request['email'];
        $this->pass = $request['pass'];
        $this->repeatPassword = $request['rpass'];
        $this->gender = $request['gender'];
        $this->fileName = $_FILES["upic"]["name"];
        session_management::init();
    }

    public function varification(){
        if (strlen(trim($this->userName)) === 0 or strlen(trim($this->pass)) === 0 or
            strlen(trim($this->fullName)) === 0 or strlen(trim($this->email)) === 0 or
            strlen(trim($this->repeatPassword)) === 0 or  strlen(trim($this->gender)) === 0
        ){
            session_management::set("error","Please Fill the form!!");
            return false;
        }

        if (strlen(trim($this->userName)) < min_user_name_length){
            session_management::set("error","Username minimum 4 character required!!");
            return false;
        }

        if (strlen(trim($this->pass)) < min_pass_length){
            session_management::set("error","Password minimum 8 character required!!");
            return false;
        }
        if ($this->pass  !== $this->repeatPassword){
            session_management::set("error","Password and Repeat Password not matched!!");
            return false;
        }

        $query = "SELECT * FROM members WHERE username='$this->username'";
        $result = DbConncetion::setDbConncetion()->query($query);
        $count = mysqli_num_rows($result);

        if ( $count == 1){
            session_management::set("error","Username already taken!!");
            return false;
        }
        $sql = "SELECT * FROM members WHERE email='$this->email'";
        $result = DbConncetion::setDbConncetion()->query($sql);
        $count = mysqli_num_rows($result);

        if ( $count == 1){
            session_management::set("error","email already taken!!");
            return false;
        }

        return true;
    }

    public function registationHandler(){
        $pass = sha1($this->pass);

        if ($this->fileName == "") {
			if ($this->gender == "male") {
				$userPicture = default_male_image;
			}else{
                $userPicture = default_female_image;
			}
		}else{
			$temp_name= $_FILES["upic"]["tmp_name"];
            $userPicture = "propic/".$this->fileName;
			move_uploaded_file($temp_name,$userPicture);
		}

        $query="INSERT INTO members VALUES (NULL ,'$this->userName','$this->fullName', '$this->email', '$pass','$userPicture','$this->gender')";
        $result = DbConncetion::setDbConncetion()->query($query);

        if($result){
            return true;
        }else{
            $_SESSION['error'] = "Username or Password not Matched";
           return false;
        }
    }

}