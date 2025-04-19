<?php 

    require  dirname(__FILE__)."/assets/php/cfg.php";
	
    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }

    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
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
            <?php
                echo '<li><a href="'.dirname(__FILE__).'/index.php">Főoldal</a></li>';
                echo '<li><a href="'.dirname(__FILE__).'/upload.php">Feltöltés</a></li> ';
                echo '<li><a href="'.dirname(__FILE__).'/profile.php">Profilom</a></li> ';
                echo '<li><a href="'.dirname(__FILE__).'/search.php">Keresés</a></li>';
                echo "<li><a href=".dirname(__FILE__)."/notify.php'>Értesítések ($ertesitesek_szama)</a></li>";
                $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
                $found_user = $conn->query($sql);
                $user = $found_user->fetch_assoc();

                if ($user['admin'] == 1) {
                    echo '<li><a href='.dirname(__FILE__).'/roles/admin/admin.php">Admin</a></li>';
                }
                if ($user['teacher'] == 1) {
                    echo '<li><a href="'.dirname(__FILE__).'/roles/teacher/teacher.php">Tanári felület</a></li>';
                }
                echo '<li><a href="'.dirname(__FILE__).'/assets/php/logout.php">Kijelentkezés</a></li>';
            ?>
        </ul>
    </nav>
    <h1>Keresés</h1>
    <input type="text" class="search-box" id="search-box" placeholder="Keresés...">
	<div id="search"></div>
    <script src="assets/js/script.js"></script>
   </body>
</html>