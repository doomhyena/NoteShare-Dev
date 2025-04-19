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

?>