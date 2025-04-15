<?php

    require "../../assets/php/cfg.php";
    session_start();

?>
<!DOCTYPE html>
<html>
   <head>
       <title>Tanari Oldal</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>
        <nav>
            <ul>
                <li><a href="../../index.php">Főoldal</a></li>
                    <li><a href="teacher.php">Tanári felület</a></li>
                    <li><a href="../../assets/php/logout.php">Kijelentkezés</a></li>
                </ul>
            </nav>
        <h1>Tanári oldal</h1>
         <main>
              <h2>Üdvözöljük a tanári felületen!</h2>
              <p>Itt kezelheti a tanulók jegyzeteit és egyéb információit.</p>
              <p>Használja a bal oldali menüt a navigáláshoz.</p>
              <h2>Tanulók kezelése</h2>
                <form method="POST">
                    <label for="username">Felhasználónév:</label>
                    <input type="text" name="username" id="username" required>
                    <button type="submit" name="removeadmin-btn"></button>
                </form>
        </main>
    <script src='assets/js/script.js'></script>
   </body>
</html>