<?php 

    require  "assets/php/db.php";
	
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
       <meta name='author' content='Bor Ádám, Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <script src="http://code.jquery.com/jquery-latest.js"></script>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel="stylesheet" href="assets/css/style.css">
   </head>
   <body>
        <?php
            include 'assets/php/navbar.php';
        ?>
        <h1>Keresés</h1>
        <input type="text" class="search-box" id="search-box" placeholder="Keresés...">
        <div id="search"></div>
        <?php
            include 'assets/php/footer.php';
        ?>
        <script src="assets/js/script.js"></script>
   </body>
</html>