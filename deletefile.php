<?php

use lib\fileManagent\fileHandler;

include_once (__DIR__. "/lib/fileManagement/fileHandler.php");

	if (isset($_REQUEST['id'])) {
        $file = new fileHandler();
        $file->deleteFile($_REQUEST['id']);
    }
    header('location:index.php');
