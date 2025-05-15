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
        <?php
            include 'assets/php/navbar.php';
        
            echo"<h2>".$user['firstname'] ." profilja:</h2>";
            $folder = getcwd();

            if (!empty($user['profile_picture'])) {
                $profile_picture_path = "users/".$user['username']."/".$user['profile_picture'];
            } else {
                $profile_picture_path = "assets/img/default_profile_picture.jpg";
            }

            echo "<img src='".$profile_picture_path."' alt='Profilkép'>";

            if($_GET['userid'] == $_COOKIE['id']) {
                echo "<form method='POST' enctype='multipart/form-data'>
                    <label for='profile_picture'>Profilkép feltöltése:</label>
                    <input type='file' name='profile_picture' id='profile_picture' accept='image/*'>
                    <input type='submit' name='pfp-btn' value='Feltöltés!'>
                    </form>";
            }
            
            echo "<p>Név: " .$user['firstname']. " " . $user['lastname']. "</p>";
            echo "<p>Felhasználónév: " .$user['username']. "</p>";

            if ($_GET['userid'] != $_COOKIE['id']) {
                $toid = intval($_GET['userid']);
                echo "<form method='post' action='assets/php/add_friend.php'>
                    <input type='hidden' name='toid' value='" . $_GET['userid'] . "'>
                    <input type='submit' value='Barátnak jelölés'>
                </form>";
            }            
            $sql = "SELECT * FROM files WHERE uploaded_by='$user[id]' ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($file = $result->fetch_assoc()) {
                    if ($file['uploaded_by'] == $user['id']) {
                        echo "<div>";
                        if (!empty($file)) {
                            $folder = getcwd();
                            $uploader_id = $file['uploaded_by'];
                            $uploader_query = $conn->query("SELECT username FROM users WHERE id='$uploader_id'");
                            $uploader = $uploader_query->fetch_assoc();
                            echo "<div>";
                            echo "<h4>" . $file['name'] . "</h4>";
                            echo "<p><b>Tárgy:</b> " . $file['subject'] . "</p>";
                            echo "<p>" . $file['description'] . "</p>";
                            $file_extension = pathinfo($file['file_name'], PATHINFO_EXTENSION);
                            if ($file_extension === 'docx') {
                                echo "<p><b>Ez egy .docx fájl. A megtekintéshez töltsd le és nyisd meg Microsoft Word-ben.</b></p>";
                            } elseif ($file_extension === 'mp4') {
                                echo "<video controls>
                                        <source src='users/" . $uploader['username'] . "/" . $file['file_name'] . "' type='video/mp4'>
                                        A te böngésződ nem támogatja a videocímkét.
                                      </video>";
                            } elseif ($file_extension === 'pdf') {
                                echo "<iframe src='users/" . $uploader['username'] . "/" . $file['file_name'] . "' width='100%' height='500px'></iframe>";
                            }

                            echo "<a href='assets/php/download.php?id=" . $file['id'] . "'>Letöltés</a>";
                            echo "</div>";
                            echo "<p><b>Címkék:</b> " . $file['tags'] . "</p>";
                            if ($_COOKIE['id'] == $file['uploaded_by']) {
                                echo "<form method='POST' action='assets/php/delete.php'>";
                                echo "<input type='hidden' name='file_id' value='" . $file['id'] . "'>";
                                echo "<button type='submit'>Törlés</button>";
                                echo "</form>";
                            }
                        } else {
                            echo "<p>Nem található a fájl!</p>";
                        }
                        echo "</div>";
                    }
                }
            } else {
                echo "<p>Nincsenek feltöltött fájlok.</p>";
            }
        ?>
        <?php
            include 'assets/php/footer.php';
        ?>
        <script src="assets/js/script.js"></script>
   </body>
</html>