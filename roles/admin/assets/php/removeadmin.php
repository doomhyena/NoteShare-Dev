<?php

    require "../NoteShare/assets/php/cfg.php";
    session_start();
    
    if(!isset($_COOKIE['id'])){
        header("Location: ../../index.php");
    }
    
    if(isset($_POST['addadmin-btn'])){
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM users WHERE id='$_COOKIE[id]";
        $found_user = $conn->query($sql);
        $user = $found_user->fetch_assoc();
        $sql = "SELECT * FROM users WHERE username='$username'";
        $found_user = $conn->query($sql);
            
        if(mysqli_num_rows($found_user) == 0){
            echo "<script>alert('Nincs ilyen felhasználó!')</script>";
        } else {
            $user_data = $found_user->fetch_assoc();
            if ($user_data['admin'] == 0) {
                echo "<script>alert('A felhasználó nem admin!')</script>";
            } else {
                $sql = "UPDATE users SET admin=0 WHERE username='$username'";
                echo "<script>alert('Admin eltávolítva!')</script>";
            }
        }
    }

?>