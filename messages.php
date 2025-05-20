<?php 

    require  "assets/php/db.php";

    // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }
    // Bejelentkezett felhasználó adatai
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    // Ellenőrzi, hogy elküldték-e az üzenetküldő űrlapot
    if (isset($_POST['send_message'])) {
        // Lekéri a címzett felhasználó azonosítóját az űrlapból
        $toid = $_POST['toid'];
        // Hibás: itt a $_POST['message']-et query-vel próbálja lekérdezni, ami nem helyes
        $message = $_POST['message'];
        // Lekéri a feladó azonosítóját a cookie-ból
        $fromid = $_COOKIE['id'];
        
        // Létrehozza az SQL lekérdezést az üzenet beszúrásához
        $sql = "INSERT INTO messages (fromid, toid, content, sent_at) VALUES ($fromid, $toid, '$message', NOW())";
        
        // Végrehajtja az SQL lekérdezést, és ha sikeres, átirányít az üzenetek oldalra
        if ($conn->query($sql)) {
            header("Location: messages.php?friendid=$toid");
            exit;
        } else {
            // Hiba esetén hibaüzenetet ír ki
            echo "<p>Hiba történt az üzenet küldése közben.</p>";
        }
    }

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Üzenetek</title>
    <meta charset="UTF-8">
    <meta name="description" content="Iskolai jegyzeteket megosztó oldal">
    <meta name="keywords" content="iskola, jegyzet, megosztás, tanulás">
    <meta name='author' content='Bor Ádám, Csontos Kincső, Szekeres Levente'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php

        // Betölti a navigációs sávot tartalmazó fájlt
        include 'assets/php/navbar.php';

        // Lekérdezi az összes barátot, ahol a bejelentkezett felhasználó az egyik fél és a státusz 1 (barátok)
        $query = "SELECT * FROM friends WHERE (fromid=" . intval($_COOKIE['id']) . " AND status=1) OR (toid=" . intval($_COOKIE['id']) . " AND status=1)";
        $found_friends = $conn->query($query);

        // Végigmegy az összes megtalált barátságon
        while ($friendship = $found_friends->fetch_assoc()) {
            // Megállapítja, hogy a barátságban ki a másik fél (nem a bejelentkezett felhasználó)
            $friendid = ($friendship['fromid'] != $_COOKIE['id']) ? $friendship['fromid'] : $friendship['toid'];
            // Lekérdezi a másik fél (barát) adatait az adatbázisból
            $query = "SELECT * FROM users WHERE id=$friendid";
            $found_friend = $conn->query($query);
            $friend = $found_friend->fetch_assoc();
            // Kiírja a barát felhasználónevét, amelyre kattintva az üzenetküldő oldalra jutunk vele
            echo "<a href='messages.php?friendid=$friendid'>" . $friend['username'] . "</a><br>";
        }

        // Ellenőrzi, hogy a 'friendid' GET paraméter be van-e állítva
        if (isset($_GET['friendid'])) {
            // Lekéri a barát azonosítóját a GET paraméterből
            $friendid = $_GET['friendid'];
            // Lekérdezi a barát adatait az adatbázisból
            $query = "SELECT * FROM users WHERE id=$friendid";
            $found_friend = $conn->query($query);
            // Az eredményt asszociatív tömbbé alakítja
            $friend = $found_friend->fetch_assoc();
            // Kiírja a barát felhasználónevét egy <h2> elemben
            echo "<h2>" . $friend['username'] . "</h2>";
            // Megjelenít egy űrlapot, ahol üzenetet lehet írni a kiválasztott barátnak
            echo '
            <form method="post">
                <input type="hidden" name="toid" value="' . $friendid . '">
                <input type="text" name="message" placeholder="Írj egy üzenetet...">
                <input type="submit" name="send_message" value="Küldés">
            </form>
            ';
        } else {
            // Ha nincs kiválasztva barát ('friendid' nincs beállítva), akkor egy üzenetet jelenít meg
            echo "<p>Válassz egy barátot az üzenetküldéshez.</p>";
        }
        // Betölti a footer.php fájlt az oldal aljára
        include 'assets/php/footer.php';
    ?>
    <script src="assets/js/script.js"></script>
</body>
</html>