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
    <div class="teacher-dashboard">
        <h1>Tanári Felület</h1>
        <p>Üdvözöljük a tanári oldalon, <?php echo htmlspecialchars($user['name']); ?>!</p>
        <section class="teacher-actions">
            <h2>Funkciók</h2>
            <ul>
            <li><a href="/roles/teacher/assignments.php">Feladatok kezelése</a></li>
            <li><a href="/roles/teacher/grade_students.php">Diákok értékelése</a></li>
            <li><a href="/roles/teacher/schedule.php">Órarend kezelése</a></li>
            </ul>
        </section>
        <section class="teacher-communication">
            <h2>Kommunikáció</h2>
            <ul>
            <li><a href="/roles/teacher/messages.php">Üzenetek</a></li>
            <li><a href="/roles/teacher/announcements.php">Közlemények</a></li>
            </ul>
        </section>
        <section>
            <h2>Osztályok létrehozása</h2>
            <form method="POST">
                <label for="class_name">Osztály neve:</label>
                <input type="text" id="class_name" name="class_name" required>
                <button type="submit">Osztály létrehozása</button>
            </form>
        </section>
        <section>
            <h2>Osztályok kezelése</h2>
            <form method="POST">
                <label for="class_id">Osztály azonosító:</label>
                <input type="text" id="class_id" name="class_id" required>
                <button type="submit">Osztály törlése</button>
            </form>
        </section>
        <section>
            <h2>Osztályok listázása</h2>
            <form method="POST">
                <button type="submit">Osztályok listázása</button>
            </form>
        </section>
        <section>
            <h2>Diákok megtekintése</h2>
            <form method="POST">
                <label for="class_id">Osztály azonosító:</label>
                <input type="text" id="class_id" name="class_id" required>
                <button type="submit">Diákok megtekintése</button>
            </form>
        </section>
        <section class="teacher-resources">
            <h2>Hasznos linkek</h2>
            <ul>
            <li><a href="/resources/teaching_materials.php">Tanári anyagok</a></li>
            <li><a href="/resources/teaching_guidelines.php">Tanítási irányelvek</a></li>
            <li><a href="/resources/student_resources.php">Diákoknak szóló anyagok</a></li>
            </ul>
        </section>
    </div>
    <script src='assets/js/script.js'></script>
   </body>
</html>