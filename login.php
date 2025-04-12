<?php 

    require "assets/php/cfg.php";
	session_start();
	
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
       <title>Bejelentkezés</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel="stylesheet" href="assets/css/style.css">
   </head>
   <body>
        <h1>Bejelentkezés</h1>
        <form method="post">
             <label for="username">Felhasználónév:</label><br>
             <input type="text" id="username" name="username"><br><br>
             <label for="password">Jelszó:</label><br>
             <input type="password" id="password" name="password"><br><br>
             <input type="submit" name="login-btn" value="Bejelentkezés">
        </form>
        <p>Még nincs fiókod? <a href="reg.php">Regisztrálj itt!</a></p>
        <p>Elfelejtett jelszó? <a href="forgotpass.php">Kérj újat!</a></p>
    <script src="assets/js/script.js"></script>
   </body>
</html>