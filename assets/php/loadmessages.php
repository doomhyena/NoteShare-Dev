<?php
    // Adatbázis kapcsolat betöltése
    require "db.php";

    // Ha nincs bejelentkezve a felhasználó (nincs id cookie), átirányítás a regisztrációs oldalra
    if (!isset($_COOKIE['id'])) {
        header("Location: reg.php");
        exit;
    }

    // Ha meg van adva a friendid GET paraméterben
    if (isset($_GET['friendid'])) {
        // Barát azonosító és saját azonosító lekérése
        $friendid = intval($_GET['friendid']);
        $userid = intval($_COOKIE['id']);

        // Üzenetek lekérdezése a két felhasználó között, időrendben növekvő sorrendben
        $query = "SELECT * FROM messages WHERE (fromid=$userid AND toid=$friendid) OR (fromid=$friendid AND toid=$userid) ORDER BY sent_at ASC";
        $messages = $conn->query($query);

        // Csak az üzenetek számát adja vissza, ha a countonly paraméter be van állítva
        if (isset($_GET['countonly']) && $_GET['countonly'] == 1) {
            echo $messages->num_rows;
            exit;
        }

        // Felhasználónevek lekérdezése a két felhasználóhoz
        $userQuery = $conn->query("SELECT id, username FROM users WHERE id IN ($userid, $friendid)");
        $usernames = [];
        while ($row = $userQuery->fetch_assoc()) {
            $usernames[$row['id']] = htmlspecialchars($row['username']);
        }

        // Ha vannak üzenetek
        if ($messages->num_rows > 0) {
            while ($message = $messages->fetch_assoc()) {
                // Meghatározza, hogy ki küldte az üzenetet (Te vagy a barát neve)
                $sender = ($message['fromid'] == $userid) ? "Te" : $usernames[$message['fromid']];
                // Üzenet megjelenítése megfelelő stílussal
                echo '<div class="' . ($message['fromid'] == $userid ? 'my-message' : 'friend-message') . '">';
                echo '<p><strong>' . $sender . ':</strong> ' . htmlspecialchars($message['content']) . '</p>';
                echo '</div>';
            }
        } else {
            // Ha nincsenek üzenetek
            echo "<p>Nincsenek üzenetek.</p>";
        }
    } else {
        // Ha hiányzik a barát azonosító
        echo "<p>Hiba: hiányzó barát azonosító.</p>";
    }
?>
