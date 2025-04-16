<!DOCTYPE html>
<html>
    <head>
       <title>Diák Oldal</title>
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
                require __DIR__ . '/../../assets/php/cfg.php';
                if(!isset($_COOKIE['id'])){
                    header("Location: ../../index.php");
                }
                $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
                $found_user = $conn->query($sql);
                $user = $found_user->fetch_assoc();

                if ($user['admin'] == 1) {
                    echo '<li><a href="../admin/admin.php">Admin</a></li>';
                }
                if ($user['teacher'] == 1) {
                    echo '<li><a href="../teacher/teacher.php">Tanári felület</a></li>';
                }
            ?>
            <li><a href="../../assets/php/logout.php">Kijelentkezés</a></li> 
        </ul>
    </nav>
   </body>
</html>