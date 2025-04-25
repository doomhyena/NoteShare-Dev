<?php
    require "cfg.php";

    if (isset($_GET['id'])) {
        $file_id = $_GET['id'];
        $sql = "SELECT * FROM files WHERE id='$file_id'";
        $file_result = $conn->query($sql);

        if ($file_result->num_rows > 0) {
            $sql = "SELECT * FROM users WHERE id=" . $file_result->fetch_assoc()['uploaded_by'];
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();

            $file = $file_result->fetch_assoc();
            $file_name = $file['file_name]; 
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
