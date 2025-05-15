<?php

    require  "assets/php/cfg.php";
    
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
                <?php
                    echo "<li><a href='profile.php?userid=".$user['id']."'>Profilom</a></li>";
                ?>
                <li><a href="search.php">Keresés</a></li>
                <?php
                    
                    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
                    $founded_notify = $conn->query($sql);
                    $notify_number = mysqli_num_rows($founded_notify);

                    echo "<li><a href='notify.php'>Értesítések ($notify_number)</a></li>";
                    
                ?>
                <li><a href="messages.php">Üzenetek</a></li>
                <li><a href="assets/php/logout.php">Kijelentkezés</a></li>
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
                    echo "<p><b>$notifyer[username]</b> barátnak jelölt!</p>";
                
                    $check = $conn->query("SELECT * FROM friends WHERE fromid = $notifyer[id] AND toid = $user[id] AND status = 0");
                    if ($check->num_rows > 0) {
                        echo "
                            <form method='post' action='assets/php/accept_friend.php'>
                                <input type='hidden' name='fromid' value='$notifyer[id]'>
                                <input type='submit' value='Elfogadás'>
                            </form>
                        ";
                    }
                } else if($ertesites['notifytype'] == 'comment'){
                    
                    if($ertesites['readed'] == 0){
                        
                        echo "<p><b>$notifyer[username]</b> hozzászólt egy posztodhoz!</p>";
                        
                    } else {
                        
                        echo "<p><b>$notifyer[username]</b> hozzászólt egy posztodhoz!</p>";
                    }
                }
            }
            $conn->query("UPDATE notifys SET readed = 1 WHERE toid = $user[id]");
        ?>
        <footer>
            <p>Fejlesztők: Csontos Kincső, Szekeres Levente</p>
            <a href="https://github.com/doomhyena/NoteShare">GitHub</a>
            <hr>
            <p>&copy; 2025 NoteShare</p>
        </footer>
        <script src="assets/js/script.js"></script>
   </body>
</html>