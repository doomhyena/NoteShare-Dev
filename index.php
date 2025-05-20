<?php

    require "assets/php/db.php";

    // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
    if(!isset($_COOKIE['id'])){
        header("Location: reglog.php");
    }
    // Bejelentkezett felhasználó adatai
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    // Kommentek feldolgozása
    if(isset($_POST['comment-btn'])){
    
            $postid = $_GET['postid'];
            $text = $_POST['comment-text'];
            $conn->query("INSERT INTO comments (userid, postid, text) VALUES ('$user[id]', '$postid', '$text')");
            $uploader = $_GET['uploader'];
            $conn->query("INSERT INTO notifys (fromid, toid, notifytype, readed) VALUES ('$user[id]', '$uploader', 'comment', 0)");
        
    } else {
        echo "<script>alert('Hiba történt a komment írásakor!');</script>";
    }

    // Értékelés feldolgozása
    if (isset($_POST['rate-btn']) && isset($_POST['rate_file_id']) && isset($_POST['rating'])) {
        $file_id = intval($_POST['rate_file_id']);
        $rating = intval($_POST['rating']);
        $user_id = intval($user['id']);

        // Ellenőrizzük, hogy már értékelt-e
        $check_sql = "SELECT id FROM ratings WHERE file_id = $file_id AND user_id = $user_id";
        $check_result = $conn->query($check_sql);
        if ($check_result->num_rows > 0) {
            // Frissítjük a meglévő értékelést
            $update_sql = "UPDATE ratings SET rating = $rating WHERE file_id = $file_id AND user_id = $user_id";
            $conn->query($update_sql);
        } else {
            // Új értékelést adunk hozzá
            $insert_sql = "INSERT INTO ratings (file_id, user_id, rating) VALUES ($file_id, $user_id, $rating)";
            $conn->query($insert_sql);
        }
        // Frissítés, hogy azonnal látszódjon a változás
        echo "<meta http-equiv='refresh' content='0'>";
    }

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Főoldal</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Bor Ádám, Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>
    <?php
        include 'assets/php/navbar.php';
    ?>
    <div>
        <?php
            // Köszöntő üzenet a bejelentkezett felhasználónak
            echo "<h1>Üdv ". $user['firstname'] ." a NoteShare oldalán!</h1>";

            // Lekérdezi a mai dátumot hónap-nap formátumban
            $today = date("m-d");

            // Lekérdezi, hogy ma kinek van névnapja az adatbázisból
            $sql = "SELECT nevek FROM namedays WHERE datum='$today'";
            $result = $conn->query($sql);
            $nameday = "";

            if ($result->num_rows > 0) {
                // Ha van találat, kiírja a neveket
                $row = $result->fetch_assoc();
                $nameday = $row['nevek'];
            } else {
                // Ha nincs, kiírja, hogy nincs névnap
                $nameday = "Nincs névnap ma.";
            }
            // Kiírja a mai névnaposokat
            echo "<p>Mai névnap: " . $nameday . ", boldog névnapot kívánunk nekik!</p>";
            echo "<h3>Feltöltött fájlok:</h3>";

            // Lekérdezi az összes feltöltött fájlt (de ezt az eredményt nem használja tovább)
            $sql = "SELECT * FROM files ORDER BY id DESC";
            $result = $conn->query($sql);

            // Lekérdezi a legnépszerűbb (legjobbra értékelt) 5 jegyzetet
            $popular_sql = "SELECT f.*, 
                IFNULL(AVG(r.rating),0) as avg_rating, COUNT(r.id) as rating_count
                FROM files f
                LEFT JOIN ratings r ON f.id = r.file_id
                GROUP BY f.id
                ORDER BY avg_rating DESC, rating_count DESC
                LIMIT 5";
            $popular_result = $conn->query($popular_sql);

            // Lekérdezi az 5 legutóbb feltöltött fájlt
            $latest_sql = "SELECT * FROM files ORDER BY id DESC LIMIT 5";
            $latest_result = $conn->query($latest_sql);

            // Legnépszerűbb jegyzetek megjelenítése
            echo "<h3>Legnépszerűbb jegyzetek:</h3>";
            if ($popular_result->num_rows > 0) {
                while ($file = $popular_result->fetch_assoc()) {
                    // Feltöltő felhasználó adatainak lekérdezése
                    $sql = "SELECT * FROM users WHERE id=" . $file['uploaded_by'];
                    $uploader_result = $conn->query($sql);
                    $uploader = $uploader_result->fetch_assoc();

                    // Jegyzet adatai, letöltési link, feltöltő neve és értékelés megjelenítése
                    echo "<div>";
                    echo "<h4>" . $file['name'] . "</h4>";
                    echo "<p><b>Átlag értékelés:</b> " . number_format($file['avg_rating'], 2) . " (" . $file['rating_count'] . " értékelés)</p>";
                    echo "<a href='assets/php/download.php?id=" . $file['id'] . "'>Letöltés</a>";
                    echo "<p>Feltöltötte: <a href='profile.php?userid=" . $file['uploaded_by'] . "'>" . $uploader['username'] . "</a></p>";
                    echo "</div>";
                }
            } else {
                // Ha nincs népszerű jegyzet
                echo "<p>Nincs elérhető népszerű jegyzet.</p>";
            }

            // Új feltöltések megjelenítése
            echo "<h3>Új feltöltések:</h3>";
            if ($latest_result->num_rows > 0) {
                while ($file = $latest_result->fetch_assoc()) {
                    // Feltöltő felhasználó adatainak lekérdezése
                    $sql = "SELECT * FROM users WHERE id=" . $file['uploaded_by'];
                    $uploader_result = $conn->query($sql);
                    $uploader = $uploader_result->fetch_assoc();

                    $file_id = $file['id'];
                    // Átlagos értékelés és értékelések számának lekérdezése az adott fájlhoz
                    $avg_sql = "SELECT IFNULL(AVG(rating),0) as avg_rating, COUNT(id) as rating_count FROM ratings WHERE file_id = $file_id";
                    $avg_result = $conn->query($avg_sql);
                    $avg_data = $avg_result->fetch_assoc();

                    $user_rating = 0;
                    // Lekérdezi, hogy a jelenlegi felhasználó értékelte-e már ezt a fájlt
                    $user_rating_sql = "SELECT rating FROM ratings WHERE file_id = $file_id AND user_id = " . $user['id'];
                    $user_rating_result = $conn->query($user_rating_sql);
                    if ($user_rating_result->num_rows > 0) {
                        $user_rating_row = $user_rating_result->fetch_assoc();
                        $user_rating = $user_rating_row['rating'];
                    }

                    // Jegyzet adatai, letöltési link, feltöltő neve, értékelés és értékelő űrlap megjelenítése
                    echo "<div>";
                    echo "<h4>" .$file['name'] . "</h4>";
                    echo "<a href='assets/php/download.php?id=" . $file['id'] . "'>Letöltés</a>";
                    echo "<p>Feltöltötte: <a href='profile.php?userid=" . $file['uploaded_by'] . "'>" . $uploader['username'] . "</a></p>";
                    echo "<p><b>Átlag értékelés:</b> " .$avg_data['avg_rating'] . " (" . $avg_data['rating_count'] . " értékelés)</p>";

                    // Értékelő űrlap (1-5 csillag)
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='rate_file_id' value='" . $file['id'] . "'>";
                    echo "<label>Értékeld: ";
                    for ($i = 1; $i <= 5; $i++) {
                        $checked = ($user_rating == $i) ? "checked" : "";
                        echo "<input type='radio' name='rating' value='$i' $checked> $i ";
                    }
                    echo "</label>";
                    echo "<button type='submit' name='rate-btn'>Küldés</button>";
                    echo "</form>";

                    echo "</div>";
                }
            } else {
                // Ha nincs új feltöltés
                echo "<p>Nincs új feltöltés.</p>";
            }
        ?>
    </div>
    <?php
        include 'assets/php/footer.php';
    ?>
    <script src="assets/js/script.js"></script>
   </body>
</html>