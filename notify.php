<?php

    require  "assets/php/db.php";
    
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
	   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	   <script src="assets/js/script.js"></script>
   </head>
   <body>
        <?php
            // Betölti a navigációs sávot
            include 'assets/php/navbar.php';

            // Ellenőrzi, hogy a "Értesítések törlése" gombot megnyomták-e
            if(isset($_POST['del-notifs-btn'])){
                
                // Törli az összes értesítést, ami a bejelentkezett felhasználónak szól
                $conn->query("DELETE FROM notifys WHERE toid = $user[id]");
                
            }

            // Lekérdezi az összes értesítést a bejelentkezett felhasználónak, legújabb elöl
            $sql = "SELECT * FROM notifys WHERE toid = $user[id] ORDER BY id DESC";
            $founded_notifys = $conn->query($sql);

            // Végigmegy az összes értesítésen
            while($ertesites=$founded_notifys->fetch_assoc()){
                
                // Lekéri az értesítést küldő felhasználó azonosítóját
                $from = $ertesites['fromid'];  
                
                // Lekéri az értesítést küldő felhasználó adatait
                $sql = "SELECT * FROM users WHERE id=$from";
                $founded_notifyer = $conn->query($sql);
                $notifyer = $founded_notifyer->fetch_assoc();
                
                // Ha az értesítés típusa "friend" (barátjelölés)
                if($ertesites['notifytype'] == "friend"){
                    echo "<p><b>$notifyer[username]</b> barátnak jelölt!</p>";
                
                    $check = $conn->query("SELECT * FROM friends WHERE fromid = $notifyer[id] AND toid = $user[id] AND status = 0");
					
                    if ($check->num_rows > 0) {
                        echo "
                            <form class='accept-friend' method='post' action='assets/php/accept_friend.php'>
                                <input type='hidden' name='fromid' value='$notifyer[id]'>
                                <input type='submit' value='Elfogadás'>
                            </form>
                        ";
                    }else {
                        echo "<p>Már feldolgozott barátjelölés.</p>"; // <-- új sor
                    }
                } else if($ertesites['notifytype'] == 'comment'){
                    
                    // Ha az értesítés még nincs olvasva
                    if($ertesites['readed'] == 0){
                        // Kiírja, hogy ki szólt hozzá egy poszthoz (olvasatlan)
                        echo "<p><b>$notifyer[username]</b> hozzászólt egy posztodhoz!</p>";
                    } else {
                        // Kiírja, hogy ki szólt hozzá egy poszthoz (olvasott)
                        echo "<p><b>$notifyer[username]</b> hozzászólt egy posztodhoz!</p>";
                    }
                }
            }

            // Az összes értesítést olvasottnak jelöli a felhasználónál
            $conn->query("UPDATE notifys SET readed = 1 WHERE toid = $user[id]");
			
			echo "<form method='post'>";
            echo "	<input type='submit' name='del-notifs-btn' value='Értesítések törlése'>";
            echo "</form>";

            // Betölti a láblécet
            include 'assets/php/footer.php';
        ?>
   </body>
</html>