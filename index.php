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
    </div>
    <script src="assets/js/script.js"></script>
   </body>
</html>