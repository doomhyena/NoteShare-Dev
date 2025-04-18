<?php
    require "assets/php/cfg.php";
    session_start();
    
    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();
    
    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
    $founded_notify = $conn->query($sql);
    $notify_number = mysqli_num_rows($founded_notify);
?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Értesítések</title>
       <meta charset='UTF-8'>
       <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
       <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
       <meta name='author' content='Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>
   <nav>
        <ul>
            <li><a href="index.php">Főoldal</a></li>
			<li><a href="upload.php">Feltöltés</a></li>
            <li><a href="profile.php">Profilom</a></li>
            <li><a href="search.php">Keresés</a></li>
            <?php
                echo "<li><a href='notify.php'>Értesítések ($notify_number)</a></li>";
                if ($user['admin'] == 1) {
                    echo '<li><a href="roles/admin/admin.php">Admin</a></li>';
                }
            ?>
            <?php
                if ($user['teacher'] == 1) {
                    echo '<li><a href="roles/teacher/teacher.php">Admin</a></li>';
                }
            ?>
            <li><a href="roles/students/students.php">Diák felület</a></li>
            <li><a href="logout.php">Kijelentkezés</a></li>
        </ul>
    </nav>
    <?php
        require "assets/php/cfg.php";

        if(isset($_POST['del-notifs-btn'])){
            
            $conn->query("DELETE FROM ertesitesek WHERE ertesitettid=$id");
            
        }
        
        echo "<form method='post'>";
        echo "	<input type='submit' name='del-notifs-btn' value='Értesítések törlése'>";
        echo "</form>";
        
        $lekerdezes = "SELECT * FROM ertesitesek WHERE ertesitettid=$id ORDER BY id DESC";
        $talalt_ertesitesek = $conn->query($lekerdezes);
        while($ertesites=$talalt_ertesitesek->fetch_assoc()){
            
            $kitol = $ertesites['ertesitoid'];
            
            $lekerdezes = "SELECT * FROM users WHERE id=$kitol";
            $talalt_ertesito = $conn->query($lekerdezes);
            $ertesito = $talalt_ertesito->fetch_assoc();
            
            if($ertesites['notifytype'] == "friend"){
                
                if($ertesites['olvasott'] == 0){
                    
                    echo "<p style='color: red;'><b>$ertesito[username]</b> barátnak jelölt!</p>";
                    
                } else {
                    
                    echo "<p style='color: black;'><b>$ertesito[username]</b> bekövetett!</p>";
                    
                }
                
            }
            else if($ertesites['tipus'] == 'like'){
                
                if($ertesites['olvasott'] == "nem"){
                    
                    echo "<p style='color: red;'><b>$ertesito[username]</b> kedvelte egy posztodat!</p>";
                    
                }
                else{
                    
                    echo "<p style='color: black;'><b>$ertesito[username]</b> kedvelte egy posztodat!</p>";
                    
                }
                
            }
            else if($ertesites['tipus'] == 'komment'){
                
                if($ertesites['olvasott'] == "nem"){
                    
                    echo "<p style='color: red;'><b>$ertesito[username]</b> hozzászólt egy posztodhoz!</p>";
                    
                }
                else{
                    
                    echo "<p style='color: black;'><b>$ertesito[username]</b> hozzászólt egy posztodhoz!</p>";
                    
                }
                
            }
            
        }
        
        $conn->query("UPDATE ertesitesek SET olvasott='igen' WHERE ertesitettid=$id");
        
    ?>
   </body>
</html>