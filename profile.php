<?php

    require  "assets/php/cfg.php";

    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }

    $userid = $_GET['userid'];

    $sql = "SELECT * FROM users WHERE id='" .$userid. "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();
    $folder = getcwd();
    $target_dir = $folder."users\\".$user['username']."\\";
    $file_name = isset($_FILES['profile_picture']['name']) ? $_FILES['profile_picture']['name'] : '';
    $tmp_name = isset($_FILES['profile_picture']['tmp_name']) ? $_FILES['profile_picture']['tmp_name'] : '';
    $target_file = $target_dir . $file_name;

    if ($_GET['userid'] == $_COOKIE['id']) {
        $userid = $_COOKIE['id'];
        $sql = "SELECT * FROM users WHERE id='$userid'";
        $found_user = $conn->query($sql);
        $user = $found_user->fetch_assoc();
    
        if (isset($_POST['pfp-btn'])) {
            $folder = getcwd();
            $target_dir = $folder."users\\".$user['username']."\\";
            $file_name = $_FILES['profile_picture']['name'];
            $tmp_name = $_FILES['profile_picture']['tmp_name'];
            $target_file = $target_dir . $file_name;
    
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); 
            }
            if (move_uploaded_file($tmp_name, $target_file)) {
                $conn->query("UPDATE users SET profile_picture='$file_name' WHERE id='$userid'");
            } else {
                echo "<p>Hiba történt a fájl feltöltésekor.</p>";
            }
        }
    }

    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
    $founded_notify = $conn->query($sql);
    $notify_number = mysqli_num_rows($founded_notify); 

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Profil</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>
        <nav>
            <ul>
                <li><a href="index.php">Főoldal</a></li>
                <li><a href="upload.php">Feltöltés</a></li>
                <?php
                    echo "<li><a href='profile.php?userid=".$user['id']."'>Profilom</a></li>";
                ?>
                <li><a href="search.php">Keresés</a></li>
                <?php
                    
                    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
                    $founded_notify = $conn->query($sql);
                    $notify_number = mysqli_num_rows($founded_notify);

                    echo "<li><a href='notify.php'>Értesítések ($notify_number)</a></li>";
                    
                ?>
                <li><a href="messages.php">Üzenetek</a></li>
                <li><a href="assets/php/logout.php">Kijelentkezés</a></li>
            </ul>
        </nav>
        <?php
        
            echo"<h2>".$user['firstname'] ." profilja:</h2>";
            $folder = getcwd();
            $profile_picture_path = "users/".$user['username']."/".$user['profile_picture'];

                if (!empty($user['profile_picture'])) {
                    echo "<img src='".$profile_picture_path."' alt='Profilkép'>";
                } else {
                    echo "<p>Nincs profilkép feltöltve.</p>";
                }

                if($_GET['userid'] == $_COOKIE['id']) {
                    echo "<form method='POST' enctype='multipart/form-data'>
                        <label for='profile_picture'>Profilkép feltöltése:</label>
                        <input type='file' name='profile_picture' id='profile_picture' accept='image/*'>
                        <input type='submit' name='pfp-btn' value='Feltöltés!'>
                        </form>";
                }
            
            echo "<p>Név: " .$user['firstname']. " " . $user['lastname']. "</p>";
            echo "<p>Felhasználónév: " .$user['username']. "</p>";

            $sql = "SELECT * FROM files WHERE uploaded_by='$user[id]' ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
             while ($file = $result->fetch_assoc()) {
                   echo "<div>";
                   if(!empty($file)) {
                    $folder = getcwd();
                    echo "<div>";
                    echo "<h4>" .$file['name']. "</h4>";
                    echo "<p>" . $file['description'] . "</p>"; 
                    echo "<iframe src='users/".$user['username']."/".$file['file_name']."'></iframe>";
                    echo "<a href='assets/php/download.php?id=" . $file['id'] . "'>Letöltés</a>";
                    echo "</div>";
                } else {
                    echo "<p>Nem található a fájl!</p>";
                }
                   echo "</div>";
               }
            } else {
                echo "<p>Nincsenek feltöltött fájlok.</p>";
           }
        ?>
   </body>
</html>