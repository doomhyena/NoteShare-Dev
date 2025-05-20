<?php
    // db.php betöltése, amely az adatbázis kapcsolatot tartalmazza
    require "db.php";

    // Ellenőrzi, hogy a felhasználó be van-e jelentkezve (id süti) és hogy van-e cél felhasználó (toid POST)
    if (!isset($_COOKIE['id']) || !isset($_POST['toid'])) {
        // Ha nincs, visszairányít a főoldalra
        header("Location: ../../index.php");
        exit;
    }

    // Lekéri a bejelentkezett felhasználó id-ját és a cél felhasználó id-ját
    $fromid = $_COOKIE['id'];
    $toid = $_POST['toid'];

    // Ellenőrzi, hogy a cél felhasználó létezik-e az adatbázisban
    $user_check = $conn->query("SELECT id FROM users WHERE id = $toid");
    if ($user_check->num_rows === 0) {
        // Ha nem létezik, hibát ír ki és leállítja a futást
        die("Hiba: a felhasználó (toid=$toid) nem létezik.");
    }

    // Ellenőrzi, hogy már létezik-e barátság vagy barátfelkérés a két felhasználó között
    $check = $conn->query("SELECT * FROM friends WHERE (fromid=$fromid AND toid=$toid) OR (fromid=$toid AND toid=$fromid)");
    if ($check->num_rows === 0) {
        // Ha még nincs, létrehozza a barátfelkérést (status=0) és értesítést küld
        $conn->query("INSERT INTO friends (fromid, toid, status) VALUES ($fromid, $toid, 0)");
        $conn->query("INSERT INTO notifys (fromid, toid, notifytype, readed) VALUES ($fromid, $toid, 'friend', 0)");
    }

    // Átirányítja a felhasználót a cél felhasználó profiljára
    header("Location: ../../profile.php?userid=$toid");
?>