<?php
    require __DIR__ . '/../../assets/php/cfg.php';
    session_start();
    
    if(!isset($_COOKIE['id'])){
        header("Location: ../../index.php");
    }
    if (isset($_POST['addadmin-btn'])) {
        $username = $_POST['username'];
        $sql = "SELECT * FROM users WHERE id='" . $username . "'";
        $found_user = $conn->query($sql);
        $user = $found_user->fetch_assoc();
    
        if (!empty($username)) {
            $sql = $conn->query("UPDATE users SET admin = 1 WHERE username = '" . $conn->real_escape_string($username) . "'");
            if (mysqli_num_rows($found_user) > 0) {
                echo "<script>alert('Admin hozzáadva: $username')</script>";
            } else {
                echo "<script>alert('Hiba: A felhasználó nem található vagy már admin.')</script>";
            }
        } else {
            echo "<script>alert('Hiba: A felhasználónév mező üres.')</script>";
        }
    }

    if (isset($_POST['removeadmin-btn'])) {
        $username = $_POST['username'];
        $sql = "SELECT * FROM users WHERE username = '$username'"Ö
        $found_user = $conn->query($sql);
        $user = $found_user->fetch_assoc();
    
        if (!empty($username)) {
            $sql = $conn->query("UPDATE users SET admin = 0 WHERE username = '" . $conn->real_escape_string($username) . "'");
            if (mysqli_num_rows($found_user) > 0) {
                echo "<script>alert('Admin eltávolítva: $username')</script>";
            } else {
                echo "<script>alert('Hiba: A felhasználó nem található vagy nem admin.')</script>";
            }
        } else {
            echo "<script>alert('Hiba: A felhasználónév mező üres.')</script>";
        }
    }

    if(isset($_POST['removeuser-btn'])) {
        $username = $_POST['username'];
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $found_user = $conn->query($sql);
        $user = $found_user->fetch_assoc();
        if (!empty($username)) {
            $sql = $conn->query("DELETE FROM users WHERE username = '$username'");
            if (mysqli_num_rows($found_user) > 0) {
                echo "<script>alert('Felhasználó törölve: $username')</script>";
            } else {
                echo "<script>alert('Hiba: A felhasználó nem található.')</script>";
            }
        } else {
            echo "<script>alert('Hiba: A felhasználónév mező üres.')</script>";
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
            <li><a href="../../index.php">Főoldal</a></li> 
            <li><a href="../../upload.php">Feltöltés</a></li> 
            <li><a href="../../myprofile.php">Profilom</a></li> 
            <li><a href="../../search.php">Keresés</a></li>
            <?php
                $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
                $found_user = $conn->query($sql);
                $user = $found_user->fetch_assoc();

                if ($user['admin'] == 1) {
                    echo '<li><a href="admin.php">Admin</a></li>';
                }
                if ($user['teacher'] == 1) {
                    echo '<li><a href="/roles/teacher/teacher.php">Tanári felület</a></li>';
                }
            ?>
            <li><a href="../../assets/php/logout.php">Kijelentkezés</a></li> 
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
    <h2>Felhasználók kezelése</h2>
    <section>
        <form method="post">
            <label>Felhasználó törlése:</label><br>
            <label for="username">Felhasználónév:</label><br>
            <input type="text" id="username" name="username"><br><br>
            <input type="submit" name="removeuser-btn" value="Felhasználó törlése">
        </form>
    </section>
    <script src='assets/js/script.js'></script>
   </body>
</html>