<?php
    require 'cfg.php';

    if (!isset($_COOKIE['id'])) {
        header("Location: ../../index.php");
    }

    $myid = $_COOKIE['id'];
    $fromid = $_POST['fromid'];

    $conn->query("UPDATE friends SET status = 1 WHERE fromid = $fromid AND toid = $myid");


    header("Location: ../../notify.php");

?>