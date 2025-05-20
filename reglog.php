<?php
    require  "assets/php/db.php"; // Betölti az adatbázis kapcsolatot biztosító fájlt

    $security_questions = [
        "Mi a kedvenc könyved?",
        "Mi volt az első háziállatod neve?",
        "Mi az édesanyád leánykori neve?",
        "Mi a születési városod?",
        "Mi a kedvenc ételed?"
    ]; // Biztonsági kérdések tömbje

    $selected_question = $security_questions[array_rand($security_questions)]; // Véletlenszerűen kiválaszt egy biztonsági kérdést

    if(isset($_POST['reg-btn'])){ // Ellenőrzi, hogy a regisztrációs űrlapot elküldték-e
        $lastname = $_POST['lastname']; // Vezetéknév beolvasása
        $firstname = $_POST['firstname']; // Keresztnév beolvasása
        $username = $_POST['username']; // Felhasználónév beolvasása
        $birthdate = $_POST['birthdate']; // Születési dátum beolvasása
        $gender = $_POST['gender']; // Nem beolvasása
        $email = $_POST['email']; // Email cím beolvasása
        $password = $_POST['password1']; // Első jelszó mező beolvasása
        $passwordtwo = $_POST['password2']; // Második jelszó mező beolvasása
        $registration_date = date('Y-m-d H:i:s'); // Regisztráció dátumának lekérése
        $security_question = $_POST['security_question']; // Biztonsági kérdés beolvasása
        $security_answer = $_POST['security_answer']; // Biztonsági válasz beolvasása

        $sql = "SELECT * FROM users WHERE username='$username'";
        $found_user = $conn->query($sql); // Megnézi, hogy létezik-e már ilyen felhasználónév

        if(mysqli_num_rows($found_user) == 0){ // Ha nincs ilyen felhasználónév
            $sql = "SELECT * FROM users WHERE email='$email'";
            $found_email = $conn->query($sql); // Megnézi, hogy létezik-e már ilyen email cím

            if(mysqli_num_rows($found_email) == 0) { // Ha nincs ilyen email cím
                if($password == $passwordtwo){ // Ellenőrzi, hogy a két jelszó megegyezik-e
                    $titkositott_jelszo = password_hash($password, PASSWORD_DEFAULT); // Jelszó titkosítása
                    $sql = $conn->query("INSERT INTO users (lastname, firstname, username, birthdate, gender, email, password, security_question, security_answer, registration_date) VALUES ('$lastname', '$firstname', '$username', '$birthdate', '$gender', '$email', '$titkositott_jelszo', '$security_question', '$security_answer', '$registration_date')");
                    // Új felhasználó beszúrása az adatbázisba

                    $folder = getcwd();
                    $path = $folder . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR . $username;
                    if(!is_dir($path) && mkdir($path, 0777, true)){
                        echo "<script>alert('Tárhely sikeresen létrehozva!')</script>";
                        // Felhasználóhoz tartozó mappa létrehozása sikeres
                    } else {
                        echo "<script>alert('Nem sikerült létrehozni a tárhelyet!')</script>";
                        // Mappa létrehozása sikertelen
                    }
                } else {
                    echo "<script>alert('A jelszavak nem egyeznek!')</script>";
                    // A két jelszó nem egyezik
                }
            } else {
                echo "<script>alert('Már létezik ilyen email cím!')</script>";
                // Már létezik ilyen email cím
            }
        } else {
            echo "<script>alert('Már létezik ilyen felhasználó!')</script>";
            // Már létezik ilyen felhasználónév
        }
    }

    if(isset($_POST['login-btn'])){ // Ellenőrzi, hogy a bejelentkezési űrlapot elküldték-e
        $username = $_POST['username']; // Felhasználónév beolvasása
        $password = $_POST['password']; // Jelszó beolvasása
        $sql = "SELECT * FROM users WHERE username='$username'";
        $found_user = $conn->query($sql); // Megkeresi a felhasználót az adatbázisban

        if(mysqli_num_rows($found_user) > 0){ // Ha létezik ilyen felhasználó
            $user = $found_user->fetch_assoc(); // Felhasználó adatainak lekérése

            if(password_verify($password, $user['password'])){ // Ellenőrzi a jelszót
                setcookie("id", $user['id'], time() + 3600, "/"); // Sütit állít be a felhasználó azonosítójával
                header("Location: index.php"); // Átirányít a főoldalra
            } else {
                echo "<script>alert('Hibás jelszó!')</script>";
                // Hibás jelszó
            }
        } else {
            echo "<script>alert('Nincs ilyen felhasználó!')</script>";
            // Nincs ilyen felhasználó
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Reglog</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Bor Ádám, Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>
        <h1>Regisztráció</h1>
	    <form id="reg" style="display: none;" method="post">
            <label for="lastname">Vezetéknév:</label><br>
            <input type="text" name="lastname"><br><br>
            <label for="lastname">Keresztnév:</label><br>
            <input type="text" name="firstname"><br><br>
            <label for="username">Felhasználónév:</label><br>
            <input type="text" name="username"><br><br>
            <label for="birthdate">Születési dátum:</label><br>
            <input type="date" name="birthdate"><br><br>
            <label for="gender">Nem:</label><br>
            <select name="gender">
                <option name="male" value="male">Férfi</option>
                <option name="female" value="female">Nő</option>
                <option name="other" value="other">Egyéb</option>
            </select><br><br>
            <label for="email">Email:</label><br>
            <input type="email" name="email"><br><br>
            <label for="password">Jelszó:</label><br>
            <input type="password" name="password1"><br><br>
            <label for="password">Jelszó újra:</label><br>
            <input type="password" name="password2"><br><br>
            <p><strong>Biztonsági kérdés:</strong> <?php echo $selected_question; ?></p>
            <input type="hidden" name="security_question" value="<?php echo $selected_question; ?>">
            <label for="security_answer">Válasz:</label><br>
            <input type="text" name="security_answer"><br><br>
            <input type="submit" name="reg-btn" value="Regisztráció!">
            <label>Már van fiókod? <a href="#" onclick="showForm('login')">Lépj be!</a></label>
        </form>
        <h1>Bejelentkezés</h1>
	    <form class="reglog" id="login" method="post">
            <label for="username">Felhasználónév:</label><br>
            <input type="text" name="username"><br><br>
            <label for="password">Jelszó:</label><br>
            <input type="password" name="password"><br><br>
            <input type="submit" name="login-btn" value="Bejelentkezés!">
            <label>Még nincs fiókod? <a href="#" onclick="showForm('reg')">Regisztrálj!</a></label>
        </form>
        <?php
            // Betölti a láblécet
            include 'assets/php/footer.php';
        ?>
        <script src="assets/js/script.js"></script>
   </body>
</html>