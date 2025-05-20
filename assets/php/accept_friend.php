<?php
    // Betölti az adatbázis kapcsolatot biztosító fájlt
    require "db.php";

    // Ellenőrzi, hogy a 'id' cookie be van-e állítva, ha nem, átirányít a kezdőlapra
    if (!isset($_COOKIE['id'])) {
        header("Location: ../../index.php");
    }

    // Lekéri a saját felhasználói azonosítót a cookie-ból
    $myid = $_COOKIE['id'];
    // Lekéri a barátkérelem küldőjének azonosítóját a POST adatokból
    $fromid = $_POST['fromid'];

    // Frissíti az 'friends' táblát: elfogadja a barátkérést (status = 1), ahol a küldő és fogadó azonosító egyezik
    $conn->query("UPDATE friends SET status = 1 WHERE fromid = $fromid AND toid = $myid");

    // Átirányít az értesítések oldalra
    header("Location: ../../notify.php");

?>