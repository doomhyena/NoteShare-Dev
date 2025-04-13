<?php

    require "cfg.php";
    session_start();
    
    if(!isset($_COOKIE['id'])){
        header("Location: ../../index.php");
    }
    
    if(isset($_POST['removeadmin-btn'])){
        
        $username = $_POST['username'];
        $sql = "SELECT * FROM users WHERE username='$username'";
        $found_user = $conn->query($sql);
        $found_user_count = mysqli_num_rows($found_user);
        
        if($found_user_count == 1){
            echo "<script>alert('Nincs ilyen felhasználó!')</script>";
        } else {
            if ($user['admin'] == 0) {
                echo "<script>alert('A felhasználó már admin!')</script>";
            } else {
                $sql = "UPDATE users SET admin=0 WHERE username='$username'";
                $conn->query($sql);
                echo "<script>alert('Admin hozzáadva!')</script>";
                header("Location: ../../admin.php");
            }
        }
    }

?>