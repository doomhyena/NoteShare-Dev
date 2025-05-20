<?php
    require  "assets/php/db.php"; // Betölti az adatbázis kapcsolatot létrehozó fájlt

    if(!isset($_COOKIE['id'])){ // Ellenőrzi, hogy létezik-e 'id' nevű süti (cookie)
        header("Location: index.php"); // Ha nincs, átirányítja a felhasználót a főoldalra
    }

    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'"; // Lekérdezi az adatbázisból azt a felhasználót, akinek az id-je megegyezik a sütiben tárolttal
    $found_user = $conn->query($sql); // Lefuttatja a lekérdezést
    $user = $found_user->fetch_assoc(); // Az eredményt asszociatív tömbbé alakítja

    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0"; // Lekérdezi azokat az értesítéseket, amelyek a bejelentkezett felhasználónak szólnak és még nem olvasta őket
    $founded_notify = $conn->query($sql); // Lefuttatja a lekérdezést
    $notify_number = mysqli_num_rows($founded_notify); // Megszámolja, hány olvasatlan értesítés van
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