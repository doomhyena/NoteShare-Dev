<?php
    require "cfg.php";    

    $sql = "SELECT * FROM users WHERE id = ?";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    if (isset($_GET['id'])) {
        $file_id = intval($_GET['id']);
        $sql = "SELECT * FROM files WHERE id = ?";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $file = $result->fetch_assoc();
            $file_name = $file['file_name'];
            $folder = getcwd();
            $path = $folder . \\ . "users" . DIRECTORY_SEPARATOR . $user['username'] . DIRECTORY_SEPARATOR . $file_name;

            if (file_exists($path)) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . basename($path) . '"');
                readfile($path);
                exit;
            } else {
                echo "<script>alert('A fájl nem található!');</script>";
            }
        } else {
            echo "<script>alert('A fájl nem található!');</script>";
        }
    } else {
        echo "Nincs fájl kiválasztva.";
    }
?>
