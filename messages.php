<?php

    require  "assets/php/cfg.php";

    if(!isset($_COOKIE['id'])){
        header("Location: reg.php");
    }

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Üzenetek</title>
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
			$sql = "SELECT * FROM friends WHERE fromid=$_COOKIE[id] AND status=1 OR toid=$_COOKIE[id] AND status=1";
			$founded_friendok = $conn->query($sql);
			while($friendsag=$founded_friendok->fetch_assoc()){
					
				if($friendsag['fromid'] != $_COOKIE['id']){
					$friendid = $friendsag['fromid'];
				} else {
					$friendid = $friendsag['toid'];
				}
					
				$sql = "SELECT * FROM users WHERE id=$friendid";
				$founded_friend = $conn->query($sql);
				$friend = $founded_friend->fetch_assoc();
		?>
		<a href="#"><?= $friend['username']; ?></a>
		<?php } ?>
		<form method="post">
			<input type="text" placeholder="Írj egy üzenetet...">
			<input type="submit" value="Küldés">
		</form>
    <script src="assets/js/script.js"></script>
   </body>
</html>