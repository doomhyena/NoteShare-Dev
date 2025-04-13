<?php 

	require "config.php";
	
	$sql = "SELECT * FROM files WHERE name LIKE '%$_GET[keresett]%'";
	$founded_curriculum = $conn->query($lekerdezes);
	while($curriculum = $founded_curriculum->fetch_assoc()){
	
		echo '<form class="user" method="post" action="search.php?name='.$curriculum['name'].'">
				<label>'.$curriculum['username'].'</label>';
		echo '</form>';
	
	}

?>