<?php
    // Létrehoz egy új MySQLi kapcsolatot a "noteshare" adatbázishoz a localhost-on, root felhasználóval, jelszó nélkül
    $conn = new mysqli("localhost", "root", "", "noteshare");

    // Ellenőrzi, hogy a kapcsolat létrejött-e, ha nem, akkor leállítja a futást és kiírja a hibaüzenetet
    if($conn->connect_error){
        die("Connection failed! ".$conn->connect_error);
    }
?>