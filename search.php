<?php 

	require "assets/php/cfg.php";
	
    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    $sql = "SELECT * FROM notifys WHERE ertesitettid=$id AND olvasott='nem'";
    $founded_notify = $conn->query($sql);
    $notify_number = mysqli_num_rows($founded_notify);  
?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Keresés</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <script src="http://code.jquery.com/jquery-latest.js"></script>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel="stylesheet" href="assets/css/style.css">
   </head>
   <body>
   <nav>
        <ul>
            <li><a href="index.php">Főoldal</a></li>
			<li><a href="upload.php">Feltöltés</a></li>
            <li><a href="profile.php">Profilom</a></li>
            <li><a href="search.php">Keresés</a></li>
            <?php
                echo "<li><a href='notify.php'>Értesítések ($ertesitesek_szama)</a>/li>";
                if ($user['admin'] == 1) {
                    echo '<li><a href="roles/admin/admin.php">Admin</a></li>';
                }
            ?>
            <?php
                if ($user['teacher'] == 1) {
                    echo '<li><a href="roles/teacher/teacher.php">Admin</a></li>';
                }
                
            ?>
            <li><a href="roles/students/students.php">Diák felület</a></li>
            <li><a href="roles/students/students.php">Diák felület</a></li>
            <li><a href="logout.php">Kijelentkezés</a></li>
        </ul>
    </nav>
    <h1>Keresés</h1>
    <input type="text" class="search-box" id="search-box" placeholder="Anyag keresése...">
	<div id="curriculum"></div>
    <script src="assets/js/script.js"></script>
   </body>
</html>