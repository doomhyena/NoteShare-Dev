<?php

    require "cfg.php";

    if (!isset($_COOKIE['id'])) {
        header('Location: reg.php');
    }

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Főoldal</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   </head>
   <body>
   <nav>
        <ul>
            <li><a href="index.php">Főoldal</a></li>
			<li><a href="upload.php">Feltöltés</a></li>
            <li><a href="logout.php">Kijelentkezés</a></li>
        </ul>
    </nav>
    <div>
        <h1>Üdvözöljük a Jegyzetmegosztó oldalon!</h1>
        <p>Itt megoszthatja és letöltheti az iskolai jegyzeteket.</p>
        <p>Feltöltött jegyzetek:</p>
        <!-- PHP kód a jegyzetek megjelenítésére -->
        <?php
        
            $sql = "SELECT * FROM files ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                    echo "<a href='download.php?id=" . $row['id'] . "'>Letöltés</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nincsenek feltöltött jegyzetek.</p>";
            }
        
        ?>
    </div>
    <script src="assets/js/script.js"></script>
   </body>
</html>