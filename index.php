<?php
    require  "assets/php/cfg.php";

    if(!isset($_COOKIE['id'])){
        header("Location: reg.php");
    }

    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    if(isset($_POST['comment-btn'])){
    
            $postid = $_GET['postid'];
            $text = $_POST['comment-text'];
            $conn->query("INSERT INTO comments (userid, postid, text) VALUES ('$user[id]', '$postid', '$text')");
            $uploader = $_GET['uploader'];
            $conn->query("INSERT INTO notifys (fromid, toid, notifytype, readed) VALUES ('$user[id]', '$uploader', 'comment', 0)");
        
    } else {
        echo "<script>alert('Hiba történt a komment írásakor!');</script>";
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
            <li><a href="assets/php/logout.php">Kijelentkezés</a></li>
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

            $sql = "SELECT * FROM files ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($file = $result->fetch_assoc()) {
                    echo "<div>";
                    if(!empty($file)) {
                        $sql = "SELECT * FROM users WHERE id=" . $file['uploaded_by'];
                        $uploader_result = $conn->query($sql);
                        $uploader = $uploader_result->fetch_assoc();                         

                        $folder = getcwd();
                        echo "<div>";
                        echo "<h4>" .$file['name']. "</h4>";
                        echo "<p>" . $file['description'] . "</p>"; 
                        $file_extension = pathinfo($file['file_name'], PATHINFO_EXTENSION);
                        if ($file_extension === 'docx') {
                            echo "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=" . urlencode("users/" . $uploader['username'] . "/" . $file['file_name']) . "'></iframe>";
                        } elseif ($file_extension === 'mp4') {
                            echo "<video controls>
                                    <source src='users/" . $uploader['username'] . "/" . $file['file_name'] . "' type='video/mp4'>
                                    A te böngésződ nem támogatja a videocímkét.
                                  </video>";
                        } elseif ($file_extension === 'pdf') {
                            echo "<iframe src='users/" . $uploader['username'] . "/" . $file['file_name'] . "' width='100%' height='500px'></iframe>";
                        }

                        echo "<p><b>Tárgy:</b> " . $file['subject'] . "</p>";
                        echo "<a href='assets/php/download.php?id=" . $file['id'] . "'>Letöltés</a>";
                        echo "</div>";                   
                        echo "<p>Feltöltötte: <a href='profile.php?userid=" . $file['uploaded_by'] . "'>" . $uploader['username'] . "</a></p>";
                        echo "<p><b>Címkék:</b> " . $file['tags'] . "</p>";
                        if ($_COOKIE['id'] == $file['uploaded_by']) {
                            echo "<form method='POST' action='assets/php/delete.php'>";
                            echo "<input type='hidden' name='file_id' value='" . $file['id'] . "'>";
                            echo "<button type='submit'>Törlés</button>";
                            echo "</form>";
                        } 
                            
                        echo "<form method='post' action='index.php?postid=$file[id]&uploader=$file[uploaded_by]'>";
                        echo "<input type='text' name='comment-text' placeholder='Komment írása...'>";
                        echo "<input type='submit' name='comment-btn'>";
                        echo "</form>";
                                
                        $sql = "SELECT * FROM comments WHERE postid=$file[id]";
                        $foundend_comments = $conn->query($sql);
                        
                        if(mysqli_num_rows($foundend_comments) > 0){
                            echo '<p>';
                            while($comment=$foundend_comments->fetch_assoc()){   
                                $sql = "SELECT * FROM users WHERE id=$comment[userid]"; 
                                $founded_commenter = $conn->query($sql);
                                $commenter = $founded_commenter->fetch_assoc();
                                        
                                echo "<b>".$commenter['username'].":</b> ".$comment['text']."<br>";
                                }
                        }
                    } else {
                        echo "<p>Nem található a fájl!</p>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>Nincsenek feltöltött fájlok.</p>";
            }
        ?>
    </div>
    <script src="assets/js/script.js"></script>
   </body>
</html>