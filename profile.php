<?php

    // Betölti az adatbázis kapcsolatot biztosító fájlt.
    require  "assets/php/db.php";

    // Ellenőrzi, hogy a felhasználó be van-e jelentkezve (létezik-e az 'id' cookie).
    // Ha nincs, visszairányítja a kezdőlapra.
    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }

    // Lekéri a profilhoz tartozó felhasználó azonosítóját az URL-ből.
    $userid = $_GET['userid'];

    // Lekérdezi az adatbázisból a felhasználó adatait az adott azonosító alapján.
    $sql = "SELECT * FROM users WHERE id='" .$userid. "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    // Lekéri az aktuális munkakönyvtár elérési útját.
    $folder = getcwd();

    // Beállítja a profilkép feltöltési célkönyvtárát.
    $target_dir = $folder."users\\".$user['username']."\\";

    // Lekéri a feltöltött profilkép fájlnevét és ideiglenes nevét, ha van ilyen.
    $file_name = isset($_FILES['profile_picture']['name']) ? $_FILES['profile_picture']['name'] : '';
    $tmp_name = isset($_FILES['profile_picture']['tmp_name']) ? $_FILES['profile_picture']['tmp_name'] : '';

    // Beállítja a feltöltött fájl végleges elérési útját.
    $target_file = $target_dir . $file_name;

    // Ha a bejelentkezett felhasználó a saját profilját nézi:
    if ($_GET['userid'] == $_COOKIE['id']) {
        // Lekéri a bejelentkezett felhasználó adatait.
        $userid = $_COOKIE['id'];
        $sql = "SELECT * FROM users WHERE id='$userid'";
        $found_user = $conn->query($sql);
        $user = $found_user->fetch_assoc();

        // Ha elküldték a profilkép feltöltő űrlapot:
        if (isset($_POST['pfp-btn'])) {
            // Újra beállítja a feltöltési útvonalakat.
            $folder = getcwd();
            $target_dir = $folder."users\\".$user['username']."\\";
            $file_name = $_FILES['profile_picture']['name'];
            $tmp_name = $_FILES['profile_picture']['tmp_name'];
            $target_file = $target_dir . $file_name;

            // Ha a célkönyvtár nem létezik, létrehozza.
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); 
            }
            // Megpróbálja áthelyezni a feltöltött fájlt a célkönyvtárba.
            if (move_uploaded_file($tmp_name, $target_file)) {
                // Sikeres feltöltés esetén frissíti az adatbázisban a profilkép nevét.
                $conn->query("UPDATE users SET profile_picture='$file_name' WHERE id='$userid'");
            } else {
                // Hiba esetén üzenetet ír ki.
                echo "<p>Hiba történt a fájl feltöltésekor.</p>";
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
       <meta name='author' content='Bor Ádám, Csontos Kincső, Szekeres Levente'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
       <link rel='stylesheet' href='assets/css/styles.css'>
   </head>
   <body>
        <?php

            // Betölti a navigációs sávot tartalmazó PHP fájlt.
            include 'assets/php/navbar.php';

            // Kiírja a felhasználó keresztnevét és azt, hogy "profilja:"
            echo"<h2>".$user['firstname'] ." profilja:</h2>";

            // Lekéri az aktuális munkakönyvtár elérési útját.
            $folder = getcwd();

            // Ha van profilkép feltöltve, akkor annak az elérési útját állítja be,
            // különben az alapértelmezett profilképet használja.
            if (!empty($user['profile_picture'])) {
                $profile_picture_path = "users/".$user['username']."/".$user['profile_picture'];
            } else {
                $profile_picture_path = "assets/img/default_profile_picture.jpg";
            }

            // Megjeleníti a profilképet.
            echo "<img src='".$profile_picture_path."' alt='Profilkép'>";

            // Ha a megtekintett profil a bejelentkezett felhasználóé,
            // akkor megjeleníti a profilkép feltöltő űrlapot.
            if($_GET['userid'] == $_COOKIE['id']) {
                echo "<form method='POST' enctype='multipart/form-data'>
                    <label for='profile_picture'>Profilkép feltöltése:</label>
                    <input type='file' name='profile_picture' id='profile_picture' accept='image/*'>
                    <input type='submit' name='pfp-btn' value='Feltöltés!'>
                    </form>";
            }

            // Kiírja a felhasználó nevét és felhasználónevét.
            echo "<p>Név: " .$user['firstname']. " " . $user['lastname']. "</p>";
            echo "<p>Felhasználónév: " .$user['username']. "</p>";

            // Ha a saját profilját nézi a felhasználó,
            // akkor kiírja az email címet, szerkesztés gombot és a regisztráció dátumát.
            if($_GET['userid'] == $_COOKIE['id']) {
                echo "<p>Email: " .$user['email']. "</p>";
                echo "<button class='edit-email-btn'>Profil szerkesztése</button>";
                echo "<p>Regisztráció dátuma: " . $user['registration_date'] . "</p>";
            }

            // Ha nem a saját profilját nézi a felhasználó,
            // akkor megjeleníti a "Barátnak jelölés" űrlapot.
            if ($_GET['userid'] != $_COOKIE['id']) {
                $toid = intval($_GET['userid']);
                echo "<form method='post' action='assets/php/add_friend.php'>
                    <input type='hidden' name='toid' value='" . $_GET['userid'] . "'>
                    <input type='submit' value='Barátnak jelölés'>
                </form>";
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

                            echo "<div>";
                            // Kiírja a fájl nevét, tárgyát, leírását.
                            echo "<h4>" . $file['name'] . "</h4>";
                            echo "<p><b>Tárgy:</b> " . $file['subject'] . "</p>";
                            echo "<p>" . $file['description'] . "</p>";

                            // Megnézi a fájl kiterjesztését, és annak megfelelően jeleníti meg.
                            $file_extension = pathinfo($file['file_name'], PATHINFO_EXTENSION);
                            if ($file_extension === 'docx') {
                                // Ha docx, figyelmeztet, hogy Word-ben nyisd meg.
                                echo "<p><b>Ez egy .docx fájl. A megtekintéshez töltsd le és nyisd meg Microsoft Word-ben.</b></p>";
                            } elseif ($file_extension === 'mp4') {
                                // Ha mp4, beágyazott videólejátszót jelenít meg.
                                echo "<video controls>
                                        <source src='users/" . $uploader['username'] . "/" . $file['file_name'] . "' type='video/mp4'>
                                        A te böngésződ nem támogatja a videocímkét.
                                    </video>";
                            } elseif ($file_extension === 'pdf') {
                                // Ha pdf, iframe-ben jeleníti meg.
                                echo "<iframe src='users/" . $uploader['username'] . "/" . $file['file_name'] . "' width='100%' height='500px'></iframe>";
                            }

                            // Letöltési linket jelenít meg.
                            echo "<a href='assets/php/download.php?id=" . $file['id'] . "'>Letöltés</a>";
                            echo "</div>";

                            // Kiírja a fájl címkéit.
                            echo "<p><b>Címkék:</b> " . $file['tags'] . "</p>";

                            // Ha a bejelentkezett felhasználó töltötte fel a fájlt,
                            // akkor törlési lehetőséget is ad.
                            if ($_COOKIE['id'] == $file['uploaded_by']) {
                                echo "<form method='POST' action='assets/php/delete.php'>";
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

            // Betölti a láblécet tartalmazó PHP fájlt.
            include 'assets/php/footer.php';

        ?>
        <script src="assets/js/script.js"></script>
   </body>
</html>