<?php

use lib\session\session_management;

include_once (__DIR__. "/lib/session/session_management.php");

session_management::init();
session_management::destroy();
header('location:signin.php')
?>