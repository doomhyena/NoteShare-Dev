<?php 

	session_start();
	session_destroy();

	if (isset($_COOKIE['id'])) {
		setcookie('id', '', time() - 3600, '/'); // Expire the cookie
	}
	
	header("Location: ../../index.php");

?>