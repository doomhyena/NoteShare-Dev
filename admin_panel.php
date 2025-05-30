<?php
    require "assets/php/db.php";

    if(!isset($_COOKIE['id'])){
        header("Location: index.php");
    }

    $sql = "SELECT * FROM users WHERE id='" . $conn->real_escape_string($_COOKIE['id']) . "'";
    $found_user = $conn->query($sql);
    $current_user = $found_user->fetch_assoc();
    if (!$current_user) {
        header("Location: index.php");
    }

    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="hu">
   <head>
       <title>Admin Panel</title>
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
        // Betölti a navigációs sávot.
        include 'assets/php/navbar.php';

        // Ellenőrzi, hogy a jelenlegi felhasználó admin-e.
        if ($current_user['admin'] != 1) {  
            // Ha nem admin, hibaüzenetet ír ki.
            echo "<h2>Nincs jogosultságod az admin felület megtekintéséhez.</h2>";
            // Betölti a láblécet.
            include 'assets/php/footer.php';
            // Lezárja a HTML-t és kilép a szkriptből.
            echo '</body></html>';
            exit();
        }

        // Ellenőrzi, hogy törlési kérés érkezett-e GET paraméterben.
        if (isset($_GET['delete_type']) && isset($_GET['delete_id'])) {
            $type = $_GET['delete_type']; // Törlendő elem típusa (user, file, comment, category)
            $id = intval($_GET['delete_id']); // Törlendő elem azonosítója (egész számra alakítva)
            switch ($type) {
                case 'user':
                    // Felhasználó törlése, de saját magát nem törölheti az admin.
                    if ($id != $current_user['id']) {
                        // Felhasználó törlése az adatbázisból.
                        $conn->query("DELETE FROM users WHERE id=$id");
                        // Felhasználó által feltöltött fájlok törlése.
                        $conn->query("DELETE FROM files WHERE uploaded_by=$id");
                        // Felhasználó hozzászólásainak törlése.
                        $conn->query("DELETE FROM comments WHERE userid=$id");
                    }
                    break;
                case 'file' :
                    // Fájl törlése az adatbázisból.
                    $conn->query("DELETE FROM files WHERE id=$id");
                    // A fájlhoz tartozó hozzászólások törlése.
                    $conn->query("DELETE FROM comments WHERE postid=$id");
                    break;
                case 'comment':
                    // Hozzászólás törlése.
                    $conn->query("DELETE FROM comments WHERE id=$id");
                    break;
                case 'category':
                    // Kategória törlése: a fájlok subject mezőjét üresre állítja.
                    if (isset($_GET['subject'])) {
                        $subject = $conn->real_escape_string($_GET['subject']);
                        $conn->query("UPDATE files SET subject='' WHERE subject='$subject'");
                    }
                    break;
            }
            // Oldal újratöltése a törlés után.
            echo "<script>location.href='admin_panel.php';</script>";
        }

        // Felhasználók lekérdezése az adatbázisból, csökkenő ID sorrendben.
        $users = $conn->query("SELECT * FROM users ORDER BY id DESC");
        // Fájlok lekérdezése az adatbázisból, csökkenő ID sorrendben.
        $files = $conn->query("SELECT * FROM files ORDER BY id DESC");
        // Hozzászólások lekérdezése, a felhasználónevekkel együtt, csökkenő ID sorrendben.
        $comments = $conn->query("SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.userid=users.id ORDER BY comments.id DESC");
        // Kategóriák (subject mező) lekérdezése, csak az egyedi, nem üres értékek, ABC sorrendben.
        $categories = $conn->query("SELECT DISTINCT subject FROM files WHERE subject != '' ORDER BY subject ASC");
    ?>
    <!-- Felhasználók kezelése -->
    <h2>Felhasználók kezelése</h2>
    <table>
        <tr>
            <th>ID</th><th>Név</th><th>Felhasználónév</th><th>Email</th><th>Admin</th><th>Művelet</th>
        </tr>
        <?php 
        // Végigmegy az összes felhasználón és kiírja őket a táblázatba
        while($user = $users->fetch_assoc()) { ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['lastname'] . ' ' . $user['firstname'] ?></td>
            <td><?= $user['username'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['admin'] == 1 ? 'Igen' : 'Nem' ?></td>
            <td>
                <?php 
                // Csak akkor jelenik meg a törlés gomb, ha nem a saját fiók
                if ($user['id'] != $current_user['id']) { ?>
                    <a href="?delete_type=user&delete_id=<?= $user['id'] ?>" onclick="return confirm('Biztosan törlöd ezt a felhasználót?')">Törlés</a>
                <?php } else { ?>
                    Saját fiók
                <?php } ?>
            </td>
        </tr>
        <?php }; ?>
    </table>

    <!-- Fájlok kezelése -->
    <h2>Fájlok kezelése</h2>
    <table>
        <tr>
            <th>ID</th><th>Név</th><th>Leírás</th><th>Kategória</th><th>Feltöltő</th><th>Művelet</th>
        </tr>
        <?php 
        // Végigmegy az összes fájlon és kiírja őket a táblázatba
        while($f = $files->fetch_assoc()) { 
            // Feltöltő felhasználónév lekérdezése
            $uploader = $conn->query("SELECT username FROM users WHERE id=" . intval($f['uploaded_by']))->fetch_assoc();
        ?>
        <tr>
            <td><?= $f['id'] ?></td>
            <td><?= $f['name'] ?></td>
            <td><?= $f['description'] ?></td>
            <td><?= $f['subject'] ?></td>
            <td><?= $uploader['username'] ?? 'Ismeretlen' ?></td>
            <td>
                <a href="?delete_type=file&delete_id=<?= $f['id'] ?>" onclick="return confirm('Biztosan törlöd ezt a fájlt?')">Törlés</a>
            </td>
        </tr>
        <?php }; ?>
    </table>

    <!-- Kommentek kezelése -->
    <h2>Kommentek kezelése</h2>
    <table>
        <tr>
            <th>ID</th><th>Felhasználó</th><th>Fájl ID</th><th>Szöveg</th><th>Művelet</th>
        </tr>
        <?php 
        // Végigmegy az összes kommenten és kiírja őket a táblázatba
        while($c = $comments->fetch_assoc()) { ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['username'] ?></td>
            <td><?= $c['postid'] ?></td>
            <td><?= $c['text'] ?></td>
            <td>
                <a href="?delete_type=comment&delete_id=<?= $c['id'] ?>" onclick="return confirm('Biztosan törlöd ezt a kommentet?')">Törlés</a>
            </td>
        </tr>
        <?php }; ?>
    </table>

    <!-- Kategóriák kezelése -->
    <h2>Kategóriák kezelése</h2>
    <table>
        <tr>
            <th>Kategória</th><th>Művelet</th>
        </tr>
        <?php 
        // Végigmegy az összes kategórián és kiírja őket a táblázatba
        while($cat = $categories->fetch_assoc()) { ?>
        <tr>
            <td><?= $cat['subject'] ?></td>
            <td>
                <a href="?delete_type=category&subject=<?= urlencode($cat['subject']) ?>" onclick="return confirm('Biztosan törlöd ezt a kategóriát? (A fájlokból eltávolítja a kategóriát)')">Törlés</a>
            </td>
        </tr>
        <?php }; ?>
    </table>
    </div>
    <?php
        // Lábléc betöltése
        include 'assets/php/footer.php';
    ?>
   </body>
</html>