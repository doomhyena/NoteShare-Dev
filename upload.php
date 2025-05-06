<?php 

    require  "assets/php/cfg.php";

    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }

	$userid = $_COOKIE['id'];
    $sql = "SELECT * FROM users WHERE id='$userid'";
    $found_user = $conn->query($sql);
	$user = $found_user->fetch_assoc();


	if(isset($_POST['upload-btn'])){
		
        $file_name = $_FILES['upload-file']['name'];
        $tmp_name = $_FILES['upload-file']['tmp_name'];
        $file_type = mime_content_type($tmp_name);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
        $allowed_extensions = ['pdf', 'mp4', 'docx'];
        $allowed_types = ['application/pdf', 'video/mp4', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        if (!in_array($file_ext, $allowed_extensions) || !in_array($file_type, $allowed_types)) {
            echo "<script>alert('Csak PDF, MP4 vagy DOCX fájlokat lehet feltölteni!')</script>";
            exit;
        }
    
        $folder = getcwd();
        $dir = $folder . "/users/" . $user['username'] . "/";

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true); 
        }

        $description = $_POST['description'];
        $path =  $folder . "/users/" . $user['username'] . "/".$file_name;

		if(move_uploaded_file($tmp_name, $path)){
			
            $conn->query("INSERT INTO files (uploaded_by, name, file_name, description, file_path) VALUES ('$user[id]', '{$_POST['name']}', '$file_name', '$description', '$path')");
          echo "<script>alert('A fájl sikeresen feltöltve!')</script>";

        } else {
            echo "<script>alert('A fájl feltöltése sikertelen!')</script>"; 
        }
	}

    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
    $founded_notify = $conn->query($sql);
    $notify_number = mysqli_num_rows($founded_notify); 

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Feltöltés</title>
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
        <form method="post" enctype="multipart/form-data">
        <label class="form-header">Anyag feltöltése</label>
        <input type="text" name="name" placeholder="Anyag neve">
        <textarea name="description" placeholder="Leírás az anyagról"></textarea>
        <input type="file" name="upload-file">
        <input type="submit" name="upload-btn">
    </form>
    <script src="assets/js/script.js"></script>
   </body>
</html>