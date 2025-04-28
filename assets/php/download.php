<?php
    require "cfg.php";

    $file_id = intval($_GET['id']);
    $sql = "SELECT * FROM files WHERE id=$file_id";
    $file_result = $conn->query($sql);

    if ($file_result->num_rows > 0) {
        $file = $file_result->fetch_assoc();
        
        $sql = "SELECT * FROM users WHERE id=" . intval($file['uploaded_by']);
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        
        $folder = dirname(getcwd(), 2); 
        $path = $folder . "/users/" . $user['username'] . "/" . $file['file_name'];
        
        if (file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        } else {
            echo "A fájl nem található: $path";
        }
    } else {
        echo "Nincs fájl kiválasztva.";
    }
?>
