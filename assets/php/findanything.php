<?php

	require "cfg.php";
	ini_set('display_errors', 1);
	error_reporting(E_ALL);


	$keresett = isset($_GET['keresett']) ? htmlspecialchars(trim($_GET['keresett'])) : '';
	$loggedInUserId = $_COOKIE['id'] ?? 0;

	$sqlFiles = "SELECT * FROM files WHERE name LIKE '%$keresett%'";
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
			echo '<input type="submit" name="add-friend-btn" value="Jelölés">';
		}

		echo '</form>';
	}

?>
