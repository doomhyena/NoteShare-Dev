<!DOCTYPE html>
<html>
   <head>
       <title>Fájlaim</title>
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
            <li><a href="myfiles.php">Saját fájlok</a></li>
            <li><a href="myprofile.php">Profil</a></li>
            <li><a href="logout.php">Kijelentkezés</a></li>
        </ul>
      </nav>
      <div>
            <h2>Saját fájlok</h2>
            <?php
                 require "cfg.php";
                 session_start();

                 $userid = $_COOKIE['id'];
                 $sql = "SELECT * FROM files WHERE userid='$userid' ORDER BY id DESC";
                 $result = $conn->query($sql);
     
                 if ($result->num_rows > 0) {
                  while ($file = $result->fetch_assoc()) {
                        echo "<div>";
                        echo "<h4>" . htmlspecialchars($file['name']) . "</h4>";
                        if (pathinfo($file['name'], PATHINFO_EXTENSION) === 'pdf') {
                            echo "<iframe src='assets/users/".$user['username']."/".$file['name']."' width='600' height='400'></iframe>";
                        }
                        echo "<a href='download.php?id=" . $file['id'] . "'>Letöltés</a>";
                        echo "<a href='delete.php?id=" . $file['id'] . "'>Törlés</a>";
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