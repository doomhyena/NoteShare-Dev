
<?php 
	// Megyőződik arról, hogy a felhasználó be van jelentkezve
	if (isset($_COOKIE['id'])) {
		// Ha be van jelentkezve, törli a süti értékét
		// és beállítja a lejárati időt a múltba, hogy érvénytelenítse
		setcookie('id', '', time() - 3600, '/');
	}
	// Visszairányítja a felhasználót a főoldalra
	header("Location: ../../index.php");

?>
