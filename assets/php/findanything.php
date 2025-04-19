<?php 

	require "../../assets/php/cfg.php";
	
	$sql = "SELECT * FROM files WHERE name LIKE '%$_GET[keresett]%'";
	$founded_curriculum = $conn->query($sql);
	while($curriculum = $founded_curriculum->fetch_assoc()){
	
		echo '<form class="user" method="post" action="../../search.php?name='.$curriculum['name'].'">
				<label>'.$curriculum['name'].'</label>';
		echo '</form>';
		echo "<a href='download.php?id=" . $curriculum['id'] . "'>Letöltés</a>";
	}

		
	$sql = "SELECT * FROM users WHERE username LIKE '%$_GET[keresett]%' AND id != $_COOKIE[id]";
	$founded_user = $conn->query($sql);
	while($felhasznalo = $founded_user->fetch_assoc()){
	
		echo '<form class="user" method="post" action="search.php?userid='.$felhasznalo['id'].'">
				<label>'.$felhasznalo['username'].'</label>';
			
			// Megvizsgáljuk, hogy a bejelentkezett felhasználó és a megtalált felhasználó között volt-e már barát kérelem
			$sql = "SELECT * FROM friends WHERE fromid=$_COOKIE[id] AND toid=$felhasznalo[id] OR fromid=$felhasznalo[id] AND toid=$_COOKIE[id]";
			$talalt_baratsag = $conn->query($sql);
			
			// Ha nem, akkor írjuk ki a jelölés gombot
			if(mysqli_num_rows($talalt_baratsag) == 0){
				echo '<input type="submit" name="add-friend-btn" value="Jelölés">';
			}
				
		echo '</form>';
	
	}

?>