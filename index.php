<?php
    require "assets/php/cfg.php";
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
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
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
    <div>
        <?php
            echo "<h1>Üdv ". $user['firstname'] ." a NoteShare oldalán!</h1>";
            echo "<h2>Itt megoszthatod és letöltheted az iskolai jegyzeteket.</h2>";
            echo "<h3>Feltöltött fájlok:</h3>";

            $sql = "SELECT * FROM files WHERE userid='$user[id]' ORDER BY id DESC";
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
                    echo "<p>Feltöltötte: <a href='profile.php?id=" . $user['id'] . "'>" . $user['username'] . "</a></p>";
                    if ($user['admin'] == 1) {
                        echo "<form method='POST' action='assets/php/delete.php'>";
                        echo "<input type='hidden' name='file_id' value='" . $file['id'] . "'>";
                        echo "<button type='submit'>Törlés</button>";
                        echo "</form>";
                    }
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