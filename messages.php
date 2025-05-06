<?php 

    require "assets/php/cfg.php";
    if (!isset($_COOKIE['id'])) {
        header("Location: reg.php");
    }

    $sql = "SELECT * FROM users WHERE id='" . intval($_COOKIE['id']) . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
        $toid = intval($_POST['toid']);
        $message = $conn->real_escape_string($_POST['message']);
        $fromid = intval($_COOKIE['id']);
        $sql = "INSERT INTO messages (fromid, toid, content, sent_at) VALUES ($fromid, $toid, '$message', NOW())";
        if ($conn->query($sql)) {
            header("Location: messages.php?friendid=$toid");
            exit;
        } else {
            echo "<p>Hiba történt az üzenet küldése közben.</p>";
        }
    }

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Üzenetek</title>
    <meta charset="UTF-8">
    <meta name="description" content="Iskolai jegyzeteket megosztó oldal">
    <meta name="keywords" content="iskola, jegyzet, megosztás, tanulás">
    <meta name="author" content="Csontos Kincső, Szekeres Levente">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <li><a href="messages.php">Üzenetek</a></li>
            <li><a href="assets/php/logout.php">Kijelentkezés</a></li>
        </ul>
    </nav>
    <div class="content">
        <div class="friends">
            <?php
                $query = "SELECT * FROM friends WHERE (fromid=$_COOKIE[id] AND status=1) OR (toid=$_COOKIE[id] AND status=1)";
                $found_friends = $conn->query($query);
                while ($friendship = $found_friends->fetch_assoc()) {
                    $friendid = ($friendship['fromid'] != $_COOKIE['id']) ? $friendship['fromid'] : $friendship['toid'];
                    $query = "SELECT * FROM users WHERE id=$friendid";
                    $found_friend = $conn->query($query);
                    $friend = $found_friend->fetch_assoc();
            ?>
                <div class="friend">
                    <a href="messages.php?friendid=<?= $friendid; ?>"><?= htmlspecialchars($friend['username']); ?></a>
                </div>
            <?php } ?>
        </div>
        <div class="chat">
            <?php if (isset($_GET['friendid'])): ?>
                <?php
                    $friendid = intval($_GET['friendid']);
                    $query = "SELECT * FROM users WHERE id=$friendid";
                    $found_friend = $conn->query($query);
                    $friend = $found_friend->fetch_assoc();
                ?>
                <a class="friend-name"><?= htmlspecialchars($friend['username']); ?></a>
                <div class="messages"></div>
                <form method="post">
                    <input type="hidden" name="toid" value="<?= $friendid; ?>">
                    <input type="text" name="message" placeholder="Írj egy üzenetet...">
                    <input type="submit" value="Küldés">
                </form>
            <?php else: ?>
                <p>Válassz egy barátot az üzenetküldéshez.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>