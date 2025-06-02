<?php

    // Betölti az adatbázis kapcsolatot biztosító fájlt.
    require "assets/php/db.php";

    // Ellenőrzi, hogy a felhasználó be van-e jelentkezve (létezik-e az 'id' cookie).
    // Ha nincs, visszairányítja a kezdőlapra.
    if (!isset($_COOKIE['id'])) {
        header("Location: index.php");
    }

    // Lekéri a profilhoz tartozó felhasználó azonosítóját az URL-ből.
    $userid = $_GET['userid'];

    // Lekérdezi az adatbázisból a felhasználó adatait az adott azonosító alapján.
    $sql = "SELECT * FROM users WHERE id='" . $userid . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    // Ha a bejelentkezett felhasználó a saját profilját nézi:
    if ($_GET['userid'] == $_COOKIE['id']) {
        // Lekéri a bejelentkezett felhasználó adatait.
        $userid = $_COOKIE['id'];
        $sql = "SELECT * FROM users WHERE id='$userid'";
        $found_user = $conn->query($sql);
        $logged_in_user = $found_user->fetch_assoc();

        // Ha elküldték a profilkép feltöltő űrlapot:
        if (isset($_POST['pfp-btn']) && isset($_FILES['profile_picture'])) {

            $file_name = $_FILES['profile_picture']['name'];
            $tmp_name = $_FILES['profile_picture']['tmp_name'];

            // A mentési könyvtár
            $target_dir = __DIR__ . "/users/" . $logged_in_user['username'] . "/";
            $target_file = $target_dir . basename($file_name);

            // Ha a célkönyvtár nem létezik, létrehozza.
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Megpróbálja áthelyezni a feltöltött fájlt a célkönyvtárba.
            if (move_uploaded_file($tmp_name, $target_file)) {
                $conn->query("UPDATE users SET profile_picture='$file_name' WHERE id='$userid'");
            } else {
                echo "<p> Hiba történt a fájl feltöltésekor.</p>";
            }
        }
    }

    // Ha elküldték az email szerkesztő gombot, átirányít az email szerkesztő oldalra.
    if (isset($_POST['edit-email-btn'])) {
        header("Location: edit_email.php");
    }

    // Lekérdezi, hogy hány olvasatlan értesítése van a felhasználónak.
    $sql = "SELECT * FROM notifys WHERE toid = $user[id] AND readed = 0";
    $founded_notify = $conn->query($sql);
    $notify_number = mysqli_num_rows($founded_notify);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Profil</title>
    <meta charset='UTF-8'>
    <meta name='description' content='Iskolai jegyzeteket megosztó oldal'>
    <meta name='keywords' content='iskola, jegyzet, megosztás, tanulás'>
    <meta name='author' content='Csontos Kincső, Szekeres Levente'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel='stylesheet' href='assets/css/styles.css'>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="assets/js/script.js"></script></head>
<body>
<?php
    // Betölti a navigációs sávot tartalmazó PHP fájlt.
    include 'assets/php/navbar.php';

    echo "<div class='profile-container'>";

    // Kiírja a felhasználó keresztnevét és azt, hogy "profilja:"
    echo "<h2 class='profile-heading'>" . $user['firstname'] . " profilja:</h2>";

    // Lekéri az aktuális munkakönyvtár elérési útját.
    $folder = getcwd();

    // Ha van profilkép feltöltve, akkor annak az elérési útját állítja be,
    // különben az alapértelmezett profilképet használja.
    if (!empty($user['profile_picture'])) {
        $profile_picture_path = "users/" . $user['username'] . "/" . $user['profile_picture'];
    } else {
        $profile_picture_path = "assets/img/default_profile_picture.jpg";
    }

    echo "<div class='profile-card'>";

    // Megjeleníti a profilképet.
    echo "<img class='profile-picture' src='" . $profile_picture_path . "' alt='Profilkép'>";

    // Ha a megtekintett profil a bejelentkezett felhasználóé, akkor megjeleníti a profilkép feltöltő űrlapot.
    if ($_GET['userid'] == $_COOKIE['id']) {
        echo "<form class='profile-upload-form' method='POST' enctype='multipart/form-data' style='margin-bottom: 15px;'>";
        echo "<label for='profile_picture' class='profile-info'><b>Profilkép feltöltése:</b></label><br>";
        echo "<input type='file' name='profile_picture' id='profile_picture' accept='image/*' style='margin-top: 8px;'><br><br>";
        echo "<input type='submit' name='pfp-btn' value='Feltöltés!' class='edit-email-btn'>";
        echo "</form>";

        // Külön űrlap az email szerkesztéshez
        echo "<form method='POST' style='margin-top: 10px;'>";
        echo "<input type='submit' name='edit-email-btn' value='Email szerkesztése' class='edit-email-btn'>";
        echo "</form>";
    }

    // Kiírja a felhasználó nevét és felhasználónevét.
    echo "<p class='profile-info'>Név: " . $user['firstname'] . " " . $user['lastname'] . "</p>";
    echo "<p class='profile-info'>Felhasználónév: " . $user['username'] . "</p>";

    // Ha a saját profilját nézi a felhasználó, akkor kiírja az email címet, és a regisztráció dátumát.
    if ($_GET['userid'] == $_COOKIE['id']) {
        echo "<p class='profile-info'>Email: " . $user['email'] . "</p>";

        echo "<p class='profile-info'>Regisztráció dátuma: " . $user['registration_date'] . "</p>";
    }

    echo "</div>";

			// Ha nem a saját profilját nézi a felhasználó, akkor megjeleníti a "Barátnak jelölés" űrlapot.
            $sql = "SELECT * FROM friends WHERE (fromid='" . $_COOKIE['id'] . "' AND toid='" . $_GET['userid'] . "') OR (fromid='" . $_GET['userid'] . "' AND toid='" . $_COOKIE['id'] . "')";
            $result = $conn->query($sql);
            // Ellenőrzi, hogy van-e már barátság vagy barátfelkérés a két felhasználó között.
            if ($result->num_rows > 0) {
                // Ha van, akkor kiírja, hogy már barátok.
                $friendship = $result->fetch_assoc();
                echo "<p class='profile-info'>Barátság státusz: ";
                if ($friendship['fromid'] == $_COOKIE['id']) {
                    echo "Te küldted a barátfelkérést.";
                } elseif ($friendship['toid'] == $_COOKIE['id']) {
                    echo "A felhasználó küldött neked barátfelkérést.";
                } else {
                    echo "Ti már barátok vagytok!";
                }
            } else {
                // Ha nincs, akkor megjeleníti a "Barátnak jelölés" űrlapot.
                if ($_GET['userid'] != $_COOKIE['id']) {
                    $toid = $_GET['userid'];
                    echo "<form method='post' action='assets/php/add_friend.php'>
                        <input type='hidden' name='toid' value='" . $_GET['userid'] . "'>
                        <input type='submit' value='Barátnak jelölés'>
                    </form>";
                }
            }

            // Lekérdezi az adott felhasználó által feltöltött fájlokat, legújabb elöl.
            $sql = "SELECT * FROM files WHERE uploaded_by='$user[id]' ORDER BY id DESC";
            $result = $conn->query($sql);

            // Ha vannak feltöltött fájlok, akkor végigmegy rajtuk.
            if ($result->num_rows > 0) {
                while ($file = $result->fetch_assoc()) {
                    // Ellenőrzi, hogy a fájlt tényleg a felhasználó töltötte-e fel.
                    if ($file['uploaded_by'] == $user['id']) {
                        echo "<div>";
                        if (!empty($file)) {
                            // Lekéri a feltöltő felhasználónevét.
                            $folder = getcwd();
                            $uploader_id = $file['uploaded_by'];
                            $uploader_query = $conn->query("SELECT username FROM users WHERE id='$uploader_id'");
                            $uploader = $uploader_query->fetch_assoc();

                            echo "<div class='file-card'>";
                            // Kiírja a fájl nevét, tárgyát, leírását.
                            echo "<h4>" . $file['name'] . "</h4>";
                            echo "<p class='file-meta'><b>Tárgy:</b> " . $file['subject'] . "</p>";
                            echo "<p class='file-desc'>" . $file['description'] . "</p>";

                            // Megnézi a fájl kiterjesztését, és annak megfelelően jeleníti meg.
                            $file_extension = pathinfo($file['file_name'], PATHINFO_EXTENSION);
                            if ($file_extension === 'docx') {
                                // Ha docx, figyelmeztet, hogy Word-ben nyisd meg.
                                echo "<p><b>Ez egy .docx fájl. A megtekintéshez töltsd le és nyisd meg Microsoft Word-ben.</b></p>";
                            } elseif ($file_extension === 'mp4') {
                                // Ha mp4, beágyazott videólejátszót jelenít meg.
                                echo "<video controls class='file-preview'>
                                        <source src='users/" . $uploader['username'] . "/" . $file['file_name'] . "' type='video/mp4'>
                                        A te böngésződ nem támogatja a videocímkét.
                                    </video>";
                            } elseif ($file_extension === 'pdf') {
                                // Ha pdf, iframe-ben jeleníti meg.
                                echo "<iframe src='users/" . $uploader['username'] . "/" . $file['file_name'] . "' width='100%' height='500px'></iframe>";
                            }

                            // Letöltési linket jelenít meg.
                            echo "<a class='download-link' href='assets/php/download.php?id=" . $file['id'] . "'>Letöltés</a>";
                            echo "</div>";

                            // Kiírja a fájl címkéit.
                            echo "<p class='file-tags'><b>Címkék:</b> " . $file['tags'] . "</p>";

                            // Ha a bejelentkezett felhasználó töltötte fel a fájlt,
                            // akkor törlési lehetőséget is ad.
                            if ($_COOKIE['id'] == $file['uploaded_by']) {
                                echo "<form class='delete-form' method='POST' action='assets/php/delete.php'>";
                                echo "<input type='hidden' name='file_id' value='" . $file['id'] . "'>";
                                echo "<button type='submit'>Törlés</button>";
                                echo "</form>";
                            }
                        } else {
                            // Ha nincs fájl, hibaüzenetet ír ki.
                            echo "<p>Nem található a fájl!</p>";
                        }
                        echo "</div>";
                    }
                }
            } else {
                // Ha nincs feltöltött fájl, erről tájékoztat.
                echo "<p>Nincsenek feltöltött fájlok.</p>";
            }
			echo "</div>";
            // Betölti a láblécet tartalmazó PHP fájlt.
            include 'assets/php/footer.php';
        ?>
   </body>
</html>
