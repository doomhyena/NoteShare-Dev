<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Új email</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel="stylesheet" href="assets/css/styles.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       <script src="assets/js/script.js"></script>
   </head>
   <body>
        <?php
            require  "assets/php/db.php"; // Betölti az adatbázis kapcsolatot biztosító fájlt

            if (isset($_POST['forg-btn'])) { // Ellenőrzi, hogy elküldték-e az első űrlapot
                $username = $_POST['username']; // Felhasználónév lekérése az űrlapról
                $security_answer = $_POST['security_answer']; // Biztonsági válasz lekérése
                $sql = "SELECT * FROM users WHERE username='$username'"; // Felhasználó keresése adatbázisban
                $found_user = $conn->query($sql); // Lekérdezés futtatása

                if (mysqli_num_rows($found_user) > 0) { // Ha létezik ilyen felhasználó
                    $user = $found_user->fetch_assoc(); // Felhasználó adatainak lekérése

                    if ($security_answer == $user['security_answer']) { // Ha helyes a biztonsági válasz
                        // Új email cím megadására szolgáló űrlap megjelenítése
                        echo "<form method='post'>";
                        echo '    <input type="email" name="email1" placeholder="Email">';
                        echo '    <input type="email" name="email2" placeholder="Email újra">';
                        echo '    <input type="submit" name="new-email-btn" placeholder="Elküldés">';
                        echo '</form>';
                    } else {
                        // Hibajelzés, ha rossz a biztonsági válasz
                        echo "<script>alert('Helytelen biztonsági válasz!')</script>";
                    }
                } else {
                    // Hibajelzés, ha nincs ilyen felhasználó
                    echo "<script>alert('Nincs ilyen felhasználó!')</script>";
                }
            } else if (isset($_POST['new-email-btn'])) { // Ha az új email cím űrlapot küldték el
                $userid = $_GET['userid']; // Felhasználó azonosítójának lekérése az URL-ből

                if ($_POST['email1'] == $_POST['email2']) { // Ellenőrzi, hogy a két email egyezik-e
                    $sql = "SELECT * FROM users WHERE id=$userid"; // Felhasználó keresése azonosító alapján
                    $found_user = $conn->query($sql); // Lekérdezés futtatása
                    $user = $found_user->fetch_assoc(); // Felhasználó adatainak lekérése

                    if ($_POST['email1'] != $user['email']) { // Ellenőrzi, hogy az új email különbözik-e a régitől
                        $email = $_POST['email1']; // Új email cím eltárolása
                        $conn->query("UPDATE users SET email='$email' WHERE id=$userid"); // Email frissítése az adatbázisban

                        // Sikeres módosítás visszajelzése
                        echo "<script>alert('Az új email címed sikeresen megváltozott!')</script>";
                        echo "<a href='index.php'>Vissza a főoldalra</a>";
                    } else {
                        // Hibajelzés, ha az új email megegyezik a régivel
                        echo "<script>alert('Az új email címed nem egyezhet a régivel.')</script>";
                    }
                } else {
                    // Hibajelzés, ha a két email nem egyezik
                    echo "<script>alert('A két email cím nem egyezik!')</script>";
                }
            } else {
                // Az első űrlap megjelenítése, ha még nem történt beküldés
                echo '<h1>Add meg a felhasználónevedet és a biztonsági kérdésre adott válaszodat!</h1>';
                echo '<form method="post">';
                echo '    <input type="text" name="username" placeholder="Felhasználónév">';
                echo '    <input type="text" name="security_answer" placeholder="Biztonsági kérdés válasza">';
                echo '    <input type="submit" name="forg-btn" value="Elküldés">';
                echo '</form>';
            }

            include 'assets/php/footer.php'; // Lábjegyzet (footer) beillesztése
        ?>
   </body>
</html>
