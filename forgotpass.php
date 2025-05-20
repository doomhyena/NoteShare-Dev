<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Elfelejtett Jelszó</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Bor Ádám, Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel="stylesheet" href="assets/css/style.css">
   </head>
   <body>
        <?php 
        
        require "assets/php/db.php";

        // Ha a felhasználó elküldte a felhasználónevét és a biztonsági kérdésre adott válaszát
        if (isset($_POST['forg-btn'])) {
            $username = $_POST['username'];
            $security_answer = $_POST['security_answer'];
            // Lekérdezi az adatbázisból a felhasználót
            $sql = "SELECT * FROM users WHERE username='$username'";
            $found_user = $conn->query($sql);

            if (mysqli_num_rows($found_user) > 0) {
            $user = $found_user->fetch_assoc();

            // Ellenőrzi, hogy a megadott biztonsági válasz egyezik-e az adatbázisban tárolttal
            if ($security_answer == $user['security_answer']) {
                // Ha egyezik, megjelenít egy űrlapot az új jelszó megadásához
                echo "<form method='post' action='forgotpass.php?userid=$user[id]'>";
                echo '    <input type="password" name="password1" placeholder="Jelszó">';
                echo '    <input type="password" name="password2" placeholder="Jelszó újra">';
                echo '    <input type="submit" name="new-pass-btn" placeholder="Elküldés">';
                echo '</form>';
            } else {
                // Ha nem egyezik, hibaüzenetet jelenít meg
                echo "<script>alert('Helytelen biztonsági válasz!')</script>";
            }
            } else {
            // Ha nincs ilyen felhasználó, hibaüzenetet jelenít meg
            echo "<script>alert('Nincs ilyen felhasználó!')</script>";
            }
        }
        // Ha a felhasználó elküldte az új jelszót
        else if (isset($_POST['new-pass-btn'])) {
            $userid = $_GET['userid'];

            // Ellenőrzi, hogy a két jelszó egyezik-e
            if ($_POST['password1'] == $_POST['password2']) {
            $sql = "SELECT * FROM users WHERE id=$userid";
            $found_user = $conn->query($sql);
            $user = $found_user->fetch_assoc();

            // Ellenőrzi, hogy az új jelszó különbözik-e a régitől
            if ($_POST['password1'] != $user['password']) {
                $password = $_POST['password1'];
                // Titkosítja az új jelszót
                $titkositott_jelszo = password_hash($password, PASSWORD_DEFAULT);
                // Frissíti az adatbázisban
                $conn->query("UPDATE users SET password='$titkositott_jelszo' WHERE id=$userid");

                // Sikeres módosítás esetén visszajelzést ad és bejelentkezési linket jelenít meg
                echo "<script>alert('A jelszavad sikeresen megváltozott!')</script>";
                echo "<a href='login.php'>Bejelentkezés</a>";
            } else {
                // Ha az új jelszó megegyezik a régivel
                echo "<script>alert('Az új jelszavad nem egyezhet a régivel.')</script>";
            }
            } else {
            // Ha a két jelszó nem egyezik
            echo "<script>alert('A két jelszó nem egyezik!')</script>";
            }
        }
        // Ha egyik űrlap sem lett elküldve, megjeleníti a felhasználónév és biztonsági válasz bekérő űrlapot
        else {
            echo '<h1>Add meg a felhasználónevedet és a biztonsági kérdésre adott válaszodat!</h1>';
            echo '<form method="post">';
            echo '    <input type="text" name="username" placeholder="Felhasználónév">';
            echo '    <input type="text" name="security_answer" placeholder="Biztonsági kérdés válasza">';
            echo '    <input type="submit" name="forg-btn" value="Elküldés">';
            echo '</form>';
        }

        // A végén betölti a láblécet
        include 'assets/php/footer.php';
        ?>
        <script src="assets/js/script.js"></script>
   </body>
</html>