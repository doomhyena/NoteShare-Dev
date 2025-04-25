<?php
    require "cfg.php";
    
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    if (isset($_GET['id'])) {
        $file_id = $_GET['id'];
        $sql = "SELECT * FROM files WHERE id='$file_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $file = $result->fetch_assoc();
            $file_name = $file['file_name'];
            $folder = getcwd();
            $path = $folder."\\users\\".$user['username']."\\".$file_name;

            if (file_exists($path)) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . basename($path) . '"');
                readfile($path);
            }
        } else {
            echo "A fájl nem található.";
        }
    } else {
        echo "Nincs fájl kiválasztva.";
    }
?>
