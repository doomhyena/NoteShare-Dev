<?php
    require '/../../assets/php/cfg.php';
    session_start();
    
    if(!isset($_COOKIE['id'])){
        header("Location: ../../index.php");
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['addadmin-btn'])) {
            $username = $_POST['username'];
            if (!empty($username)) {
                $sql = $conn->prepare("UPDATE users SET admin = 1 WHERE username = ?");
                if (mysqli_num_rows() > 0) {
                    echo "<p>Admin hozzáadva: $username</p>";
                } else {
                    echo "<p>Hiba: A felhasználó nem található vagy már admin.</p>";
                }
                $sql->close();
            } else {
                echo "<p>Hiba: A felhasználónév mező üres.</p>";
            }
        }

        if (isset($_POST['removeadmin-btn'])) {
            $username = $_POST['username'];
            if (!empty($username)) {
                $sql = $conn->prepare("UPDATE users SET admin = 0 WHERE username = ?");
                if ($sql->affected_rows > 0) {
                    echo "<p>Admin eltávolítva: $username</p>";
                } else {
                    echo "<p>Hiba: A felhasználó nem található vagy nem admin.</p>";
                }
                $sql->close();
            } else {
                echo "<p>Hiba: A felhasználónév mező üres.</p>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Admin oldal</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
    <body>
    <nav>
        <ul>
            <li><a href="/index.php">Főoldal</a></li> 
            <li><a href="/upload.php">Feltöltés</a></li> 
            <li><a href="/myprofile.php">Profilom</a></li> 
            <li><a href="/search.php">Keresés</a></li>
            <?php
            if ($user['admin'] == 1) {
                echo '<li><a href="/roles/admin/admin.php">Admin</a></li>';
            }
            if ($user['teacher'] == 1) {
                echo '<li><a href="/roles/teacher/teacher.php">Tanári felület</a></li>';
            }
            ?>
            <li><a href="/assets/php/logout.php">Kijelentkezés</a></li> 
        </ul>
    </nav>
    <h1>Admin Panel</h1>
    <h2>Adminisztrátorok kezelése</h2>
    <section>
        <form method="post">
            <label>Admin hozzáadása:</label><br>
            <label for="username">Felhasználónév:</label><br>
            <input type="text" id="username" name="username"><br><br>
            <input type="submit" name="addadmin-btn" value="Admin hozzáadása">
        </form>
    </section>
    <section>
        <form method="post">
            <label>Admin Törlése:</label><br>
            <label for="username">Felhasználónév:</label><br>
            <input type="text" id="username" name="username"><br><br>
            <input type="submit" name="removeadmin-btn" value="Admin eltávolítása">
        </form>
    </section>
    <script src='assets/js/script.js'></script>
   </body>
</html>