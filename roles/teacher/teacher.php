<?php

    require "../../assets/php/cfg.php";
    session_start();

    if(!isset($_COOKIE['id'])){
        header("Location: ../../index.php");
    }
    if (isset($_POST['class_name'])) {
        $class_name = $_POST['class_name'];
        $conn->query("INSERT INTO classes (name) VALUES ('$class_name')");
        echo "Osztály sikeresen létrehozva.";
    } elseif (isset($_POST['class_id']) && !isset($_POST['student_id']) && !isset($_POST['schedule_id'])) {
        $class_id = $_POST['class_id'];
        $conn->query("DELETE FROM classes WHERE id = $class_id");
        echo "Osztály sikeresen törölve.";
    } elseif (isset($_POST['class_id']) && !isset($_POST['student_id']) && isset($_POST['schedule_id'])) {
        $schedule_id = $_POST['schedule_id'];
        $conn->query("DELETE FROM schedules WHERE id = $schedule_id");
        echo "Órarend sikeresen törölve.";
    } elseif (isset($_POST['class_id']) && isset($_POST['student_id'])) {
        $class_id = $_POST['class_id'];
        $student_id = $_POST['student_id'];
        $conn->query("DELETE FROM class_students WHERE class_id = $class_id AND student_id = $student_id");
        echo "Diák sikeresen eltávolítva az osztályból.";
    } elseif (isset($_POST['assignment_id'])) {
        $assignment_id = $_POST['assignment_id'];
        $conn->query("DELETE FROM assignments WHERE id = $assignment_id");
        echo "Feladat sikeresen törölve.";
    } elseif (isset($_POST['student_id']) && isset($_POST['grade'])) {
        $student_id = $_POST['student_id'];
        $grade = $_POST['grade'];
        $conn->query("INSERT INTO grades (student_id, grade) VALUES ($student_id, '$grade')");
        echo "Érdemjegy sikeresen hozzáadva.";
    } elseif (isset($_POST['class_id']) && !isset($_POST['student_id'])) {
        $class_id = $_POST['class_id'];
        $result = $conn->query("SELECT * FROM students WHERE class_id = $class_id");
        while ($row = $result->fetch_assoc()) {
            echo "Diák: " . $row['name'] . "<br>";
        }
    } elseif (isset($_POST['schedule_id']) && !isset($_POST['class_id'])) {
        $class_id = $_POST['class_id'];
        $result = $conn->query("SELECT * FROM schedules WHERE class_id = $class_id");
        while ($row = $result->fetch_assoc()) {
            echo "Órarend: " . $row['details'] . "<br>";
        }
    } else {
        $result = $conn->query("SELECT * FROM classes");
        while ($row = $result->fetch_assoc()) {
            echo "Osztály: " . $row['name'] . "<br>";
        }
    }
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
                echo '<li><a href="">Admin</a></li>';
            }
            if ($user['teacher'] == 1) {
                echo '<li><a href="teacher.php">Tanári felület</a></li>';
            }
            ?>
            <li><a href="">Diák felület</a></li>
            <li><a href="/assets/php/logout.php">Kijelentkezés</a></li> 
        </ul>
    </nav>
    <div class="teacher-dashboard">
        <h1>Tanári Felület</h1>
        <p>Üdvözöljük a tanári oldalon, <?php echo htmlspecialchars($user['name']); ?>!</p>
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
        <section>
            <h2>Osztályok és diákok kezelése</h2>
            <form method="POST">
                <label for="class_id">Osztály azonosító:</label>
                <input type="text" id="class_id" name="class_id" required>
                <label for="student_id">Diák azonosító:</label>
                <input type="text" id="student_id" name="student_id" required>
                <button type="submit">Diák eltávolítása az osztályból</button>
            </form>
        </section>
        <section>
            <h2>Feladatok kezelése</h2>
            <form method="POST">
                <label for="assignment_id">Feladat azonosító:</label>
                <input type="text" id="assignment_id" name="assignment_id" required>
                <button type="submit">Feladat törlése</button>
            </form>
        </section>
        <section>
            <h2>Diákok értékelése</h2>
            <form method="POST">
                <label for="student_id">Diák azonosító:</label>
                <input type="text" id="student_id" name="student_id" required>
                <label for="grade">Érdemjegy:</label>
                <input type="text" id="grade" name="grade" required>
                <button type="submit">Érdemjegy hozzáadása</button>
            </form>
        </section>
        <section>
            <h2>Órarend kezelése</h2>
            <form method="POST">
                <label for="schedule_id">Órarend azonosító:</label>
                <input type="text" id="schedule_id" name="schedule_id" required>
                <button type="submit">Órarend törlése</button>
            </form>
        </section>
        <section>
            <h2>Órarend megtekintése</h2>
            <form method="POST">
                <label for="class_id">Osztály azonosító:</label>
                <input type="text" id="class_id" name="class_id" required>
                <button type="submit">Órarend megtekintése</button>
            </form>
        </section>
        <section>
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