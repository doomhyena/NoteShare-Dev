<?php

	// Adatbázis kapcsolat betöltése
	require "db.php";

	// Keresett kifejezés lekérése, megtisztítása
	$keresett = isset($_GET['keresett']) ? htmlspecialchars(trim($_GET['keresett'])) : '';

	// Bejelentkezett felhasználó azonosítójának lekérése sütiből
	$loggedInUserId = $_COOKIE['id'] ?? 0;

	// Fájlok kereséséhez SQL lekérdezés alapja
	$sqlFiles = "SELECT * FROM files WHERE name LIKE '%$keresett%'";

	// Feltételek tömb inicializálása
	$conditions = [];

	// Ha van keresett kifejezés, feltétel hozzáadása név, tantárgy vagy címke alapján
	if (!empty($keresett)) {
		$safeKeresett = $conn->real_escape_string($keresett);
		$conditions[] = "(name LIKE '%$safeKeresett%' OR subject LIKE '%$safeKeresett%' OR tags LIKE '%$safeKeresett%')";
	}

	// Ha van értékelés szűrő, feltétel hozzáadása
	if (isset($_GET['rating']) && $_GET['rating'] !== '') {
		$rating = (int)$_GET['rating'];
		$conditions[] = "rating = $rating";
	}
	// Ha nincs keresés, ne adjon vissza semmit
	if (empty($conditions)) {
    exit('<p class="search-text">Kezdj el gépelni...</p>');
}

	// WHERE záradék összeállítása a feltételekből
	$whereClause = '';
	if (!empty($conditions)) {
		$whereClause = 'WHERE ' . implode(' AND ', $conditions);
	}

	// Fájlok lekérdezése a feltételek alapján
	$sqlFiles = "SELECT * FROM files $whereClause";
	$resultFiles = $conn->query($sqlFiles);

	// Talált fájlok kilistázása, letöltési lehetőséggel
	while ($file = $resultFiles->fetch_assoc()) {
		// Fájl neve és letöltési link megjelenítése
echo '
<div class="search-card">
    <div class="search-content">
        <p>' . htmlspecialchars($file['name']) . '</p>
    </div>
    <a class="download-icon" href="assets/php/download.php?id=' . (int)$file['id'] . '" title="Letöltés">
        <img src="assets/img/download-icon.png" alt="Letöltés" />
    </a>
</div>';
	}

	// Felhasználók keresése a keresett név alapján, kivéve a bejelentkezett felhasználót
$sqlUsers = "SELECT * FROM users WHERE username LIKE '%$keresett%' AND id != $loggedInUserId";
$resultUsers = $conn->query($sqlUsers);

while ($user = $resultUsers->fetch_assoc()) {
    $userId = (int)$user['id'];

    // Ellenőrzi, hogy már barátok-e
    $sqlFriendCheck = "SELECT * FROM friends WHERE (fromid = $loggedInUserId AND toid = $userId) OR (fromid = $userId AND toid = $loggedInUserId)";
    $friendCheck = $conn->query($sqlFriendCheck);

    echo '<form class="user search-card search-user-card" method="post" action="assets/php/add_friend.php">';
    echo '<p>' . htmlspecialchars($user['username']) . '</p>';

    // Ha még nem barátok, megjeleníti a jelölés gombot
    if ($friendCheck->num_rows === 0) {
        echo '<input type="hidden" name="toid" value="' . $userId . '">';
        echo '<button type="submit" class="friend-btn" name="add-friend-btn" onclick="this.classList.add(\'added\')">Jelölés</button>';
    } else {
        echo '<span style="color:green;">✔ Már barátok vagytok</span>';
    }

    echo '</form>';
}
?>