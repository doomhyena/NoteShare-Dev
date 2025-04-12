<?php

    require "../../assets/php/cfg.php";
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

        if(!password_verify($password, $user['password'])){
            echo "<script>alert('Nincs jogosultságod admin hozzáadására!')</script>";
        } else {
            $sql = "SELECT * FROM users WHERE username='$username'";
            $found_user = $conn->query($sql);
            
            if(mysqli_num_rows($found_user) == 0){
                echo "<script>alert('Nincs ilyen felhasználó!')</script>";
            } else {
                $user_data = $found_user->fetch_assoc();

                if ($user_data['admin'] == 1) {
                    echo "<script>alert('A felhasználó már admin!')</script>";
                } else {
                    $sql = "UPDATE users SET admin=1 WHERE username='$username'";
                    echo "<script>alert('Admin hozzáadva!')</script>";
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Admin oldal</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>
   <nav>
        <ul>
            <li><a href="index.php">Főoldal</a></li>
			<li><a href="upload.php">Feltöltés</a></li>
            <li><a href="myprofile.php">Profilom</a></li>
            <li><a href="search.php">Keresés</a></li>
            <?php
                if ($user['admin'] == 1) {
                    echo '<li><a href="roles/admin/admin.php">Admin</a></li>';
                }
            ?>
            <?php
                if ($user['teacher'] == 1) {
                    echo '<li><a href="roles/teacher/teacher.php">Admin</a></li>';
                }
            ?>
            <li><a href="logout.php">Kijelentkezés</a></li>
        </ul>
    </nav>
        <h1>Admin hozzáadása</h1>
        <form method="post">
             <label for="username">Felhasználónév:</label><br>
             <input type="text" id="username" name="username"><br><br>
             <label for="password">Jelszó:</label><br>
             <input type="password" id="password" name="password"><br><br>
             <input type="submit" name="addadmin-btn" value="Admin hozzáadása">
        </form>
        <p><a href="../../index.php">Vissza a főoldalra</a></p>
    <script src='assets/js/script.js'></script>
   </body>
</html>