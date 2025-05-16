<?php
    $sql = "SELECT * FROM notifys WHERE toid = " . intval($user['id']) . " AND readed = 0";
    $founded_notify = $conn->query($sql);
    $notify_number = $founded_notify ? mysqli_num_rows($founded_notify) : 0;

    echo '
    <nav>
        <ul>
            <li><a href="index.php">Főoldal</a></li>
            <li><a href="upload.php">Feltöltés</a></li>
            <li><a href="profile.php?userid=' . $user['id'] . '">Profilom</a></li>
            <li><a href="search.php">Keresés</a></li>
            <li><a href="notify.php">Értesítések (' . $notify_number . ')</a></li>
            <li><a href="messages.php">Üzenetek</a></li>
            ';
            if (isset($user['admin']) && $user['admin'] == 1) {
                echo '<li><a href="admin_panel.php">Admin Panel</a></li>';
            }
            echo '<li><a href="assets/php/logout.php">Kijelentkezés</a></li>
        </ul>
    </nav>
    ';
    
?>