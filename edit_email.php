<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Új email</title>
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
            require  "assets/php/db.php";

            if (isset($_POST['forg-btn'])) {
                $username = $_POST['username'];
                $security_answer = $_POST['security_answer'];
                $sql = "SELECT * FROM users WHERE username='$username'";
                $found_user = $conn->query($sql);
            
                if (mysqli_num_rows($found_user) > 0) {
                    $user = $found_user->fetch_assoc();
            
                    if ($security_answer == $user['security_answer']) {
                        echo "<form method='post' action='forgotemail.php?userid=$user[id]'>";
                        echo '    <input type="email" name="email1" placeholder="Jelszó">';
                        echo '    <input type="email" name="email2" placeholder="Jelszó újra">';
                        echo '    <input type="submit" name="new-email-btn" placeholder="Elküldés">';
                        echo '</form>';
                    } else {
                        echo "<script>alert('Helytelen biztonsági válasz!')</script>";
                    }
                } else {
                    echo "<script>alert('Nincs ilyen felhasználó!')</script>";
                }
            } else if (isset($_POST['new-email-btn'])) {
                $userid = $_GET['userid'];
            
                if ($_POST['email1'] == $_POST['email2']) {
                    $sql = "SELECT * FROM users WHERE id=$userid";
                    $found_user = $conn->query($sql);
                    $user = $found_user->fetch_assoc();
            
                    if ($_POST['email1'] != $user['email']) {
                        $email = $_POST['email1'];
                        $conn->query("UPDATE users SET email='$email' WHERE id=$userid");

                        echo "<script>alert('Az új email címed sikeresen megváltozott!')</script>";
                        echo "<a href='index.php'>Vissza a főoldalra</a>";
                    } else {
                        echo "<script>alert('Az új email címed nem egyezhet a régivel.')</script>";
                    }
                } else {
                    echo "<script>alert('A két email cím nem egyezik!')</script>";
                }
            } else {
                echo '<h1>Add meg a felhasználónevedet és a biztonsági kérdésre adott válaszodat!</h1>';
                echo '<form method="post">';
                echo '    <input type="text" name="username" placeholder="Felhasználónév">';
                echo '    <input type="text" name="security_answer" placeholder="Biztonsági kérdés válasza">';
                echo '    <input type="submit" name="forg-btn" value="Elküldés">';
                echo '</form>';
            }
        ?>
        <?php
            include 'assets/php/footer.php';
        ?>
        <script src="assets/js/script.js"></script>
   </body>
</html>