<?php
    // Betölti az adatbázis kapcsolatot biztosító fájlt
    require  "assets/php/db.php";

    // Ellenőrzi, hogy van-e 'id' nevű süti (cookie), ha nincs, visszairányít a főoldalra
    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }

    // Lekéri a felhasználó adatait az adatbázisból a süti alapján
    $userid = $_COOKIE['id'];
    $sql = "SELECT * FROM users WHERE id='$userid'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    // Ellenőrzi, hogy elküldték-e a feltöltési űrlapot
    if(isset($_POST['upload-btn'])){
        // Kimenti a tárgyat és a címkéket a POST adatokból
        $subject = $_POST['subject'];
        $tags = $_POST['tags'];

        // Ellenőrzi, hogy a tárgy vagy a címkék mező üres-e
        if (empty($subject) || empty($tags)) {
            echo "<script>alert('Kérjük, adja meg a tárgyat és a címkéket!')</script>";
            exit;
        }
        // Kimenti a feltöltött fájl nevét és ideiglenes elérési útját
        $file_name = $_FILES['upload-file']['name'];
        $tmp_name = $_FILES['upload-file']['tmp_name'];
        // Megállapítja a fájl MIME-típusát és kiterjesztését
        $file_type = mime_content_type($tmp_name);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Meghatározza az engedélyezett kiterjesztéseket és MIME-típusokat
        $allowed_extensions = ['pdf', 'mp4', 'docx'];
        $allowed_types = ['application/pdf', 'video/mp4', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        // Ellenőrzi, hogy a fájl típusa és kiterjesztése engedélyezett-e
        if (!in_array($file_ext, $allowed_extensions) || !in_array($file_type, $allowed_types)) {
            echo "<script>alert('Csak PDF, MP4 vagy DOCX fájlokat lehet feltölteni!')</script>";
            header("Location: upload.php");
        }

        // Meghatározza a felhasználó mappájának elérési útját
        $folder = getcwd();
        $dir = $folder . "/users/" . $user['username'] . "/";

        // Ha a mappa nem létezik, létrehozza azt
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true); 
        }

        // Kimenti a leírást a POST adatokból
        $description = $_POST['description'];
        // Meghatározza a feltöltendő fájl végleges elérési útját
        $path =  $folder . "/users/" . $user['username'] . "/".$file_name;

        // Megpróbálja áthelyezni a feltöltött fájlt a végleges helyére
        if(move_uploaded_file($tmp_name, $path)){
            // Sikeres feltöltés esetén elmenti az adatokat az adatbázisba
            $conn->query("INSERT INTO files (uploaded_by, name, file_name, description, file_path) VALUES ('$user[id]', '{$_POST['name']}', '$file_name', '$description', '$path')");
            echo "<script>alert('A fájl sikeresen feltöltve!')</script>";
			header("Location: upload.php");
        } else {
            // Sikertelen feltöltés esetén hibaüzenetet ír ki
            echo "<script>alert('A fájl feltöltése sikertelen!')</script>";
			header("Location: upload.php");
        }
    }

    // Lekérdezi a felhasználó olvasatlan értesítéseinek számát
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
       	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	   <script src="assets/js/script.js"></script>
   </head>
   <body>
        <?php
            include 'assets/php/navbar.php';
        ?>
        <form class= "upload" method="post" enctype="multipart/form-data">
            <label class="form-header">Anyag feltöltése</label>
            <input type="text" name="name" placeholder="Anyag neve">
            <textarea name="description" placeholder="Leírás az anyagról"></textarea>
            <input type="text" name="subject" placeholder="Tárgy (pl. fizika, történelem)">
            <input type="text" name="tags" placeholder="Kulcsszavak, címkék (pl. ZH, jegyzet, beadandó)">
            <div class="file-input-wrapper">
			<span class="file-icon">📁</span>
			<input type="file" name="upload-file">
			</div>
            <input type="submit" name="upload-btn" value="Feltöltés">
        </form>
        <?php
            include 'assets/php/footer.php';
        ?>
   </body>
</html>