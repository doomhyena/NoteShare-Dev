<!DOCTYPE html>
<html>
   <head>
       <title>Profilom</title>
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
        <?php
            require "cfg.php";
            session_start();

            $userid = $_COOKIE['id'];
            $sql = "SELECT * FROM users WHERE id='$userid'";
            $found_user = $conn->query($sql);
            $user = $found_user->fetch_assoc();
            
            echo "<h2>Profilod</h2>";
            echo "<p>Név: " . htmlspecialchars($user['firstname']) . " " . htmlspecialchars($user['lastname']) . "</p>";
            echo "<p>Felhasználónév: " . htmlspecialchars($user['username']) . "</p>";
        ?>
   <script src="assets/js/script.js"></script>
   </body>
</html>