<?php

use lib\userManagement\userManagement;

include_once (__DIR__. "/lib/userManagement/userManagement.php");

userManagement::deleteUser();
header('location:signin.php');
return;