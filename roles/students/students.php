<?php

    require __DIR__ . '/../../assets/php/cfg.php';
    session_start();
                    
    if(!isset($_COOKIE['id'])){
        header("Location: ../../index.php");
    }

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
            <li><a href="../../index.php">Főoldal</a></li> 
            <li><a href="../../upload.php">Feltöltés</a></li> 
            <li><a href="../../myprofile.php">Profilom</a></li> 
            <li><a href="../../search.php">Keresés</a></li>
            <?php

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
            <li><a href="students.php">Diák felület</a></li>
            <li><a href="../../assets/php/logout.php">Kijelentkezés</a></li> 
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
                
                $sql = "SELECT * FROM schedule WHERE class_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $class_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table border='1'>";
                    echo "<tr><th>Nap</th><th>Óra</th><th>Tantárgy</th><th>Tanterem</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['day']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['room']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Nincs elérhető órarend.</p>";
                }
                $stmt->close();
            }
    
    ?>
   </body>
</html>