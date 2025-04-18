<?php
    require  dirname(__FILE__)."/assets/php/cfg.php";
    session_start();

    if (!isset($_COOKIE['id'])) {
        header('Location: reg.php');
    }
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
    $founded_notify = $conn->query($sql);
    $notify_number = mysqli_num_rows($founded_notify);

	if(isset($_POST['comment-btn'])){
		
		$postid = $_GET['postid'];
		$text = $_POST['comment-text'];
		$conn->query("INSERT INTO comments VALUES('$user[id]', $postid, '$text')");
		$uploader = $_GET['uploader'];
		$conn->query("INSERT INTO notifys VALUES'$user[id]', $uploader, 'comment', 0)");
		
	}

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Főoldal</title>
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
            <?php
                echo '<li><a href="'.dirname(__FILE__).'/index.php">Főoldal</a></li>';
                echo '<li><a href="'.dirname(__FILE__).'/upload.php">Feltöltés</a></li> ';
                echo '<li><a href="'.dirname(__FILE__).'/profile.php">Profilom</a></li> ';
                echo '<li><a href="'.dirname(__FILE__).'/search.php">Keresés</a></li>';
                echo "<li><a href=".dirname(__FILE__)."/notify.php'>Értesítések ($ertesitesek_szama)</a></li>";
                $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
                $found_user = $conn->query($sql);
                $user = $found_user->fetch_assoc();

                if ($user['admin'] == 1) {
                    echo '<li><a href='.dirname(__FILE__).'/roles/admin/admin.php">Admin</a></li>';
                }
                if ($user['teacher'] == 1) {
                    echo '<li><a href="'.dirname(__FILE__).'/roles/teacher/teacher.php">Tanári felület</a></li>';
                }
                echo '<li><a href="'.dirname(__FILE__).'/assets/php/logout.php">Kijelentkezés</a></li>';
            ?>
        </ul>
    </nav>
    <div>
        <?php
            echo "<h1>Üdv ". $user['firstname'] ." a NoteShare oldalán!</h1>";
            $today = date("m-d");
            $sql = "SELECT nevek FROM namedays WHERE datum='$today'";
            $result = $conn->query($sql);
            $nameday = "";
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nameday = $row['nevek'];
            } else {
                $nameday = "Nincs névnap ma.";
            }
            echo "<p>Mai névnap: " . $nameday . ", boldog névnapot kívánunk nekik!</p>";
            echo "<h3>Feltöltött fájlok:</h3>";

            $sql = "SELECT * FROM files WHERE uploaded_by='$user[id]' ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
             while ($file = $result->fetch_assoc()) {
                   echo "<div>";
                   if(!empty($file)) {
                    $folder = getcwd();
                    echo "<div>";
                    echo "<h4>" .$file['name']. "</h4>";
                    echo "<p>" . $file['description'] . "</p>"; 
                    echo "<iframe src='users/".$user['username']."/".$file['file_name']."'></iframe>";
                    echo "<a href='assets/php/download.php?id=" . $file['id'] . "'>Letöltés</a>";
                    echo "<p>Feltöltötte: <a href='profile.php?id=" . $user['id'] . "'>" . $user['username'] . "</a></p>";
                    if ($user['admin'] == 1) {
                        echo "<form method='POST' action='assets/php/delete.php'>";
                        echo "<input type='hidden' name='file_id' value='" . $file['id'] . "'>";
                        echo "<button type='submit'>Törlés</button>";
                        echo "</form>";
                    } else {
                        echo "<p>Nem található a fájl!</p>";
                    } 

                    echo "<form method='post' action='index.php?post=$file[id]&uploader=$file[uploaded_by]'>";
                    echo "<input type='text' name='comment-text' placeholder='Komment írása...'>";
                    echo "<input type='submit' name='comment-btn'>";
                    echo "</form>";
                    
                    $sql = "SELECT * FROM comments WHERE postid=$file[id]";
                    $foundend_comments = $conn->query($sql);
            
                    if(mysqli_num_rows($foundend_comments) > 0){
                        echo '<p>';
                        while($comment=$foundend_comments->fetch_assoc()){
                    
                            $sql = "SELECT * FROM users WHERE id=($comment[userid]";
                            $founded_commenter = $conn->query($sql);
                            $commenter = $founded_commenter->fetch_assoc();
                            
                            echo $commenter['username'].": ".$comment['text']."<br>";
                            }
                        }
                    }
                }  
            } else {
                echo "<p>Nincs feltöltött fájl.</p>";
                echo "</div>";
            }
        ?>
    </div>
    <script src="assets/js/script.js"></script>
   </body>
</html>