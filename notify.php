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
            
            $conn->query("DELETE FROM notifys WHERE toid = $user[id]");
            
        }
        
        echo "<form method='post'>";
        echo "	<input type='submit' name='del-notifs-btn' value='Értesítések törlése'>";
        echo "</form>";
        
        $sql = "SELECT * FROM notifys WHERE toid = $user[id] ORDER BY id DESC";
        $founded_notifys = $conn->query($sql);
        while($ertesites=$founded_notifys->fetch_assoc()){
            
            $from = $ertesites['fromid'];  
            
            $sql = "SELECT * FROM users WHERE id=$from";
            $founded_notifyer = $conn->query($sql);
            $notifyer = $founded_notifyer->fetch_assoc();
            
            if($ertesites['notifytype'] == "friend"){
                
                if($ertesites['readed'] == 0){
                    
                    echo "<p><b>$notifyer[username]</b> barátnak jelölt!</p>";
                    
                } else {
                    
                    echo "<p><b>$notifyer[username]</b> barátnak jelölt!</p>";
                    
                }
            } else if($ertesites['notifytype'] == 'comment'){
                
                if($ertesites['readed'] == 0){
                    
                    echo "<p><b>$notifyer[username]</b> hozzászólt egy posztodhoz!</p>";
                    
                } else {
                    
                    echo "<p><b>$notifyer[username]</b> hozzászólt egy posztodhoz!</p>";
                }
            }
        }
        
        $conn->query("UPDATE ertesitesek SET olvasott = 1 WHERE ertesitettid = $user[id]");
        
    ?>
   </body>
</html>