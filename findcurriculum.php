<?php 

    require "assets/php/cfg.php";

    if (!isset($_GET['keresett']) || trim($_GET['keresett']) === '') {
        echo '<p>Kérlek, adj meg egy keresési kifejezést!</p>';
    }

	$sql = "SELECT * FROM users WHERE username LIKE '%$_GET[keresett]%' AND id != $_COOKIE[id]";
	$found_curriculum = $conn->query($sql);

    if ($found_curriculum->num_rows === 0) {
        echo '<p>Nincs találat a keresésre.</p>';
    } else {
        while ($anyag = $found_curriculum->fetch_assoc()) {
            $folder = getcwd();
            $user = isset($anyag['username']) ? ['username' => $anyag['username']] : ['username' => 'unknown'];
            $file_name = isset($anyag['name']) ? $anyag['name'] : 'unknown_file';
            $path = $folder . "\\roles\\users\\" . $user['username'] . "\\" . $file_name;
            $sql = "SELECT files.*, users.username FROM files INNER JOIN users ON files.userid = users.id ORDER BY files.id DESC";
            $result = $conn->query($sql);

            while ($file = $result->fetch_assoc()) {
                echo "<div>";
                echo "<h4>" . htmlspecialchars($file['name']) . "</h4>";
                echo "<iframe src='roles/users/" . htmlspecialchars($file['username']) . "/" . htmlspecialchars($file['tn_name']) . "' width='600' height='400'></iframe>";
                echo "<a href='assets/php/download.php?id=" . htmlspecialchars($file['id']) . "'>Letöltés</a>";
                echo "</div>";
            }
        }
    }

?>