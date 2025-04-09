<?php

    require "cfg.php";
    session_start();

    if (!isset($_COOKIE['id'])) {
        header('Location: reg.php');
    }
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Főoldal</title>
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
            <li><a href="myprofile.php">Profil</a></li>
            <li><a href="logout.php">Kijelentkezés</a></li>
        </ul>
    </nav>
    <div>
        <?php
            echo "<h2>Üdv ". $user['firstname'] ." a NoteShare oldalán!</h2>";
        ?>
        <h2>Itt megoszthatod és letöltheted az iskolai jegyzeteket.</h2>
        <h3>Jegyzetek:</h3>
        <?php
            $sql = "SELECT * FROM files ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($file = $result->fetch_assoc()) {
                      echo "<div>";
                      if(!empty($file)) {
                       $folder = getcwd();
                       echo "<div>";
                       echo "<h4>" .$file['name']. "</h4>";
                       echo "<iframe src='assets/users/".$user['username']."/".$file['tn_name']."' width='600' height='400'></iframe>";
                       echo "<a href='download.php?id=" . $file['id'] . "'>Letöltés</a>";
                       echo "<a href='delete.php?id=" . $file['id'] . "'>Törlés</a>";
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
    </div>
    <script src="assets/js/script.js"></script>
   </body>
</html>