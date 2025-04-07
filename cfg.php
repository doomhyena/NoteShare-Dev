<?php

    $conn = new mysqli("localhost", "root", "ujjelszo", "noteshare");

    if($conn->connect_error){
    die("Connection failed! ".$conn->connect_error);
    }

?>