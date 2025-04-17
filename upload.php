<?php 

    require "assets/php/cfg.php";

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
        $description = $_POST['description'];
		
		$folder = getcwd();
		
		$path = $folder."users\\".$user['username']."\\".$file_name;
		
		if(move_uploaded_file($tmp_name, $path)){
			
            $conn->query("INSERT INTO files VALUES ('$user[id]', '{$_POST['name']}', '$description', '$file_name', '$tmp_name')");
			echo "<script>alert('A fájl sikeresen feltöltve!')</script>";

        } else {
            echo "<script>alert('A fájl feltöltése sikertelen!')</script>"; 
        }
	}

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
            <li><a href="myprofile.php">Profilom</a></li>
            <li><a href="search.php">Keresés</a></li>
            <?php
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
            <li><a href="roles/students/students.php">Diák felület</a></li>
            <li><a href="logout.php">Kijelentkezés</a></li>
        </ul>
    </nav>
        <form method="post" enctype="multipart/form-data">
        <label class="form-header">Anyag feltöltése</label>
        <input type="text" name="name" placeholder="Anyag neve">
        <input type="file" name="upload-file">
        <input type="submit" name="upload-btn">
    </form>
    <script src="assets/js/script.js"></script>
   </body>
</html>