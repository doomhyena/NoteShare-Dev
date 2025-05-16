<?php

	require "db.php";

	$keresett = isset($_GET['keresett']) ? htmlspecialchars(trim($_GET['keresett'])) : '';
	$loggedInUserId = $_COOKIE['id'] ?? 0;

	$sqlFiles = "SELECT * FROM files WHERE name LIKE '%$keresett%'";
	$conditions = [];

	if (!empty($keresett)) {
		$safeKeresett = $conn->real_escape_string($keresett);
		$conditions[] = "(name LIKE '%$safeKeresett%' OR subject LIKE '%$safeKeresett%' OR tag LIKE '%$safeKeresett%')";
	}

	if (isset($_GET['rating']) && $_GET['rating'] !== '') {
		$rating = (int)$_GET['rating'];
		$conditions[] = "rating = $rating";
	}

	$whereClause = '';
	if (!empty($conditions)) {
		$whereClause = 'WHERE ' . implode(' AND ', $conditions);
	}

	$sqlFiles = "SELECT * FROM files $whereClause";
	$resultFiles = $conn->query($sqlFiles);

	while ($file = $resultFiles->fetch_assoc()) {
		echo '
			<form class="user" method="post" action="../../search.php?name=' . htmlspecialchars($file['name']) . '">
				<label>' . htmlspecialchars($file['name']) . '</label>
			</form>
			<a href="download.php?id=' . (int)$file['id'] . '">Letöltés</a>
		';
	}


	$sqlUsers = "SELECT * FROM users WHERE username LIKE '%$keresett%' AND id != $loggedInUserId";
	$resultUsers = $conn->query($sqlUsers);

	while ($user = $resultUsers->fetch_assoc()) {
		$userId = (int)$user['id'];

		echo '
			<form class="user" method="post" action="search.php?userid=' . $userId . '">
				<label>' . htmlspecialchars($user['username']) . '</label>
		';

		$sqlFriendCheck = "SELECT * FROM friends WHERE (fromid = $loggedInUserId AND toid = $userId) OR (fromid = $userId AND toid = $loggedInUserId)";
		$friendCheck = $conn->query($sqlFriendCheck);

		if ($friendCheck->num_rows === 0) {
			echo '<form method="post" action="add_friend.php">';
			echo '<input type="hidden" name="friend_id" value="' . $userId . '">';
			echo '<input type="submit" name="add-friend-btn" value="Jelölés">';
		}

		echo '</form>';
	}

?>
