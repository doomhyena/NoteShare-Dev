<?php
    require "cfg.php";    

    if (isset($_COOKIE['id']) && is_numeric($_COOKIE['id'])) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $_COOKIE['id']);
        $stmt->execute();
        $found_user = $stmt->get_result();
        $user = $found_user->fetch_assoc();
        if (is_numeric($file_id)) {
            $stmt = $conn->prepare("SELECT * FROM files WHERE id = ?");
            $stmt->bind_param("i", $file_id);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $path = $folder."\\assets\\users\\".$user['username']."\\".$file_name;
        }
        echo "<script>alert('Nincs ilyen userID!');</script>";
    }

    if (isset($_GET['id'])) {


        if ($result->num_rows > 0) {
            $file = $result->fetch_assoc();
            $file_name = $file['file_name'];
            $folder = getcwd();
            $path = $folder."\\assets\\users\\".$user['username']."\\".$file_name;

            if (file_exists($path)) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . basename($path) . '"');
                readfile($path);
            }
        } else {
            echo "<script>alert('A fájl nem található!');</script>";
        }
    } else {
        echo "<script>alert('Nincs fájl kiválasztva!');</script>";
    }
?>
