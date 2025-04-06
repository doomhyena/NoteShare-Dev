<!DOCTYPE html>
<html>
   <head>
       <title>Elfelejtett Jelszó</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   </head>
   <body>
        <?php 
            require "cfg.php";

            if(isset($_POST['forg-btn'])){
                $username = $_POST['username'];
                $sql = "SELECT * FROM users WHERE username='$username'";
                $found_user = $conn->query($sql);
                
                if(mysqli_num_rows($found_user) > 0){
                    
                    $user = $found_user->fetch_assoc();
                    
                    echo "<form method='post' action='forgotpass.php?userid=$user[id]'>";
                    echo '	<input type="password" name="password1" placeholder="Jelszó">';
                    echo '	<input type="password" name="password2" placeholder="Jelszó újra">';
                    echo '	<input type="submit" name="new-pass-btn" placeholder="Elküldés">';
                    echo '</form>';
                    
                } else {
                    
                    echo "Nincs ilyen felhasználó!";
                    
                }
                
            } else if(isset($_POST['new-pass-btn'])) {
                
                $userid = $_GET['userid'];
                
                if($_POST['password1'] == $_POST['password2']){
                
                    $sql = "SELECT * FROM users WHERE id=$userid";
                    $found_user = $conn->query($sql);
                    $user = $found_user->fetch_assoc();
                    
                    if($_POST['password1'] != $user['password']){
                        
                        $password = $_POST['password1'];
                        $conn->query("UPDATE users SET password='$password' WHERE id=$userid");
                        
                        echo "A jelszavad sikeresen megváltozott!";
                        echo "<a href='login.php'>Bejelentkezés</a>";
                        
                    } else {
                        echo "Az új jelszavad nem egyezhet a régivel.";
                    }
                
                } else {
                    echo "A két jelszó nem egyezik!";
                }
            } else {
                echo '<h1>Add meg a felhasználónevedet!</h1>';
                echo '<form method="post">';
                echo '	<input type="text" name="username" placeholder="Felhasználónév">';
                echo '	<input type="submit" name="forg-btn" value="Elküldés">';
                echo '</form>';
            }
        ?>
   </body>
</html>