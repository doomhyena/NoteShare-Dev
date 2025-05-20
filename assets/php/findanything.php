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
		$conditions[] = "(name LIKE '%$safeKeresett%' OR subject LIKE '%$safeKeresett%' OR tag LIKE '%$safeKeresett%')";
	}

	// Ha van értékelés szűrő, feltétel hozzáadása
	if (isset($_GET['rating']) && $_GET['rating'] !== '') {
		$rating = (int)$_GET['rating'];
		$conditions[] = "rating = $rating";
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
			<form class="user" method="post" action="../../search.php?name=' . htmlspecialchars($file['name']) . '">
				<label>' . htmlspecialchars($file['name']) . '</label>
			</form>
			<a href="download.php?id=' . (int)$file['id'] . '">Letöltés</a>
		';
	}

	// Felhasználók keresése a keresett név alapján, kivéve a bejelentkezett felhasználót
	$sqlUsers = "SELECT * FROM users WHERE username LIKE '%$keresett%' AND id != $loggedInUserId";
	$resultUsers = $conn->query($sqlUsers);

	// Talált felhasználók kilistázása, barátként jelölés lehetőségével
	while ($user = $resultUsers->fetch_assoc()) {
		$userId = (int)$user['id'];

		echo '
			<form class="user" method="post" action="search.php?userid=' . $userId . '">
				<label>' . htmlspecialchars($user['username']) . '</label>
		';

		// Ellenőrzi, hogy már barátok-e
		$sqlFriendCheck = "SELECT * FROM friends WHERE (fromid = $loggedInUserId AND toid = $userId) OR (fromid = $userId AND toid = $loggedInUserId)";
		$friendCheck = $conn->query($sqlFriendCheck);

		// Ha még nem barátok, megjeleníti a barátként jelölés gombot
		if ($friendCheck->num_rows === 0) {
			echo '<form method="post" action="add_friend.php">';
			echo '<input type="hidden" name="friend_id" value="' . $userId . '">';
			echo '<input type="submit" name="add-friend-btn" value="Jelölés">';
		}

		echo '</form>';
	}
?>