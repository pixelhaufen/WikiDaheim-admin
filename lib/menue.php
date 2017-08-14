<?php

function menue()
{
	global $config;
	$settings = "";
	
	if(isset($_GET["settings"]))
	{
		$settings = $_GET["settings"];
	}
	
	echo '<p>';
		if ($settings == ""){echo "<b>";}
		echo '<a href="index.php" class="menue">WikiDaheim</a>';
		if ($settings == ""){echo "</b>";}
		echo ' :: ';
		
		if ($settings == "wiki"){echo "<b>";}
		echo '<a href="index.php?settings=wiki" class="menue">wiki</a>';
		if ($settings == "wiki"){echo "</b>";}
		echo ' :: ';
		
		if ($settings == "list"){echo "<b>";}
		echo '<a href="index.php?settings=list" class="menue">list</a>';
		if ($settings == "list"){echo "</b>";}
		echo ' :: ';
		
		if ($settings == "commons"){echo "<b>";}
		echo '<a href="index.php?settings=commons" class="menue">commons</a>';
		if ($settings == "commons"){echo "</b>";}
		echo ' :: ';
		
		echo '<a href="index.php?logout=now" class="menue">logout</a>';
	echo '</p>';
}


?>