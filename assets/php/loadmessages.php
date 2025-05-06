<?php
    require "cfg.php";

    if (!isset($_COOKIE['id'])) {
        header("Location: reg.php");
        exit;
    }

    if (isset($_GET['friendid'])) {
        $friendid = intval($_GET['friendid']);
        $userid = intval($_COOKIE['id']);

        $query = "SELECT * FROM messages WHERE (fromid=$userid AND toid=$friendid) OR (fromid=$friendid AND toid=$userid) ORDER BY sent_at ASC";
        $messages = $conn->query($query);

        if (isset($_GET['countonly']) && $_GET['countonly'] == 1) {
            echo $messages->num_rows;
            exit;
        }

        $userQuery = $conn->query("SELECT id, username FROM users WHERE id IN ($userid, $friendid)");
        $usernames = [];
        while ($row = $userQuery->fetch_assoc()) {
            $usernames[$row['id']] = htmlspecialchars($row['username']);
        }

        if ($messages->num_rows > 0) {
            while ($message = $messages->fetch_assoc()) {
                $sender = ($message['fromid'] == $userid) ? "Te" : $usernames[$message['fromid']];
                echo '<div class="' . ($message['fromid'] == $userid ? 'my-message' : 'friend-message') . '">';
                echo '<p><strong>' . $sender . ':</strong> ' . htmlspecialchars($message['content']) . '</p>';
                echo '</div>';
            }
        } else {
            echo "<p>Nincsenek üzenetek.</p>";
        }
    } else {
        echo "<p>Hiba: hiányzó barát azonosító.</p>";
    }
?>
