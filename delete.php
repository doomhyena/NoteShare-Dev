<?php

        require "cfg.php";
        session_start();

        $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
        $found_user = $conn->query($sql);
        $user = $found_user->fetch_assoc();
    
        if (isset($_GET['id'])) {}
            $file_id = $_GET['id'];
            $sql = "SELECT * FROM files WHERE id='$file_id'";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {

                $file = $result->fetch_assoc();
                $file_name = $file['file_name'];
                $folder = getcwd();
                $path = $folder . "\\assets\\users\\" . $user['username'] . "\\" . $file_name;
                $sql = "DELETE FROM files WHERE id='$file_id'";
                $conn->query($sql);
    
                if (file_exists($path)) {
                    unlink($path);
                    unlink($tn_path);
                    header('Location: myprofile.php');
                } else {
                    echo "A fájl nem található.";
                }
            } else {
            echo "Nincs fájl kiválasztva.";
        }
?>