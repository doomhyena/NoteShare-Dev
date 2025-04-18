<?php

    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_user = getenv('DB_USER');
    $db_pass = getenv('DB_PASS');
    $conn = new mysqli("localhost", "root", "", "noteshare");

    if($conn->connect_error){
    die("Connection failed! ".$conn->connect_error);
    }

?>