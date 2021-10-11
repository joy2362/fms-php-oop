<?php

use lib\fileManagent\fileHandler;
use lib\login\LoginHandler;
use lib\registation\userRegistation;
use lib\userManagement\userManagement;

include_once (__DIR__. "/lib/login/loginHandler.php");
include_once (__DIR__. "/lib/registation/userRegistation.php");
include_once (__DIR__. "/lib/fileManagement/fileHandler.php");
include_once (__DIR__. "/lib/userManagement/userManagement.php");

//handle login form
if (isset( $_POST['signin'])){

    $login = new LoginHandler($_POST['uname'],$_POST['pass']);

    if (!$login->varification()){
        header('location:signin.php');
        return;
    }

    if ( !$login->signin()){
        header('location:signin.php');
    }else{
        header('location:index.php');
    }
}

//handle registration form
if (isset($_POST['signup'])){
    $registration = new userRegistation($_POST);

    if ( !$registration->varification() ){
        header('location:signup.php');
        return;
    }

    if ( !$registration->registationHandler() ){
        header('location:signup.php');
    }else{
        header('location:signin.php');
    }

}

//store user file
if (isset($_POST['upload'])){
    $fileUpload = new fileHandler();

    if ( !$fileUpload->varification($_POST) ){
        header('location:upload.php');
        return;
    }

    if ( !$fileUpload->store($_POST) ){
        header('location:upload.php');
    }else{
        header('location:index.php');
    }
}

//change password
if (isset($_POST['changePass'])){
    if(!userManagement::changeUserPass($_POST)){
        header("location:change.php");
    }else{
        header('location:index.php');
    }
    return;
}

//change profile image
if (isset($_POST['changeprofileImage'])){
    if ( !userManagement::updateProfilePicture($_POST)){
        header("location:change_propic.php");
        return;
    }
    header('location:index.php');
}

//forget pass
if (isset($_POST['forgetPass'])){

    if ( !userManagement::forgetPassword($_POST)){
        header("location:forget_pass.php");
        return;
    }

    header('location:signin.php');
}

