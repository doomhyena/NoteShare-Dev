<?php
    require "assets/php/cfg.php";
    session_start();

    $sql = "SELECT * FROM users WHERE id='" .$_GET['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    $folder = getcwd();
    $target_dir = $folder."\\roles\\users\\".$user['username']."\\";
    $file_name = isset($_FILES['profile_picture']['name']) ? $_FILES['profile_picture']['name'] : '';
    $tmp_name = isset($_FILES['profile_picture']['tmp_name']) ? $_FILES['profile_picture']['tmp_name'] : '';
    $target_file = $target_dir . $file_name;

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
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>
   <nav>
        <ul>
            <li><a href="index.php">Főoldal</a></li>
			<li><a href="upload.php">Feltöltés</a></li>
            <li><a href="myprofile.php">Profilom</a></li>
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
    <?php
    
        echo"<h2>".$user['firstname'] ." profilja:</h2>";
        $folder = getcwd();
        $profile_picture_path = "roles/users/".$user['username']."/".$user['profile_picture'];

            if (!empty($user['profile_picture'])) {
                echo "<img src='".$profile_picture_path."' alt='Profilkép'>";
            } else {
                echo "<p>Nincs profilkép feltöltve.</p>";
            }
            
        echo "<p>Név: " .$user['firstname']. " " . $user['lastname']. "</p>";
        echo "<p>Felhasználónév: " .$user['username']. "</p>";
        echo "<h3>Feltöltött fájlok:</h3>";
        $sql = "SELECT * FROM files WHERE userid=".$_GET['id'] ." ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($file = $result->fetch_assoc()) {
                echo "<div>";
                if(!empty($file)) {
                    $folder = getcwd();
                    echo "<div>";
                    echo "<h4>" .$file['name']. "</h4>";
                    echo "<iframe src='roles/users/".$user['username']."/".$file['tn_name']."' width='600' height='400'></iframe>";
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