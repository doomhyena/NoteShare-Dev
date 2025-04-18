<?php
    require dirname(__FILE__)."/assets/php/cfg.php";
    session_start();
    
    if(!isset($_COOKIE['id'])){
        header("Location: ../../index.php");
    }
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    if (isset($_POST['addadmin-btn'])) {
        $username = $_POST['username'];
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $found_user = $conn->query($sql);
        $user = $found_user->fetch_assoc();
    
        if (!empty($username)) {
            $sql = $conn->query("UPDATE users SET admin = 1 WHERE username = '$username'");
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
        $sql = "SELECT * FROM users WHERE username = '$username'";
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

    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
    $founded_notify = $conn->query($sql);
    $notify_number = mysqli_num_rows($founded_notify);
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
            <li><a href="../../profile.php">Profilom</a></li> 
            <li><a href="../../search.php">Keresés</a></li>
            <?php
                $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
                $found_user = $conn->query($sql);
                $user = $found_user->fetch_assoc();

                if ($user['admin'] == 1) {
                    echo "<li><a href='../../notify.php'>Értesítések ($notify_number)</a></li>";
                    echo '<li><a href="admin.php">Admin</a></li>';
                }
                if ($user['teacher'] == 1) {
                    echo '<li><a href="/roles/teacher/teacher.php">Tanári felület</a></li>';
                }
            ?>
            <li><a href="../students/students.php">Diák felület</a></li>
            <li><a href="../../assets/php/logout.php">Kijelentkezés</a></li> 
        </ul>
    </nav>
    <h1>Admin Panel</h1>
    <h2>Adminisztrátorok kezelése</h2>
    <?php
        echo "<section>";
        echo "<h3>Adminisztrátorok listája:</h3>";
        $sql = "SELECT * FROM users WHERE admin = 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row['username'] . "</p>";
                echo "</section>";
            }
        } else {
            echo "<p>Nincsenek adminisztrátorok.</p>";
            echo "</section>";
        }
        if ($user['username'] == 'doomhyena') {
            
            echo "<section>";
            echo "  <h3>Adminisztrátorok hozzáadása:</h3>";
            echo "  <form method='post'>";
            echo "      <label>Admin hozzáadása:</label><br>";
            echo "      <label for='username'>Felhasználónév:</label><br>";
            echo "      <input type='text' id='username' name='username'><br><br>";
            echo "      <input type='submit' name='addadmin-btn' value='Admin hozzáadása'>";
            echo "  </form>";
            echo "</section>";
            echo "<section>";
            echo "  <h3>Adminisztrátorok eltávolítása:</h3>";
            echo "  <form method='post'>";
            echo "      <label>Admin törlése:</label><br>";
            echo "      <label for='username'>Felhasználónév:</label><br>";
            echo "      <input type='text' id='username' name='username'><br><br>";
            echo "      <input type='submit' name='removeadmin-btn' value='Admin törlése'>";
            echo "  </form>";
            echo "</section>";

        } else {
            echo "<script>alert('Hiba: Nincs jogosultságod az adminisztrátorok kezelésére.')</script>";
        }
    
    ?>
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