<?php

    $conn = new mysqli("localhost", "root", "", "noteshare");

    if($conn->connect_error){
    die("Connection failed! ".$conn->connect_error);
    }

?>