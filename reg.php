<?php 

require dirname(__FILE__)."assets/php/cfg.php";

if(isset($_POST['reg-btn'])){
    
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $username = $_POST['username'];
    $password = $_POST['password1'];
    $passwordtwo = $_POST['password2'];
    $security_questions = [
        "Mi a kedvenc könyved?",
        "Mi volt az első háziállatod neve?",
        "Mi az édesanyád leánykori neve?",
        "Mi a születési városod?",
        "Mi a kedvenc ételed?"
    ];
    $selected_question = $security_questions[array_rand($security_questions)];
    $security_answer = $_POST['security_answer'];
    $sql = "SELECT * FROM users WHERE username='$username'";
    $found_user = $conn->query($sql);
    
    if(mysqli_num_rows($found_user) == 0){
        if($password == $passwordtwo){
            $titkositott_jelszo = password_hash($password, PASSWORD_DEFAULT);
            $titkositott_valasz = password_hash($security_answer, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO users VALUES(id, '$lastname', '$firstname', '$username', '$selected_question', '$titkositott_valasz', '$titkositott_jelszo')");
            $folder = getcwd();
        
            $path = $folder."\\users\\".$username;
            
            if(mkdir($path, 7777)){
                echo "<script>alert('Tárhely sikeresen létrehozva!')</script>";
            } else {
                echo "<script>alert('Nem sikerült létrehozni a tárhelyet!')</script>";
            }
        } else {
            echo "<script>alert('A jelszavak nem egyeznek!')</script>";
        }
    } else {
        echo "<script>alert('Már létezik ilyen felhasználó!')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Regisztráció</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>

        <h1>Regisztráció</h1>
        <form method="post">
            <label for="lastname">Vezetéknév:</label><br>
            <input type="text" name="lastname"><br><br>
            <label for="lastname">Keresztnév:</label><br>
            <input type="text" name="firstname"><br><br>
            <label for="username">Felhasználónév:</label><br>
            <input type="text" name="username"><br><br>
            <label for="password">Jelszó:</label><br>
            <input type="password" name="password1"><br><br>
            <label for="password">Jelszó újra:</label><br>
            <input type="password" name="password2"><br><br>
            <label for="security_question">Biztonsági kérdés:</label><br>
            <input type="text" name="security_question" value="<?php echo $selected_question; ?>" readonly><br><br>
            <label for="security_answer">Válasz:</label><br>
            <input type="text" name="security_answer"><br><br>
            <input type="submit" name="reg-btn" value="Regisztráció!">
        </form>
        <label>Már van fiókod? <a href="login.php">Jelentkezz be!</a></label>
    <script src="assets/js/script.js"></script>
   </body>
</html>