<?php
    require 'cfg.php';

    if (!isset($_COOKIE['id']) || !isset($_POST['toid'])) {
        header("Location: ../../index.php");
        exit;
    }

    $fromid = intval($_COOKIE['id']);
    $toid = intval($_POST['toid']);

    $user_check = $conn->query("SELECT id FROM users WHERE id = $toid");
    if ($user_check->num_rows === 0) {
        die("Hiba: a felhasználó (toid=$toid) nem létezik.");
    }

    $check = $conn->query("SELECT * FROM friends WHERE (fromid=$fromid AND toid=$toid) OR (fromid=$toid AND toid=$fromid)");
    if ($check->num_rows === 0) {
        $conn->query("INSERT INTO friends (fromid, toid, status) VALUES ($fromid, $toid, 0)");
        $conn->query("INSERT INTO notifys (fromid, toid, notifytype, readed) VALUES ($fromid, $toid, 'friend', 0)");
    }

    header("Location: ../../profile.php?userid=$toid");
?>
