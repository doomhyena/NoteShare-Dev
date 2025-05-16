<?php 

    require  "assets/php/db.php";

    $security_questions = [
        "Mi a kedvenc könyved?",
        "Mi volt az első háziállatod neve?",
        "Mi az édesanyád leánykori neve?",
        "Mi a születési városod?",
        "Mi a kedvenc ételed?"
    ];
    $selected_question = $security_questions[array_rand($security_questions)];

    if(isset($_POST['reg-btn'])){
        
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password1'];
        $passwordtwo = $_POST['password2'];
        $registration_date = date('Y-m-d H:i:s');

        $security_answer = $_POST['security_answer'];
        $sql = "SELECT * FROM users WHERE username='$username'";
        $found_user = $conn->query($sql);
        
        if(mysqli_num_rows($found_user) == 0){
            $sql = "SELECT * FROM users WHERE email='$email'";
            $found_email = $conn->query($sql); 

            if(mysqli_num_rows($found_email) == 0) {
                if($password == $passwordtwo){
                $titkositott_jelszo = password_hash($password, PASSWORD_DEFAULT);
                $conn->query("INSERT INTO users (lastname, firstname, username, email, password, security_question, security_answer, registration_date) VALUES ('$lastname', '$firstname', '$username', '$email', '$titkositott_jelszo', '$selected_question', '$security_answer', '$registration_date')");
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
                echo "<script>alert('Már létezik ilyen email cím!')</script>";
            }
        } else {
            echo "<script>alert('Már létezik ilyen felhasználó!')</script>";
        }
    }
	
	if(isset($_POST['login-btn'])){
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sql = "SELECT * FROM users WHERE username='$username'";
		$found_user = $conn->query($sql);
		
		if(mysqli_num_rows($found_user) > 0){
			
			$user = $found_user->fetch_assoc();
			
			if(password_verify($password, $user['password'])){
				setcookie("id", $user['id'], time() + 3600, "/");
				header("Location: index.php");
			} else {
                echo "<script>alert('Hibás jelszó!')</script>";
			}
		} else {
			echo "<script>alert('Nincs ilyen felhasználó!')</script>";
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
            include 'assets/php/footer.php';
        ?>
        <script src="assets/js/script.js"></script>
   </body>
</html>