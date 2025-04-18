<?php

    require dirname(__FILE__)."/assets/php/cfg.php";
    session_start();
                    
    if(!isset($_COOKIE['id'])){
        header("Location: ../../index.php");
    }
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();
    
    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
    $founded_notify = $conn->query($sql);
    $notify_number = mysqli_num_rows($founded_notify);

?>
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
            <?php
                echo '<li><a href="'.dirname(__FILE__).'/index.php">Főoldal</a></li>';
                echo '<li><a href="'.dirname(__FILE__).'/upload.php">Feltöltés</a></li> ';
                echo '<li><a href="'.dirname(__FILE__).'/profile.php">Profilom</a></li> ';
                echo '<li><a href="'.dirname(__FILE__).'/search.php">Keresés</a></li>';
                echo "<li><a href=".dirname(__FILE__)."/notify.php'>Értesítések ($ertesitesek_szama)</a></li>";
                $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
                $found_user = $conn->query($sql);
                $user = $found_user->fetch_assoc();

                if ($user['admin'] == 1) {
                    echo '<li><a href='.dirname(__FILE__).'/roles/admin/admin.php">Admin</a></li>';
                }
                if ($user['teacher'] == 1) {
                    echo '<li><a href="'.dirname(__FILE__).'/roles/teacher/teacher.php">Tanári felület</a></li>';
                }
                echo '<li><a href="'.dirname(__FILE__).'/assets/php/logout.php">Kijelentkezés</a></li>';
            ?>
        </ul>
    </nav>
    <h1>Diák Oldal</h1>
    <section>
        <h2>Főbb funkciók</h2>
        <form method="POST" action="students.php">
            <input type="hidden" name="class_id" value="<?php echo $user['class_id']; ?>">
            <button type="submit" name="view_assignments">Feladatok megtekintése</button>
            <button type="submit" name="view_schedule">Órarend megtekintése</button>
        </form>
    </section>
    <?php
    
            if(isset($_POST['view_schedule'])) {
                $class_id = $user['class_id'];
                $found_schedules = $conn->query("SELECT details FROM schedules WHERE class_id = '$class_id'");

                if ($schedules->num_rows > 0) {
                    $schedule = $schedules->fetch_assoc();
                    echo "<h3>Órarend:</h3>";
                    echo "<div>" . nl2br(htmlspecialchars($schedule['details'])) . "</div>";
                } else {
                    echo "<p>Nincs elérhető órarend az osztály számára.</p>";
                }
            }
    
    ?>
   </body>
</html>